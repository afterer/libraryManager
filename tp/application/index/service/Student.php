<?php
namespace app\index\service;
use app\index\model\Seat as SeatModel;
use app\admin\model\Publish as PublishModel;
use app\admin\model\Student as StudentModel;
class Student{
	//获取 6、7楼选座的信息
	public function getFloorInfo($number){
        $seat  = new SeatModel();
        
        $year  = $this->getYear();
        $array = array("seat_own"=>$number);
        $data  = $seat->join('seat_room',"seat_room.room_id=seat_seat.seat_room")->where($array)->find();
        return $data;
	}
	//查找选座的本年度
    public  function getYear(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $year     = $publish->order('pid desc')->find();
        return $year['syear'];
    }
     public function getUserInfo($number){
        $student = new StudentModel();
        $data    = $student->where(array("number"=>$number))->find();
        return $data;
    }


}
?>