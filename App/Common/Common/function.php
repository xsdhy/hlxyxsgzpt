<?php  

function addevent($content){
    $data['user_id']=session('student_id')?session('student_id'):session('admin_id');
    $data['event_connect']=$content;
    $data['event_ip']=get_client_ip();
    $data['event_time']=time();
    $res=M('event')->add($data);
}

function email($to,$title,$content){
    import("ORG.Util.mail");
    $smtp = new smtp(C('smtpserver'),C('smtpserverport'),true,C('smtpuser'),C('smtppass'));
    $smtp->debug = false;
    if ($smtp->sendmail($to,C('smtpname'),C('smtpusermail'), $title, $content,'HTML')) {
        return true;
    }else{
        return false;
    }
}


function sendfdy($to, $title, $content){
    $content['activity_kssj']=date("Y-m-d H:i:s",$content['activity_kssj']);
    $content['activity_jssj']=date("Y-m-d H:i:s",$content['activity_jssj']);
    $data='<section style="text-align: center; font-size: 1em; vertical-align: middle; white-space: nowrap;">
        <section class="wxqq-borderTopColor wxqq-borderBottomColor" style="margin: 0 1em; white-space: nowrap; height: 0;border-top: 1.5em solid #00BBEC; border-bottom: 1.5em solid #00BBEC; border-left: 1.5em solid transparent; border-right: 1.5em solid transparent;"></section>
        <section style="margin: -2.75em 1.65em; white-space: nowrap; height: 0;border-top: 1.3em solid #ffffff; border-bottom: 1.3em solid #ffffff; border-left: 1.3em solid transparent; border-right: 1.3em solid transparent;"></section>
        <section class="wxqq-borderTopColor wxqq-borderBottomColor" style="margin: 0.45em 2.1em; white-space: nowrap; height: 0; vertical-align: middle;border-top: 1.1em solid #00BBEC; border-bottom: 1.1em solid #00BBEC; border-left: 1.1em solid transparent; border-right: 1.1em solid transparent;">
            <section style="padding: 0 1em; margin-top: -0.5em; font-size: 1.2em; line-height: 1em; color: white; white-space: nowrap;max-height: 1em; overflow: hidden;">
                学生活动申请表
            </section>
        </section>
    </section>
    <br/>
    <table data-sort="sortDisabled">
        <tbody>
            <tr class="firstRow">
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    申请单位
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_sqdw'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    申请人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_sqr'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    联系方式
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_tel'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动时间
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_kssj'].'至'.$content['activity_jssj'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动地点
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['address_name'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    参加人数
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_cjrs'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动组织者
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_zzz'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    安全负责人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_aqfzr'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    卫生负责人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_wsfzr'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);" rowspan="2" colspan="1">
                    活动内容与方案
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);" rowspan="1" colspan="2">
                    活动的详细流程
                </td>
                <td valign="top" rowspan="2" colspan="1" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动安全方案
                </td>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    结合开展的活动制定安全方案
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);" height="237">
                    '.$content['activity_nram'].'
                </td>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);" height="237">
                    '.$content['activity_aqya'].'
                </td>
            </tr>
        </tbody>
    </table>
    <p></p>
    <p>
        <section style="margin-top: 5px; margin-right: 5px; padding: 25px; border: 1.5px solid rgb(198, 198, 199); line-height: 24px; box-shadow: rgb(165, 165, 165) 5px 5px 2px; border-radius: 30px; text-align: center; background-color: rgb(237, 237, 237);">
            <section style="margin: 0px; padding: 10px 5px; border: 2px solid rgb(0, 0, 0); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; border-radius: 20px; background-color: rgb(0, 0, 0);">
                <a href="http://testweb.suse.edu.cn/xsjlpt/sp/index.php" target="_self"><font color="#ffffff"><span style="font-size: 18px;"><b>点击进入审批系统</b></span></font></a>
            </section>
        </section>
    </p>';

    if (email($to,$title,$data)) {
        return true;
    }else{
        return false;
    }
}

function sendother($to, $title, $content){
    $content['activity_kssj']=date("Y-m-d H:i:s",$content['activity_kssj']);
    $content['activity_jssj']=date("Y-m-d H:i:s",$content['activity_jssj']);
    if (!empty($content['activity_fdysj'])) {
        $content['activity_fdysj']=date("Y-m-d H:i:s",$content['activity_fdysj']);
    }
    if (!empty($content['activity_tzzsj'])) {
        $content['activity_tzzsj']=date("Y-m-d H:i:s",$content['activity_tzzsj']);
    }
    if (!empty($content['activity_bwbsj'])) {
        $content['activity_bwbsj']=date("Y-m-d H:i:s",$content['activity_bwbsj']);
    }
    if (!empty($content['activity_ldsj'])) {
        $content['activity_ldsj']=date("Y-m-d H:i:s",$content['activity_ldsj']);
    }
    $data='<section style="text-align: center; font-size: 1em; vertical-align: middle; white-space: nowrap;">
        <section class="wxqq-borderTopColor wxqq-borderBottomColor" style="margin: 0 1em; white-space: nowrap; height: 0;border-top: 1.5em solid #00BBEC; border-bottom: 1.5em solid #00BBEC; border-left: 1.5em solid transparent; border-right: 1.5em solid transparent;"></section>
        <section style="margin: -2.75em 1.65em; white-space: nowrap; height: 0;border-top: 1.3em solid #ffffff; border-bottom: 1.3em solid #ffffff; border-left: 1.3em solid transparent; border-right: 1.3em solid transparent;"></section>
        <section class="wxqq-borderTopColor wxqq-borderBottomColor" style="margin: 0.45em 2.1em; white-space: nowrap; height: 0; vertical-align: middle;border-top: 1.1em solid #00BBEC; border-bottom: 1.1em solid #00BBEC; border-left: 1.1em solid transparent; border-right: 1.1em solid transparent;">
            <section style="padding: 0 1em; margin-top: -0.5em; font-size: 1.2em; line-height: 1em; color: white; white-space: nowrap;max-height: 1em; overflow: hidden;">
                学生活动申请表
            </section>
        </section>
    </section>
    <br/>
    <table data-sort="sortDisabled">
        <tbody>
            <tr class="firstRow">
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    申请单位
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_sqdw'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    申请人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_sqr'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    联系方式
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_tel'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动时间
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_kssj'].'至'.$content['activity_jssj'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动地点
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['address_name'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    参加人数
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_cjrs'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动组织者
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_zzz'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    安全负责人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_aqfzr'].'
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    卫生负责人
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    '.$content['activity_wsfzr'].'
                </td>
            </tr>
            <tr>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);" rowspan="2" colspan="1">
                    活动内容与方案
                </td>
                <td valign="top" style="word-break: break-all; border: 1px solid rgb(0,0,0);" rowspan="1" colspan="2">
                    活动的详细流程
                </td>
                <td valign="top" rowspan="2" colspan="1" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    活动安全方案
                </td>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);">
                    结合开展的活动制定安全方案
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);" height="237">
                    '.$content['activity_nram'].'
                </td>
                <td valign="top" rowspan="1" colspan="2" style="word-break: break-all; border: 1px solid rgb(0,0,0);" height="237">
                    '.$content['activity_aqya'].'
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="2" colspan="1" style="border: 1px solid rgb(0, 0, 0);" width="undefined">
                    辅导员(指导)老师意见
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="104">
                '.$content['activity_fdyyj'].'
                </td>
                <td valign="top" rowspan="2" colspan="1" style="border: 1px solid rgb(0, 0, 0);" width="undefined">
                    学生工作（团总支）办公室意见
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="104">
                '.$content['activity_tzzyj'].'
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="28">
                '.$content['activity_fdyname'].$content['activity_fdysj'].'
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="28">
                '.$content['activity_tzzname'].$content['activity_tzzsj'].'
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="2" colspan="1" style="border: 1px solid rgb(0, 0, 0);" width="undefined">
                    保卫办公室意见
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="103">
                '.$content['activity_bwbyj'].'
                </td>
                <td valign="top" rowspan="2" colspan="1" style="border: 1px solid rgb(0, 0, 0);" width="undefined">
                    活动分管领导意见
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="103">
                '.$content['activity_ldyj'].'
                </td>
            </tr>
            <tr>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="37">
                '.$content['activity_bwbname'].$content['activity_bwbsj'].'
                </td>
                <td valign="top" rowspan="1" colspan="2" style="border: 1px solid rgb(0, 0, 0);" height="37">
                '.$content['activity_ldname'].$content['activity_ldsj'].'
                </td>
            </tr>
        </tbody>
    </table>
    <p></p>
    <p>
        <section style="margin-top: 5px; margin-right: 5px; padding: 25px; border: 1.5px solid rgb(198, 198, 199); line-height: 24px; box-shadow: rgb(165, 165, 165) 5px 5px 2px; border-radius: 30px; text-align: center; background-color: rgb(237, 237, 237);">
            <section style="margin: 0px; padding: 10px 5px; border: 2px solid rgb(0, 0, 0); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; border-radius: 20px; background-color: rgb(0, 0, 0);">
                <a href="http://testweb.suse.edu.cn/xsjlpt/sp/index.php" target="_self"><font color="#ffffff"><span style="font-size: 18px;"><b>点击进入审批系统</b></span></font></a>
            </section>
        </section>
    </p>';
    if (email($to,$title,$data)) {
        return true;
    }else{
        return false;
    }

}


function sendstu($to, $title, $content){


$data='<fieldset class="wxqq-borderTopColor wxqq-borderRightColor wxqq-borderBottomColor wxqq-borderLeftColor" style="margin: 0px; padding: 5px; border: 1px solid rgb(0, 187, 236);">
    <legend style="margin: 0px 10px;">
        <font color="#ffffff"><span style="font-size: 14px; background-color: rgb(0, 187, 236);"><b>学生活动申请</b></span></font>
    </legend>
    <blockquote style="margin: 0px; padding: 10px; ">
        <p> '.$content.'</p>
    </blockquote>
</fieldset>
<section style="margin-top: 5px; margin-right: 5px; padding: 25px; border: 1.5px solid rgb(198, 198, 199); line-height: 24px; box-shadow: rgb(165, 165, 165) 5px 5px 2px; border-radius: 30px; text-align: center; background-color: rgb(237, 237, 237);">
    <section style="margin: 0px; padding: 10px 5px; border: 2px solid rgb(0, 0, 0); border-image-source: initial; border-image-slice: initial; border-image-width: initial; border-image-outset: initial; border-image-repeat: initial; border-radius: 20px; background-color: rgb(0, 0, 0);">
        <a href="http://testweb.suse.edu.cn/xsjlpt/sp/index.php" target="_self"><font color="#ffffff"><span style="font-size: 18px;"><b>登录“活动审批系统”查看详情</b></span></font></a>
    </section>
</section>';

    if (email($to,$title,$data)) {
        return true;
    }else{
        return false;
    }

}

?>