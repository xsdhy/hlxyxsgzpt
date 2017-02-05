<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class UserController extends CommonController {
    public function index(){
        $tj='admin_id =\''.session('admin_id').'\'';
        $res=M('Admin')->where($tj)->find();
        $this->assign('res',$res);// 赋值分页输出
        $this->display(); // 输出模板
    }
    public function email(){
        $data['admin_id']=session('admin_id');
        $data['admin_email']=I('post.admin_email');
        $res = M("admin")->save($data);
        if ($res){
            $event='修改了邮箱';
            addevent($event);
            $this->success("更新邮箱成功",U('Admin/index/index'));
        }else{
            $this->error("更新邮箱失败，请重试");
        }
    }

    public function password(){
        $tj='admin_id =\''.session('admin_id').'\'';
        $password=md5('xsdhy'.md5(I('post.password')).'suse');
        $newpassword=md5('xsdhy'.md5(I('post.admin_password')).'suse');
        if (M('admin')->where($tj)->getField('admin_password')==$password) {
            if (M("admin")->where($tj)->setField('admin_password',$newpassword)){
                $event='修改了密码';
                addevent($event);
                $this->success("更新密码成功",U('Admin/index/index'));
            }else{
                $this->error("更新密码失败，请重试");
            }
        }else{
            $this->error('原密码不正确');
        }
    }

}