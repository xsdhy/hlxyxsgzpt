<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class StuController extends CommonController {
    public function add(){
        $this->show();
    }
    public function index(){

        if (I('get.student_xgz')!='') {
            $spwhere="student_xgz = ".I('get.student_xgz');
        }elseif(I('post.student_number')!=''){
            $spwhere="student_number = ".I('post.student_number');
        }else{
            $spwhere="";
        }
        $student = M('student'); // 实例化student对象
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $student->where($spwhere)->page($_GET['p'].',25')->select();
        $this->assign('list',$list);// 赋值数据集
        $count      = $student->where($spwhere)->count();// 查询满足要求的总记录数
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
                $date['student_xgz'] = $v['A'];
                $date['student_fdy'] = $v['B'];
                $date['student_email'] = $v['C'];
                $date['student_class'] = $v['D'];
                $date['student_number'] = $v['E'];
                $date['student_name'] = $v['F'];
                $date['student_type'] = $v['G'];  
                $date['student_password'] = md5('xsdhy'.md5($v['H']).'susestu');
                if (M('student')->add($date)) {
                	$yes++;
                }
            }
        }
        if ($yes) {
            $event='导入了'.$yes.'条学生数据';
            addevent($event);
          $this->success('成功导入<span style="color:red">' . $yes.'</span>名同学',U('Admin/stu/index'));
        }else{
          $this->error('数据导入失败');
        }
    }

    public function getstudent(){
        $student = M('student');
        $studentres = $student->find($_GET['student_id']);
        echo json_encode($studentres);
    }

    public function edit(){
        if (intval(I('post.student_id'))) {
            $data=I('post.');
            if ($data['student_password']=="") {
                unset($data['student_password']);
            }else{
                $data['student_password']=md5('xsdhy'.md5($data['student_password']).'susestu');
            }
            $res = M("student")->save($data);
            if ($res){
                $event='修改了学生ID为:'.I('post.student_id');
                addevent($event);
                $this->success("更新学生资料成功");
            }else{
                $this->error("更新学生资料失败，请重试");
            }
        }else{
            $data=I('post.');
            $data['student_password']=md5('xsdhy'.md5($data['student_password']).'susestu');
            $res=M('student')->add($data);
            if ($res) {
                $event='增加了学生,学生ID为:'.$res;
                addevent($event);
                $this->success("增加学生成功");
            }else{
                $this->error("增加学生失败，请重试");
            }
        }
    }

    public function delstudent(){
        if(I('get.student_id')){
            $student = M('student');
            if($student->where('student_id='.I('get.student_id'))->delete()){
                $event='删除了学生,ID为：'.I('get.student_id');
                addevent($event);
                $this->success('删除学生成功');
            }else{
                $this->error('删除学生失败');
            }
        }
    }

}