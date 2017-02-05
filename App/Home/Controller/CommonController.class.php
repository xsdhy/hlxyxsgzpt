<?php 
namespace Home\Controller;
use Think\Controller;

/**
 * Admin模块公共控制器
 */
class CommonController extends Controller
{
	protected function _initialize()
	{
		if(!session('student_number')){ //已登录或可以cookie登录
			redirect(U('Home/login/index/'));
		}
	}
}
?>