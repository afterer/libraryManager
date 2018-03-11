<?php
/*
 *座位发布的service
 */
namespace app\admin\service;
use think\Db;
use app\admin\model\Publish as PublishModel;
use app\admin\model\Seat as SeatModel;
use app\admin\model\Room as RoomModel;
class Publish{
	public function addPublishSeat($array=array()){
		if(is_array($array)){
            $publish   = new PublishModel();
            $publish->insert($array);//插入publish表
            //考研与考证写入room表
            $year      = $array['syear'];
            $yArray    = explode("，", $array['yseat']);
            $zArray    = explode("，",$array['zseat']);
            $this->insertRoom($year,1,$yArray);//考研
            $this->insertRoom($year,2,$zArray);//考证
            return true;
		}else{
			return false;
		}
	}
  
   public function insertRoom($year,$tap,$array=array()){
      $room      = new RoomModel();
      $iarr      = array('714','719','614','619');
      $data      = array();
      foreach($array as $k=>$v){
           if(in_array($v,$iarr)){
              $num = 36;//座位数
           }else{
              $num = 32;
           }
           $num    = in_array($v,$iarr)?36:32;
           $data   = array(
              'room_year'=>$year,
              'room_id'=>$v,
              'room_number'=>$num,
              'seat_changed'=>0,
              'room_usage'=>$tap
           );
         $room->insert($data);
      }
   }
} 
?>