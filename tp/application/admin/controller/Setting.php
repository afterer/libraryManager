<?php
/*
 *系统设置
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\service\Set as  SetModel;
use app\admin\service\Setting as SettingModel;	
use app\admin\controller\Base;
class Setting extends Base{
	//二维码
	public function qrcode(){
		return $this->fetch();
	}
	public function setDay(){
		$setting   = new SettingModel(); 
		if(request()->isAjax()){
		    $array  = array(
             'syear'=>$_POST['syear'],
             'stimer'=>$_POST['stimer'],
             'etimer'=>$_POST['etimer']
          );
        $res = $setting->updateTimer($array);
        if($res){
          return json(array("code"=>1,"message"=>"修改成功"));
        }else{
          return json(array("code"=>0,"message"=>"修改失败"));
        }
    }else{
      $data  = $setting->getYear();
      $this->assign("data",$data);
      return $this->fetch();
    }
	}
	//发布新选座
	public function publish(){
		$setting   = new SettingModel();
		if(request()->isAjax()){
		   $syear   = $_POST['syear'];
       $stimer  = $_POST['stimer'];
       $etimer  = $_POST['etimer'];
       
       //将选座时间信息写入 publish表
       $data    = array(
                     'syear'=>$syear,
                     'stimer'=>$stimer,
                     'etimer'=>$etimer,
					           'ctimer'=>date('Y-m-d H:i:s',time())
                  );
       $rstid   = $setting->savePublish($data);
       //将$table写入seat_room表
       $id      = $setting->saveRoom();
       //在seat表中生成座位信息
       $sid     = $setting->saveSeat();
       
       if($sid){
          return json(array("code"=>1));
       }else{
          return json(array("code"=>0));
       }
		}else{
       $data  = $setting->getFixedRoom();
       $this->assign("roomdata",$data);
       return $this->fetch();
    }
	}
	//excel文件读入
    public function importe(){

       //  Vendor('phpoffice.phpexcle.Classes');
       // // $filename = ROOT_PATH.'upload/'.'201712316664'.'.xls';
       //  $objPHPExcel = new \PHPExcel();
       //  $objPHPExcel = \PHPExcel_IOFactory::load($filename);//加载文件
       //  // $sheetCount = $objPHPExcel->getSheetCount();//获取excel里面有多少个sheet
       //  // for($i=0;$i<$sheetCount;$i++){
       //  //     $data = $objPHPExcel->getSheet($i)->toArray();//读取每个sheet里的数据 全部放入数组中
       //  //     print_r($data);
       //  // }
       //  foreach($objPHPExcel->getWorksheetIterator() as $sheet){//循环取sheet
       //      foreach($sheet->getRowIterator() as $row){//逐行处理
       //      	foreach($row->getCellIterator() as $cell){//逐列处理
       //              $data = $cell->getValue();
       //              echo $data;
       //      	}
       //      }
       //  }
       return $this->fetch();
    }
     //发布记录
    public function history(){
      $setting  = new SettingModel();
      $data     = $setting->getHistoryRoom();
      $syear    = $setting->getYear();
      $this->assign('syear',$syear['syear']);
	    $this->assign("ctimer",$syear['ctimer']);
      $this->assign("data",$data);
      return $this->fetch();
    }
	public function inserto(){
		$setting  = new SettingModel();
		if(request()->isAjax()){
		   $array   = array(
		      "number"=>$_POST['number'],
			   "name"=>$_POST['name'],
			   "college"=>$_POST['institute'],
			   "idcard"=>$_POST['idcard'],
			   "major"=>$_POST['major'],
			   "phone"=>$_POST['phone']
		   );
		   $res  = $setting->insertOneData($array);
		   if($res){
			   return json(array("code"=>1,"message"=>"添加成功"));
		   }else{
			   return json(array("code"=>0,"message"=>"添加失败")); 
		   }
		}
		return $this->fetch();
		
	}

}
?>