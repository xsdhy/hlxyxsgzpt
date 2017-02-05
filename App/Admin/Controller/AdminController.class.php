<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class AdminController extends CommonController {
    public function add(){
        $this->show();
    }
    public function index(){
        switch (I('get.admin_type')) {
            case '1':
                $spwhere="admin_type = 0";
                break;
            case '2':
                $spwhere="admin_type = ".I('get.admin_type');
                break;
            case '3':
                $spwhere="admin_type = ".I('get.admin_type');
                break;
            case '4':
                $spwhere="admin_type = ".I('get.admin_type');
                break;
            case '5':
                $spwhere="admin_type = ".I('get.admin_type');
                break;
            
            default:
                $spwhere="";
                break;
        }
        $admin = M('admin'); // 实例化admin对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $admin->where($spwhere)->page($_GET['p'].',25')->select();
        $this->assign('list',$list);// 赋值数据集
        $count      = $admin->where($spwhere)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    public function upload() {
        header("Content-Type:text/html;charset=utf-8");
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->exts = array('xls', 'xlsx'); // 设置附件上传类
        $upload->savePath = '/'; // 设置附件上传目录
        // 上传文件
        $info = $upload->uploadOne($_FILES['file']);
        $filename = 'Uploads' . $info['savepath'] . $info['savename'];
        $exts = $info['ext'];
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功
            $this->goods_import($filename, $exts);
        }
    }
    function goods_import($filename, $exts = 'xls') { 
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入 
        import("Org.Util.PHPExcel"); 
        //创建PHPExcel对象，注意，不能少了\ 
        $PHPExcel = new \PHPExcel(); 
        //如果excel文件后缀名为.xls，导入这个类 
     
        if ($exts == 'xls') { 
            import("Org.Util.PHPExcel.Reader.Excel5"); 
            $PHPReader = new \PHPExcel_Reader_Excel5(); 
        } else if ($exts == 'xlsx') { 
            import("Org.Util.PHPExcel.Reader.Excel2007"); 
            $PHPReader = new \PHPExcel_Reader_Excel2007(); 
        } 
        //载入文件 
        $PHPExcel = $PHPReader->load($filename); 
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推 
        $currentSheet = $PHPExcel->getSheet(0); 
        //获取总列数 
        $allColumn = $currentSheet->getHighestColumn(); 
        //获取总行数 
        $allRow = $currentSheet->getHighestRow(); 
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始 
        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) { 
            //从哪列开始，A表示第一列 
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) { 
                //数据坐标 
                $address = $currentColumn . $currentRow; 
                //读取到的数据，保存到数组$arr中 
                $data[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue(); 
            } 
        } 
        $this->save_import($data); 
    }
     //保存导入数据
    public function save_import($data) {
    	$yes=0;
        foreach ($data as $k => $v) {
        	//从第二行开始
            if ($k > 1) {
                $date['admin_name'] = $v['A'];
                $date['admin_username'] = $v['B'];
                $date['admin_password'] =md5('xsdhy'.md5($v['C']).'suse');
                $date['admin_email'] = $v['D'];
                $date['admin_department'] = $v['E'];
                switch ($v['E']) {
                    case '管理员':
                        $date['admin_type'] = 0;
                        break;
                    case '辅导员':
                        $date['admin_type'] = 2;
                        break;
                    case '团总支':
                        $date['admin_type'] = 3;
                        break;
                    case '保卫办':
                        $date['admin_type'] = 4;
                        break;
                    case '分管领导':
                        $date['admin_type'] = 5;
                        break;
                }
                if (M('admin')->add($date)) {
                	$yes++;
                }
            }
        }
        if ($yes) {
            $event='增加了'.$yes.'条老师数据';
            addevent($event);
            $this->success('成功导入<span style="color:red">' . $yes.'</span>名老师',U('Admin/admin/index'));
        }else{
            $this->error('数据导入失败');
        }
    }

    public function getadmin(){
        $admin = M('admin');
        $adminres = $admin->find($_GET['admin_id']);
        echo json_encode($adminres);
    }

    public function edit(){
        if (intval(I('post.admin_id'))) {
            $data=I('post.');
            if ($data['admin_password']=="") {
                unset($data['admin_password']);
            }else{
                $data['admin_password']=md5('xsdhy'.md5($data['admin_password']).'suse');
            }
            $res = M("admin")->save($data);
            if ($res){
                $event='修改了教师ID为'.I('post.admin_id').'的相关信息';
                addevent($event);
                $this->success("更新老师资料成功");
            }else{
                $this->error("更新老师资料失败，请重试");
            }
        }else{
            $data=I('post.');
            $data['admin_password']=md5('xsdhy'.md5($data['admin_password']).'suse');
            switch ($data['admin_type']) {
                case '0':
                    $data['admin_department']="管理员";
                    break;
                case '2':
                    $data['admin_department']="辅导员";
                    break;
                case '3':
                    $data['admin_department']="团总支";
                    break;
                case '4':
                    $data['admin_department']="保卫办";
                    break;
                case '5':
                    $data['admin_department']="分管领导";
                    break;
            }
            $res=M('admin')->add($data);
            if ($res) {
                $event='增加了一名老师，ID为：'.$res;
                addevent($event);
                $this->success("增加老师成功");
            }else{
                $this->error("增加老师失败，请重试");
            }
        }
    }

    public function deladmin(){
        if(I('get.admin_id')){
            $admin = M('admin');
            $res=$admin->where('admin_id='.I('get.admin_id'))->delete();
            if($res){
                $event='删除了老师，ID为：'.I('get.admin_id');
                addevent($event);
                $this->success('删除老师成功');
            }else{
                $this->error('删除老师失败');
            }
        }
    }
}