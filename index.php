<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
//define('BIND_MODULE', 'Home'); // 绑定Home模块到当前入口文件
//define('BIND_CONTROLLER','Index'); // 绑定Index控制器到当前入口文件
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

define('APP_PATH','./App/');
define('RUNTIME_PATH','./Runtime/');
require './ThinkPHP/ThinkPHP.php';