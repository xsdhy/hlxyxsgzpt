<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class UserController extends CommonController {
    public function index(){
        $tj='student_id =\''.session('student_id').'\'';
        $res=M('student')->where($tj)->find();
        $this->assign('res',$res);// 赋值分页输出
        $this->display(); // 输出模板
    }
    public function email(){
        $data['student_id']=session('student_id');
        $data['student_email']=I('post.student_email');
        $res = M("student")->save($data);
        if (false !== $res){
            $event='将邮箱修改为:'.$data['student_email'];
            addevent($event);
            $this->success("更新邮箱成功",U('Home/index/index'));
        }else{
            $this->error("更新邮箱失败，请重试");
        }
    }

    public function password(){
        $tj='student_id =\''.session('student_id').'\'';
        $password=md5('xsdhy'.md5(I('post.password')).'susestu');
        $newpassword=md5('xsdhy'.md5(I('post.student_password')).'susestu');
        if (M('student')->where($tj)->getField('student_password')==$password) {
            if (M("student")->where($tj)->setField('student_password',$newpassword)){
                addevent("修改密码");
                $this->success("更新密码成功",U('Home/index/index'));
            }else{
                $this->error("更新密码失败，请重试");
            }
        }else{
            $this->error('原密码不正确');
        }
    }





}