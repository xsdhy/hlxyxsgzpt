<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class XqController extends CommonController {
    public function index(){
        $id=I('get.activity_id');
        $activity = M('activity')->join('address ON activity.address_id = address.address_id')->where("activity_id=$id")->find();
        $this->assign('a',$activity);
        $this->display();
    }

}