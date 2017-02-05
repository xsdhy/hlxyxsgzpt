<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class ActivityController extends CommonController {
    public function index()
    {
        $this->show();
    }

    public function send(){//
        $data=I('post.');
        if(intval(I('post.address_id'))<=0){
            $this->error('请填写活动地址');
        }
        $data['activity_kssj'] = strtotime($data['activity_kssj']);
        $data['activity_jssj'] = strtotime($data['activity_jssj']);

        $haswhere='((activity_kssj between '.$data['activity_kssj'].' and '.$data['activity_jssj'].')or(activity_jssj between '.$data['activity_kssj'].' and '.$data['activity_jssj'].')) and activity_zt != 0';
        $hasbeen=M('activity')->where($haswhere)->getField('address_id',true);
        if (in_array($data['address_id'],$hasbeen)) {
            $this->error('我们不得不非常遗憾的告诉你，在你填写申请的时候，你所申请的地址，已被申请');
        }

        $data['activity_sqr']=session("student_name");
        $data['activity_zt'] ='1';
        $data['activity_updatetime']=time();
        $data['activity_dateline']=time();
        $data['student_id']=session("student_id");
        $data['activity_fdyname']=M('student')->where("student_id=".$data['student_id'])->getField("student_fdy");
        $res=M('activity')->add($data);
        if($res){
            $event='提交了活动申请,活动ID为：'.$res;
            addevent($event);
            $data['address_name']=M('address')->where("address_id=".$data['address_id'])->getField("address_name");
            $tomail=M('admin')->where("admin_name='".$data['activity_fdyname']."'")->getField("admin_email");
            $title='您有新的活动申请。申请单位:'.$data['activity_sqdw'].';申请人:'.session("student_name");
            if(sendfdy($tomail,$title,$data)){
                $this->success('提交活动申请成功',U('Home/index/index'));
            }else{
                $this->success('提交活动申请成功，但向辅导员老师发送通知邮件失败',U('Home/index/index'));
            }
        }else{
            $this->error('提交活动申请失败，请重试!');
        }
    }

    public function address(){
        $settime=I('post.');
        $settime['activity_kssj'] = strtotime($settime['activity_kssj']);
        $settime['activity_jssj'] = strtotime($settime['activity_jssj']);
        $haswhere='((activity_kssj between '.$settime['activity_kssj'].' and '.$settime['activity_jssj'].')or(activity_jssj between '.$settime['activity_kssj'].' and '.$settime['activity_jssj'].')) and activity_zt != 0';
        $hasbeen=M('activity')->where($haswhere)->getField('address_id',true);
        $res=M('address')->where('address_stutype >='.session('student_type'))->select(); 

        if ($res && !empty($res)) {
            if ($hasbeen && !empty($hasbeen)) {
                foreach ($res as $key => $value) {
                    if (in_array($value['address_id'],$hasbeen)) {
                        unset($res[$key]);
                    }
                }
                $numbered=array();
                $res = array_merge($res, $numbered); 
            }
            $data['data']=$res;
            $data['len']=count($data['data']);
            $data['status']='1';
        }else{
            $data['status']='0';
        }
        $this->ajaxReturn($data);

    }


    
    
    
}



