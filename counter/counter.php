<?php

/**
 * 计数器方法
 */

class CounterLimit {

    // 第一次请求时间
    private $first_req_time;
    // 已请求次数
    private $req_num = 0;
    // 规定时间内请求的总次数
    private $max = 10;
    // 规定的窗口时间 s
    private $t = 60;

    public function __construct() {
        $this->first_req_time = time();
    }

    public function request() {
        $now = time();
        // 超出规定的窗口时间，重置第一次请求时间和请求总次数
        if ($now > $this->first_req_time+$this->t) {
            $this->first_req_time = $now;
            $this->req_num = 1;
            return true;
        } else {
            if ($this->req_num < $this->max) {
                $this->req_num++;
                return true;
            } else {
                return false;
            }
        }
    }
}
