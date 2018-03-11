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

	//针对6、7楼设置签到统计天数
	public function setDay(){
		$set    = new SetModel();
		if(request()->isAjax()){
			$newDay  = $_POST['newDay'];
            $rstid   = $set->modifyDay($newDay);
            if($rstid){
              return json(array("code"=>1,"message"=>"修改成功"));
            }else{
            	 return json(array("code"=>0,"message"=>"修改失败"));
            }
		}else{
            $total = $set->getRecentDay();
            $this->assign('total',$total);
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
       $content = $_POST['content'];
       $tr      = array();
       $table   = array();
       $data    = array();
       $i=0;
       $j=0;
       foreach($content as $k=>$v){
        if($k>9){
           $tr[$i++] = $v;
           if($i>=5){
            $table[$j++] = $tr;
            unset($tr);
            $i=0;
           }
        }
       }
       //将选座时间信息写入 publish表
       $data    = array(
                     'syear'=>$syear,
                     'stimer'=>$stimer,
                     'etimer'=>$etimer
                  );
       $rstid   = $setting->savePublish($data);
       //将$table写入seat_room表
       $id      = $setting->saveRoom($table,$syear);
       //在seat表中生成座位信息
       $roomdata= $setting->getRoomInfo($syear);
       $sid     = $setting->saveSeat($roomdata);
       
       if($sid){
          return json(array("code"=>1));
       }else{
          return json(array("code"=>0));
       }
       
       
		}
    $timer      = $setting->getTimer();
    $nowTime    = time();
    if(strtotime($timer['stimer'])<=$nowTime&&strtotime($timer['etimer'])>=$nowTime){
      return view('load');
    }
		return $this->fetch();
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

}
?>