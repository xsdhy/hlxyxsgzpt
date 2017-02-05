<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class XqController extends CommonController {
    public function dy(){
        $id=I('get.activity_id');
        $activity = M('activity')->join('address ON activity.address_id = address.address_id')->where("activity_id=$id")->find();
        $this->assign('a',$activity);
        $this->display();
    }
    public function index(){
        $id=I('get.activity_id');
        $activity = M('activity')->join('address ON activity.address_id = address.address_id')->where("activity_id=$id")->find();
        $stu=M('student')->where("student_id='".$activity['student_ids']."'")->find();
        $this->assign('a',$activity);
        $this->assign('stu',$stu);
        $this->display();
    }

}