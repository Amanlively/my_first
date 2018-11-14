<?php
use Workerman\Worker;
require __DIR__ .'/vendor/workerman/workerman-for-win/autoloader.php';
// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("websocket://0.0.0.0:2000");

// 启动4个进程对外提供服务
$http_worker->count = 4;

// 接收到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection, $data)
{
    // 向浏览器发送hello world
    $connection->send('hello world');
};
Worker::runAll();



