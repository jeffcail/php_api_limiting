<?php

/**
 * redis 令牌桶
 */

class Token {

    private $redis;
    private $max;
    private $queue;

    private $config = array(
        "host" => "127.0.0.1",
        "port" => 9379,
        "auth" => "caicairedis123456"
    );

    public function __construct() {
        try {
            $this->redis = new Redis();
            $this->redis->connect($this->config["host"], $this->config["port"]);
            $this->redis->auth($this->config["auth"]);

            $this->queue = "api_limiting_token";
            $this->max = 10;

            // 初始化
            $this->resetToken();
        } catch (RedisException $e) {
            throw new Exception($e->getMessage());
            return false;
        }
    }

    /**
     * delivery 投递
     * @param int $num 投递令牌数量
     */
    public function delivery($num=100) {
        // 控制投递令牌数量,最大不能超过$this->max
        // 当前令牌数量
        $currentTokenNum = $this->redis->lLen($this->queue);
        // 最大数量
        $max = $this->max;

        // 投递令牌数量($num)=最大数量-当前令牌数量
        $num = $max >= $currentTokenNum+$num ? $num : $max-$currentTokenNum;

        if ($num>0) {
            $token = array_fill(0, $num, 1);
            foreach ($token as $val) {
                $this->redis->lPush($this->queue, $val);
            }
        }
        return false;
    }

    /**
     * get 令牌
     * @return bool
     */
    public function get() {
        return $this->redis->rPop($this->queue) ? true : false;
    }

    /**
     * 重置 令牌
     */
    public function resetToken() {
        $this->redis->del($this->queue);
        $this->delivery($this->max);
    }
}
