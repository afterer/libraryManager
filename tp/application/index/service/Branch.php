<?php
/**
 * 分馆
 */
namespace app\index\service;
use app\index\model\Branch as BranchModel;
use app\index\model\Order as OrderModel;

class Branch{
	//获取分馆的 座位信息
	public function getBranchInfo($id){
		$branch   = new BranchModel();
		$array    = array("branch"=>$id,"status"=>1);//获取已经被预定的座位信息
		$data     = $branch->where($array)->select();
		$max      = $branch->where(array('branch'=>$id))->max('seatid');//获取 最大座位号
		$info     = array("data"=>$data,"max"=>$max);
		return $info;
		
	}
	//记录 预约 信息
	public function recordOrderInfo($array=array()){
		$order    = new OrderModel();
		$branch   = new BranchModel();
        if(is_array($array)){
            $arr  = array("branch"=>$array['branch'],'seatid'=>$array['seatid']);
            $branch->where($arr)->update(array('status'=>1));
            return $order->insert($array); 
        }else{
        	return false;
        }
	}
	//查询branch表 座位 状态
	public function checkSeat($seatid,$branchid){
		$branch   = new BranchModel();
		$rstid    = $branch->where(array("branch"=>$branchid,"seatid"=>$seatid))->value("status");
		return $rstid;
	}
	//获取 预约信息
	public function getOrderInfo($number){
		$status   = 0;//未签到
		$order    = new OrderModel();
		$array    = array('number'=>$number,'status'=>0);
		$data     = $order->where($array)->find();
		return $data;
	}
}
?>