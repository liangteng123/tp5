<?php
header("content-type:text/html; charset=utf8");
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('BIND_MODULE','home');
define('DOCUMENT_ROOT',dirname(__FILE__));
require __DIR__ . '/../thinkphp/start.php';
