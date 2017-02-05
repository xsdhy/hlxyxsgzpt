<?php 
namespace Admin\Controller;
use Think\Controller;
/**
 * Admin模块公共控制器
 */
class CommonController extends Controller
{
	protected function _initialize()
	{
		if(!session('admin_username')){ //已登录或可以cookie登录
			redirect(U('Home/login/index/'));
		}
	}
}
?>