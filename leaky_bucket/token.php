<?php

/**
 * 漏桶算法
 */

class LeakyBucket {


    // 上一次请求时间
    private $last_req_time;

    // 桶的容量
    private $cap = 20;

    // 流出水速 个/s
    private $rate = 10;

    // 当前水量 当前累计的请求数
    private $currentWater = 0;

    public function __construct()
    {
        $this->last_req_time = time();
    }

    public function request()
    {
        $now = time();
        // 计算剩余水量
        $water = max(0, $this->currentWater - ($now - $this->last_req_time) * $this->rate);
        $this->currentWater = $water;
        $this->last_req_time = $now;
        if ($water < $this->cap) {
            $this->currentWater+1;
            return true;
        } else {
            // 桶满，拒绝请求
            return false;
        }
    }


}