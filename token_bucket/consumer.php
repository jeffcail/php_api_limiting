<?php

require "token.php";

/**
 * 模拟请求
 */

$token = new Token();

// 800 毫秒
swoole_timer_tick(800, function () use ($token) {
    var_dump($token->get());
});