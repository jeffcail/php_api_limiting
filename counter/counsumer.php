<?php

/**
 * 模拟请求
 */

require "counter.php";

$counter = new CounterLimit();

// 200 毫秒
swoole_timer_tick(200, function () use ($counter) {
    var_dump($counter->request());
});
