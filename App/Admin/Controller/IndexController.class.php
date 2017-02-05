<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{
    public function index(){
        $admintype=session('admin_type');
        if (I('get.type')=='tgsp') {
            switch ($admintype) {
                case '0':
                    $spwhere="activity_zt = 1";
                    break;
                case '2':
                    $spwhere="activity_fdysp = 1 and activity_fdyname = \"".session('admin_name')."\"";
                    break;
                case '3':
                    $spwhere="activity_tzzsp = 1";
                    break;
                case '4':
                    $spwhere="activity_bwbsp = 1";
                    break;
                case '5':
                    $spwhere="activity_ldsp = 1";
                    break;
                default:
                    $this->error("对不起，您没有这个权限");
                    exit;
                    break;
            }
        }elseif (I('get.type')=='bhsp') {
            switch ($admintype) {
                case '0':
                    $spwhere="activity_zt = 0";
                    break;
                case '2':
                    $spwhere="activity_fdysp = 2 and activity_fdyname = \"".session('admin_name')."\"";
                    break;
                case '3':
                    $spwhere="activity_tzzsp = 2";
                    break;
                case '4':
                    $spwhere="activity_bwbsp = 2";
                    break;
                case '5':
                    $spwhere="activity_ldsp = 2";
                    break;
                default:
                    $this->error("对不起，您没有这个权限");
                    exit;
                    break;
            }
        }elseif (I('get.type')=='wcsp') {
            $spwhere="activity_zt = 2";
        }else{
            switch ($admintype) {
                case '0':
                    $spwhere="activity_zt = 1";
                    break;
                case '2':
                    $spwhere='activity_fdysp = 0 and activity_fdyname = "'.session('admin_name').'" and activity_zt = 1';
                    break;
                case '3':
                    $spwhere='activity_fdysp = 1 and activity_tzzsp = 0 and activity_zt = 1';
                    break;
                case '4':
                    $spwhere='activity_tzzsp = 1 and activity_bwbsp = 0 and activity_zt = 1';
                    break;
                case '5':
                    $spwhere='activity_bwbsp = 1 and activity_ldsp = 0 and activity_zt = 1';
                    break;
            }
        }
        $activity = M('activity'); // 实例化activity对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $activity->join('address ON activity.address_id = address.address_id')->where($spwhere)->order('activity_dateline desc')->page($_GET['p'].',25')->select();
        $this->assign('list',$list);// 赋值数据集
        $count      = $activity->where($spwhere)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        if (session('admin_type')==0) {
            $this->display('admin'); // 输出模板
        }else{
            $this->display(I('get.type')); // 输出模板
        }
        
    }
   
    public function tykz(){
        $admintype=session('admin_type');
        $adminname=session('admin_name');
        $activity_id=I('post.activity_id');
        $otheryj=I('post.otheryj');
        switch ($admintype) {
            case '2':
                $yj['activity_fdyyj']="情况属实，参与指导学生活动，并负责学生活动安全。".$otheryj." 同意开展。";
                $yj['activity_fdysj']=time();
                $yj['activity_fdysp']=1;
                $tomail=M('admin')->where('admin_type = 3')->getField('admin_email',true);
                break;
            case '3':
                $yj['activity_tzzyj']="情况属实，辅导员(指导)老师现场指导并负责学生安全。".$otheryj." 同意开展，请领导审批。";
                $yj['activity_tzzname']=$adminname;
                $yj['activity_tzzsj']=time();
                $yj['activity_tzzsp']=1;
                $tomail=M('admin')->where('admin_type=4')->getField('admin_email',true);
                break;
            case '4':
                $yj['activity_bwbyj']="情况属实，辅导员(指导)老师现场指导并负责学生安全。".$otheryj." 同意开展，请领导审批。";
                $yj['activity_bwbname']=$adminname;
                $yj['activity_bwbsj']=time();
                $yj['activity_bwbsp']=1;
                $tomail=M('admin')->where('admin_type=5')->getField('admin_email',true);
                break;
            case '5':
                $yj['activity_ldyj']="同意开展，辅导员(指导)老师现场指导，并负责学生安全。".$otheryj;
                $yj['activity_ldname']=$adminname;
                $yj['activity_ldsj']=time();
                $yj['activity_ldsp']=1;
                $yj['activity_zt']=2;
                break;
            default:
                $this->error("对不起，您没有这个权限");
                exit;
                break;
        }
        if (M('activity')->where("activity_id=$activity_id")->save($yj)) {
            $event='同意开展了活动ID为：'.$activity_id.'的活动';
            addevent($event);
            if ($admintype<5) {
                $data = M('activity')->join('address ON activity.address_id = address.address_id')->where("activity_id=$activity_id")->find();
                foreach ($tomail as $key => $value) {
                    $res=sendother($value,"您有新的活动审批事项",$data);
                }
            }else{
                $student_id=M('activity')->where("activity_id=$activity_id")->getField('student_id');
                $tomail=M('student')->where("student_id=$student_id")->getField('student_email');
                $res=sendstu($tomail,"你申请的活动审批完成",'你申请的活动审批完成，请尽快到综合楼402办公室领取活动申请表');
            }
            if ($res){
                $this->success("活动审批成功",U('Admin/index/index'));
            }else{
                $this->error("活动审批成功，但发送通知邮件失败",U('Admin/index/index'));
            }
        }else{
            $this->error("活动审批失败");
        }
    }

    public function bh(){
        $admintype=session('admin_type');
        $adminname=session('admin_name');
        $activity_id=I('post.activity_id');
        switch ($admintype) {
            case '2':
                $yj['activity_fdyyj']=I('post.bhyj');
                $yj['activity_fdysj']=time();
                $yj['activity_fdysp']=2;
                $yj['activity_zt']=0;
                break;
            case '3':
                $yj['activity_tzzyj']=I('post.bhyj');
                $yj['activity_tzzname']=$adminname;
                $yj['activity_tzzsj']=time();
                $yj['activity_tzzsp']=2;
                $yj['activity_zt']=0;
                break;
            case '4':
                $yj['activity_bwbyj']=I('post.bhyj');
                $yj['activity_bwbname']=$adminname;
                $yj['activity_bwbsj']=time();
                $yj['activity_bwbsp']=2;
                $yj['activity_zt']=0;
                break;
            case '5':
                $yj['activity_ldyj']=I('post.bhyj');
                $yj['activity_ldname']=$adminname;
                $yj['activity_ldsj']=time();
                $yj['activity_ldsp']=2;
                $yj['activity_zt']=0;
                break;
            default:
                $this->error("对不起，您没有这个权限");
                exit;
                break;
        }
        $res=M('activity')->where("activity_id=$activity_id")->save($yj);
        if ($res) {
            $event='驳回了活动ID为：'.$activity_id.'的活动';
            addevent($event);
            $student_id=M('activity')->where("activity_id=$activity_id")->getField('student_id');
            $tomail=M('student')->where("student_id=$student_id")->getField('student_email');
            $res=sendstu($tomail,"很抱歉，你申请的活动被驳回了",'很遗憾，你的申请被驳回了，驳回原因：'.I('post.bhyj'));
            if($res){
                $this->success("活动驳回成功");
            }else{
                $this->success("活动驳回成功，但发送通知邮件失败");
            }
        }else{
            $this->error("活动驳回失败");
        }
    }
    public function del(){
        if (session('admin_type')==0) {
            if(I('get.activity_id')){
                $activity = M('activity');
                if($activity->where('activity_id='.I('get.activity_id'))->delete()){
                    $event='删除了活动ID为：'.I('get.activity_id').'的活动';
                    addevent($event);
                    $this->success('删除活动成功');
                }else{
                    $this->error('删除活动失败');
                }
            }
        }else{
            $this->error("对不起，您没有这个权限");
        }
    }
}