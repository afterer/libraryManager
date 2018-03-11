<?php
namespace app\admin\service;
use think\Db;
use app\admin\model\Student as StudentModel;
use app\index\model\Order as OrderModel;
class Search{
      //按条件查询学生
      public function getDataByConditions($arrayid=array()){
      	 if(is_array($arrayid)){
      	 	$order  = new OrderModel();
      	 	$data     = $order->join('seat_student','seat_order.onumber=seat_student.number')->order('oid')->where($arrayid)->select();
                  
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
      	if(is_array($array)){
      		$order    = new OrderModel();
      		$arrayid  = array();
      		if(!empty($array['branchid'])){
      			$arrayid['branch'] = $array['branchid'];
      		}else if(!empty($array['seatid'])){
      			$arrayid['seatid']   = $array['seatid'];
      		}
                  // $arrayid['status'] = 1;
                  // $arrayid['seat_state']=1;
      		$sdata     = $order->join('seat_student','seat_order.onumber=seat_student.number')->order('oid')->where($arrayid)->select();
      		if($sdata){
      			return $sdata;
      		}else{
      			return false;
      		}

      	}else{
      		return false;
      	}
      }
      //获取所有信息
      public function getAllInfo(){

      }
}
?>