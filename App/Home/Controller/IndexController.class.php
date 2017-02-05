<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
        $spwhere="student_id=".session('student_id');
        $activity = M('activity'); // 实例化activity对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $activity->join('address ON activity.address_id = address.address_id')->where($spwhere)->order('activity_dateline desc')->page($_GET['p'].',25')->select();
        $this->assign('list',$list);// 赋值数据集
        $count      = $activity->where($spwhere)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }    
}