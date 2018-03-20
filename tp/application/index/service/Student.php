<?php
namespace app\index\service;
use app\index\model\Seat as SeatModel;
use app\admin\model\Publish as PublishModel;
use app\admin\model\Student as StudentModel;
use app\index\model\Sure as SureModel;
use app\index\model\Room as RoomModel;
class Student{
	//获取 6、7楼选座的信息
	public function getFloorInfo($number){
        $seat  = new SeatModel();
        
        $year  = $this->getYear();
        $array = array("seat_year"=>$year['pid'],"seat_own"=>$number,"seat_state"=>1);
        $data  = $seat->join('seat_room',"seat_room.room_id=seat_seat.seat_room")->where($array)->find();
        return $data;
	}
	//查找选座的本年度
    public  function getYear(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $year     = $publish->order('pid desc')->find();
        return $year;
    }
     public function getUserInfo($number){
        $student = new StudentModel();
        $data    = $student->where(array("number"=>$number))->find();
        return $data;
    }
    public function getIsStatus($number){
        $sure  = new SureModel();
        $year  = $this->getYear();
        $res   = $sure->where(array('number'=>$number,'year'=>$year['pid']))->find();
        if($res){
            return $res;
        }else{
            return false;
        }
    }
    //检查座位状态
    public function checkSeatTabel($roomid,$seatid){
        $year  = $this->getYear();
        $seat  = new SeatModel();
        $where = array(
                'seat_year'=>$year['pid'],
                'seat_room'=>$roomid,
                'seat_id'=>$seatid
            );
        $id    = $seat->where($where)->value('seat_state');
        return $id;
    }
    //更改座位号
    public function updateSeat($roomid,$seatid,$number){
       $seat  = new SeatModel();
       $year  = $this->getYear();
       $where = array(
            'seat_year'=>$year['pid'],
            'seat_room'=>$roomid,
            'seat_id'=>$seatid
        );
       $data  = array('seat_state'=>0);
       $id    = $seat->where(array("seat_year"=>$year['pid'],"seat_own"=>$number))->update($data);
       $newdata  = array("seat_own"=>$number,"seat_state"=>1);
       $resid    =$seat->where($where)->update($newdata); 
       if($id&&$resid){
        return true;
       }else{
        return false;
       }
    }
    public function cancel($number){
        $seat  = new SeatModel();
        $sure  = new SureModel();
        $year  = $this->getYear();
        $where = array('seat_year'=>$year['pid'],'seat_own'=>$number);
        $roomid= $seat->where($where)->value('seat_room');
        $res   = $seat->where($where)->update(array("seat_state"=>0));
        $this->seatIsFull($roomid,$year['pid']);
        $sureid= $sure->where(array('year'=>$year['pid'],'number'=>$number))->delete();
        if($res&&$sureid){
            return true;
        }
        return false;

    }
    //判断房间 数量
     public function seatIsFull($roomid,$year){
        $room   = new RoomModel();
        $seat   = new SeatModel();
        $array  = array("seat_year"=>$year,"seat_room"=>$roomid,"seat_state"=>0);
        $where  = array("room_year"=>$year,"room_id"=>$roomid);
        $num    = $seat->where($array)->count();
        $total  = $room->where($where)->value("room_number");
        if($num<$total){
          $room->where($where)->update(array('room_state'=>0));
        }    
    }

}
?>