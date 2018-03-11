<?php
namespace app\index\service;
use think\Db;
use app\index\model\Room as RoomModel;
use app\index\model\Student as StudentModel;
use app\admin\model\Publish as PublishModel;
class Room{
	//获取自习室的信息
    public function getRoomInfo($usage){
    	$room   = new RoomModel();
      $year   = $this->getYear();
      $array  = array("room_year"=>$year,'room_usage'=>$usage);
    	$data   = $room->where($array)->select();
    	return $data;
    }
    
    
    //获取学生个人信息
    public function getUserInfo(){
    	$studentNumber  = session("userNumber");
    	$student        = new StudentModel();
    	$data           = $student->join("seat_seat","seat_seat_seat_id=seat_student_seat_number")->find();
    	return $data;
    }
    //录入注册信息
    public function addRegister($data=array()){
        if(is_array($data)){
            $student        = new StudentModel();
            $studentNumber  = $data['student_number'];
            $id             = $student->where("student_number=".$studentNumber)->find();
            if($id){
                //防止重复注册
                return false;
            }else{
                return $student->insert($data);
            }
           
        }
    }
   
    //查找选座的本年度
    public  function getYear(){
        $publish  = new PublishModel();
        //$id       = $publish->max('pid');
        $year     = $publish->order('pid desc')->find();
        return $year['syear'];
    }
    
    //获取选座时间范围
    public function getTimeArrange(){
      $publish    = new PublishModel();
      $year       = array("syear"=>$this->getYear());
      $array      = $publish->where($year)->field('stimer,etimer')->find();
      return $array;
    }
}
?>