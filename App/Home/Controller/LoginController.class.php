<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->show();
    }
    public function login(){
        if( !I('post.username') || !I('post.password')){
            $this->error('请填写完整账号、密码');
        }
        if (session('cwcs')>4) {
            $this->error('你多次输入错误密码，现在被禁止登录，请稍后重试');
        }
        /*
        if( !I('post.username') || !I('post.password') ||!I('post.verifyCode') )
            $this->error('请填写完整账号、密码');
        if (!$this->check_verify(I('post.verifyCode'))) {
            $this->error('验证码不正确');
        }
        */
        if (preg_match("/^(\d{11})$/",I('post.username'))){
            $tj='student_number =\''.I('post.username').'\'';
            $password=md5('xsdhy'.md5(I('post.password')).'susestu');
            $res=M('Student')->where($tj)->find();
            if($res){
                if ($res['student_password']==$password) {
                    session('student_number',I('post.username'));
                    session('student_type',$res['student_type']);
                    session('student_id',$res['student_id']);
                    session('student_name',$res['student_name']);
                    session('student_class',$res['student_class']);
                    addevent("登录系统");
                    redirect(U('Home/index/index/'));
                }else{
                    $cwcs=session('cwcs')?session('cwcs'):1;
                    $cwcs++;
                    session('cwcs',$cwcs);
                    $this->error('密码不正确');
                }
            }else{
                $this->error('学生账号'.I('post.username').'不存在');
            }
        }else{
            $password=md5('xsdhy'.md5(I('post.password')).'suse');
            $tj='admin_username =\''.I('post.username').'\'';
            $res=M('admin')->where($tj)->find();
            if($res){
                if ($res['admin_password']==$password) {
                    session('admin_username',I('post.username'));
                    session('admin_id',$res['admin_id']);
                    session('admin_name',$res['admin_name']);
                    session('admin_type',$res['admin_type']);
                    addevent("登录系统");
                    redirect(U('Admin/index/index/'));
                }else{
                    $cwcs=session('cwcs')?session('cwcs'):1;
                    $cwcs++;
                    session('cwcs',$cwcs);
                    $this->error('密码不正确');
                }
            }else{
                $this->error('老师账号'.I('post.username').'不存在');
            }
        }

        
    }
    /**
     * 应用登出
     */
    public function logout()
    {
        session(null);
        $this->success('成功退出',U('Home/login/index')); //登录成功   
    }
    
    
    
}