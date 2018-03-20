<?php
/**
 * 学生选座
 */
namespace app\index\service;
use think\Db;
use app\index\model\Room as RoomModel;
use app\index\model\Seat as SeatModel;
use app\admin\model\Publish as PublishModel;
use app\index\model\Sure as SureModel;

class Select{
	//获取自习室的信息
    public function getRoomInfo($usage){
    	$room   = new RoomModel();
      $year   = $this->getYear();
      $array  = array("room_year"=>$year,'room_usage'=>$usage);
    	$data   = $room->where($array)->select();
    	return $data;
    }
    
    //获取自习室  座位 信息
    public function getSeatInfo($roomid){
       $seat    = new SeatModel();
       $year    = $this->getYear();
       $array   = array('seat_year'=>$year,'seat_room'=>$roomid);
       $data    = $seat->where($array)->select();
       return $data;
    }
     /**
     * 保存学生已选座位信息
     * 将该座位号到数据库中去检索，检测座位状态，查看是否可选
     * 这里需要用到事务，检测到座位状态是否为0，为0时修改，为1时rollback
     */
    public function saveStudentSeatInfo($studentNumber,$roomId,$seatId){
       $seat     = new SeatModel();
       $year     = $this->getYear();
       $array    = array('seat_year'=>$year,'seat_id'=>$seatId,'seat_room'=>$roomId);
       $arrayid  = array('room_year'=>$year,'room_id'=>$roomId);
       $state    = $seat->where($array)->value('seat_state');
       if($state==0){
        //未选
          $data  = array(
                'seat_own'=>$studentNumber,
                'seat_state'=>1
          );
          Db::startTrans();
          try{
            Db::table("seat_seat")->where($array)->update($data);
            Db::table("seat_sure")->insert(array("number"=>$studentNumber,"year"=>$year,"status"=>1));
            $this->seatIsFull($roomId,$year);
            Db::commit();
            return true;
          }catch(Exception $e){
             $seat->rollback();
             return false;
          }
       }else{
          //已选
          return false;
       }
    }
     //增加已选座位数量
    public function seatIsFull($roomid,$year){
        $room   = new RoomModel();
        $seat   = new SeatModel();
        $array  = array("seat_year"=>$year,"seat_room"=>$roomid,"seat_state"=>0);
        $where  = array("room_year"=>$year,"room_id"=>$roomid);
        $num    = $seat->where($array)->count();
        $total  = $room->where($where)->value("room_number");
        if($num==$total){
          $room->where($where)->update(array("room_state"=>1));
        }    
    }
    //通过 roomid获取房间信息
    public function getRoomById($roomid){
    	$room   = new RoomModel();
    	$data   = $room->where(array('room_id'=>$roomid))->find();
    	return $data;
    }
    //获取 该人 是否选座
    public function getIsSelect($number){
      $sure  = new SureModel();
      $year  = $this->getYear();
      $state = $sure->where(array("number"=>$number,"year"=>$year))->count();
      if($state==0){
         return false;
      }else{
        return true;
      }
    }
    //查找选座的本年度
    public  function getYear(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $year     = $publish->order('pid desc')->find();
        return $year['pid'];
    }
    public function getTimeArrange(){
      $publish  = new PublishModel();
      $data     = $publish->order("pid desc")->find();
      return $data;
    }
}
?>