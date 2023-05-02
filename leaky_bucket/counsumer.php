<?php

require "token.php";

/**
 * 模拟请求
 */

$l = new LeakyBucket();

// 100 毫秒
swoole_timer_tick(100, function () use ($l) {
    var_dump($l->request());
});
