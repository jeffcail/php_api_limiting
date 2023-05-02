<?php

/**
 * 投递
 */

require "token.php";

$toDeliver = new Token();

// 投递
swoole_timer_tick(1000, function () use ($toDeliver) {
   var_dump($toDeliver->delivery(100));
});
