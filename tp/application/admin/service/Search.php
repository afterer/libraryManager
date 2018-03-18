<?php

namespace app\admin\service;

use think\Db;
use app\admin\model\Student as StudentModel;
use app\admin\mode\Publish as PublishModel;
use app\admin\model\Seat as SeatModel;
class Search{

      //按条件查询学生

      public function getDataByConditions($arrayid=array()){
      	 if(is_array($arrayid)){
      	 	$student  = new StudentModel();
      	 	$data     = $student->where($arrayid)->select();
      	 	if($data){
      	 		return $data;
      	 	}else{
      	 		return false;
      	 	}
      	 }else{
      	 	return false;
      	 }
      }
      //按自习室号或座位号查询
      public function getDataBySeat($array=array()){
            $year   = $this->getYear();
          
      	if(is_array($array)){
      		$seat    = new SeatModel();
      		$arrayid  = array();
      		if(!empty($array['roomid'])){
      			$arrayid['seat_room'] = $array['roomid'];
      		}else if(!empty($array['seatid'])){
      			$arrayid['seat_id']   = $array['seatid'];
      		}
                  $arrayid['seat_year'] = $year;
      		$sdata     = $seat->join('seat_student','seat_seat.seat_own=seat_student.number')->where($arrayid)->select();
      		if($sdata){
		          return $sdata;
      		}else{
      			return false;
      		}
      	}else{
     		      return false;
      	}
      }
      //获取最新的学年
      public  function getYear(){
        $publish  = new PublishModel();
        $year     = $publish->order("pid desc")->find();
        var_dump($year);exit;
        return $year;
    }
}

?>