<?php
/*
 * 选座信息表格
 */
namespace app\admin\controller;
use think\Db;
use app\admin\service\Seat as  SeatModel;
use app\admin\service\Publish as PublishModel;	
use app\admin\controller\Base;
use think\Controller;
class Seat extends Base{
	//显示选座信息
	public function index(){
		//获取数据分页显示
		$seat  = new SeatModel();
		$data  = $seat->getSeatInfo();
		$page  = $data->render();
		$this->assign("data",$data);
		$this->assign('page',$page);
		return view();
	}
	//修改座位信息
	public function edit(){
		$seat = new SeatModel();
		if(!empty(Input("param.id"))){
           $numberid  = Input('param.id');
           $array     = array("student_number"=>$numberid);
           $data      = $seat->getOneInfo($array);
           $this->assign('data',$data);
           return $this->fetch();
		}else{
		  return $this->fetch('index');
		}
	}
	//修改座位号
	public function update(){
		$seat  = new SeatModel();
		if(request()->isAjax()){
            $array   = array(
                'number'=>$_POST['number'],
                'room'=>$_POST['room'],
                'seatid'=>$_POST['seatid']
            );
            $rstid   = $seat->updateInfo($array);
            if($rstid){
               return json(array("code"=>1));
            }else{
            	return json(array("code"=>0));
            }
		}else{
		  return $this->fetch('index');
		}
	}
	//删除座位信息
	public function del(){
		if(request()->isAjax()){
			$number   = $_GET['number'];
			$year     = $_GET['year'];
			$seat     = new SeatModel();
			$rstid    = $seat->updateSeatByStatus($year,$number);
			if($rstid){
				return json(array("code"=>1));
			}else{
				return json(array("code"=>0));
			}
		}
	}
     //录入座位
	public function entering(){
		$seat   = new SeatModel();
		if(request()->isAjax()){
			$array  = array(
                    'syear'=>$_POST['syear'],
                    'number'=>$_POST['number'],
                    'room'=>$_POST['room'],
                    'seatid'=>$_POST['seatid']
				);
			$id     = $seat->isNumber($array["number"]);
			if(!$id){
				return json(array("code"=>0,"message"=>"学号有误"));
			}
		    $res    = $seat->enteringData($array);
		    if($res){
		    	return json(array("code"=>1,"message"=>"添加成功"));
		    }else{
		    	return json(array("code"=>0,"message"=>"添加失败"));
		    }
		}
		return $this->fetch();
	}

	/**
	 * /
	 * @return 导出excel
	 * 1.实例化excel，建立一个excel表格
	 * 2.获得当前活动（active）的sheet操作对象
	 * 3.给当前活动对象设置名称
	 * 4.给当前活动sheet填充数据
	 * 5.按照指定格式生成excel文件
	 * 6.保存路径
	 */
	public function exporte(){
		
		if(!empty(Input("param.syear"))){
			$seat  = new SeatModel();
            $syear = Input("param.syear");
            $data  = $seat->getDataToExcel($syear);
            //var_dump($data);exit;
            Vendor('phpoffice.phpexcel.Classes');
            $objPHPExcel = new \PHPExcel();
            $objSheet    = $objPHPExcel->getActiveSheet();
            $objSheet->setTitle("Sheet1");
            // $objSheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)  
            //                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
                                                    //设置水平垂直居中  
            $objSheet->getDefaultStyle()->getFont()->setName("微软雅黑")->setSize(12);
           // $objSheet->getStyle("A1:F1")->applyFromArray(getBorderStyle("#66FF99")); //设置标题边框 
            $objSheet->setCellValue('A1','序号')
                     ->setCellValue('B1','姓名')
                     ->setCellValue('C1','学号')
                     ->setCellValue('D1','学院')
                     ->setCellValue('E1','专业班级')
                     ->setCellValue('F1','联系方式')
                     ->setCellValue('G1','自习室')
                     ->setCellValue('H1','座位号');
            $j        = 2;
            foreach($data as $k=>$v){
                $objSheet->setCellValue('A'.$j,$k+1)
                         ->setCellValue('B'.$j,$v['name'])
                         ->setCellValue('C'.$j,$v['number'])
                         ->setCellValue('D'.$j,getInstitute($v['college']))
                         ->setCellValue('E'.$j,$v['major'])
                         ->setCellValue('F'.$j,$v['phone'])
                         ->setCellValue('G'.$j,$v['seat_room'])
                         ->setCellValue('H'.$j,$v['seat_id']);
                $j++;
            }
            $filename =date('Ymd',time()).rand(1000,9999);
            ob_end_clean();
            header('pragma:public');
            header("Content-type:application/octet-stream;charset=utf-8");
			header('Content-Type:application/vnd.ms-excell');
            header('Content-Disposition:attachment;filename='.$filename.".xls");
			header('Cache-Control:max-age=0');
            $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
            //在upload创建文件夹
            //$dir   = ROOT_PATH.'/upload';
            $objWriter->save('php://output');
            //$objWriter->save(ROOT_PATH.'upload/'.$filename.'.xls');
            //return AjaxReturn(1,'',ROOT_PATH.'upload/'.$filename.'.xls');
       
                
               
            // }
            
            // return AjaxReturn(0);
		}else{
			return $this->fetch('exporte');
		}
	}
	//座位审核 列表
	public function checkSeat(){
		$seat   = new SeatModel();
		$data   = $seat->getCheckList();
		$page   = $data->render();
		$this->assign("data",$data);
		$this->assign("page",$page);
		return $this->fetch();
	}
	//审核座位
	public function checkStatusByNumber(){
		$seat   = new SeatModel();
		if(request()->isAjax()){

			$number  = $_POST['number'];
			$status  = $_POST['status'];
			$rstid   = $seat->updateStatusByNumber($number,$status);
			if($rstid){
				return json(array("code"=>1));
			}else{
				return json(array("code"=>0));
			}
		}else{
			return json(array("code"=>0));
		}
	}
	
}
?>