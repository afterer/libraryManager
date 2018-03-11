<?php
namespace app\index\service;
use app\index\model\Seat as SeatModel;
use app\index\model\Room as RoomModel;
use app\admin\model\Publish as PublishModel;
class Seat{
	//获取自习室座位的信息
    public function getSeatInfo($roomId){
    	$seat   = new SeatModel();
        $year   = $this->getYear();
        $array  = array('seat_year'=>$year,'seat_room'=>$roomId);
    	  $data   = $seat->where($array)->select();
        return $data;
    }
   
    //查找选座的本年度
    public  function getYear(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $year     = $publish->order('pid desc')->find();
        return $year['syear'];
    }
}
?>