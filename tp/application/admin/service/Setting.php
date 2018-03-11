<?php
namespace app\admin\service;
use think\Db;
use app\admin\model\Publish as PublishModel;
use app\admin\model\Room as RoomModel;
use app\admin\model\Seat as SeatModel;

class Setting{
	    //选座时间，新选座
      public function savePublish($array=array()){
           if(is_array($array)){
           	 $publish  = new PublishModel();
           	 $id       = $publish->insert($array);
           	 if($id){
           	 	return true;
           	 }else{
           	 	return false;
           	 }
           }
      }
     //选座的自习室房间 写入seat_room
     public function saveRoom($array=array(),$syear=''){
     	$room  = new RoomModel();
     	$data['room_year']=$syear;
     	if(is_array($array)){
     		foreach($array as $v){
     			foreach($v as $k=>$r){
                   if($k==2){
                      $data['room_id']     = $r;
                   }else if($k==3){
                   	  $data['room_number'] = $r;
                   }else if($k==4){
                   	  $data['room_usage']  = $r=='考研'?1:2;
                   }
     			}
            $id = $room->insert($data);
     		}
     	return $id;
     	}
     	return false;
     }
     //将 新选座信息写入 seat 表中
     public function saveSeat($data){
        $seat  = new SeatModel();
        $year  = $this->getTimer();
        $array['seat_year'] =$year['syear'];
        if(is_array($data)){
           foreach($data as $v){
              for($i=1;$i<=$v['room_number'];$i++){
                $array['seat_id'] =$i;
                $array['seat_room'] =$v['room_id'];
                $seat->insert($array);
              }
           }
           return true;
        }
        return false;
     }
     public function getRoomInfo($syear){
        $room   = new RoomModel();
        $data   = $room->where(array('room_year'=>$syear))->select();
        return $data;
     }
    //查找选座的本年度
    public  function getTimer(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $timer    = $publish->order('pid desc')->find();
        return $timer;
    }

}
?>