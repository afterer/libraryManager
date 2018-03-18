<?php
namespace app\admin\service;
use think\Db;
use app\admin\model\Publish as PublishModel;
use app\admin\model\Room as RoomModel;
use app\admin\model\Seat as SeatModel;
use app\admin\model\Student as StudentModel;
use app\admin\model\Fixed as FixedModel;

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
     public function saveRoom(){
     	  $room  = new RoomModel();
        $fixed = new FixedModel();
        $year  = $this->getYear();
        $data  = $fixed->select();
        $array = array();
        foreach($data as $k=>$v){
            $array = array("room_year"=>$year['pid'],"room_id"=>$v['room'],"room_number"=>$v['total'],"room_usage"=>$v['usage']);
            $id    = $room->insert($array);
        }
        if($id)
          return true;
        else
          return false;
     }
     //将 新选座信息写入 seat 表中
     public function saveSeat(){
        $seat  = new SeatModel();
        $year  = $this->getYear();
        $data  = $this->getRoomInfo($year['pid']);
        $array['seat_year'] =$year['pid'];
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
     //获取房间信息
    public function getHistoryRoom(){
      $room  = new RoomModel();
      $year  = $this->getYear();
      $data  = $room->where(array("room_year"=>$year['pid']))->select();
      return $data;
    }
	public function insertOneData($data=array()){
		$student  = new StudentModel();
    $arrayid  = array();
		if(is_array($data)){
      if($data['number']!=""){
        $arrayid['number']=$data['number'];
      }else if($data['name']){
        $arrayid['name']=$data['name'];
      }else if($data['college']!=0){
        $arrayid['college']=$data['college'];
      }else if($data['idcard']!=""){
        $arrayid['idcard'] = $data['idcrad'];
      }else if($data['major']!=""){
        $arrayid['major'] = $data['major'];
      }else if($data['phone']!=""){
        $arrayid['phone'] = $data['phone'];
      }
			$res  = $student->insert($arrayid);
			return $res;
		}
	}
  public function getFixedRoom(){
    $fixed  = new FixedModel();
    $data   = $fixed->select();
    return $data;
  }
  //获取最新年份
  public function getYear(){
    $publish  = new PublishModel();
    $year     = $publish->order("pid desc")->find();
    return $year;
  }
  //更新时间
  public function updateTimer($array=array()){
    $publish  = new PublishModel();
    $data     = array("stimer"=>$array['stimer'],"etimer"=>$array['etimer'],"ctimer"=>date('Y-m-d H:i:s',time()));
    if(is_array($array)){
      $id  = $publish->where(array('syear'=>$array['syear']))->update($data);
      return $id;
    }
  }

}
?>