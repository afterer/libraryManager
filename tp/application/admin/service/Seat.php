<?php

namespace app\admin\service;

use think\Db;
use app\admin\model\Seat as SeatModel;
use app\admin\model\Day as DayModel;
use app\admin\model\Room as RoomModel;
use app\admin\model\Publish as PublishModel;
use app\index\model\Sure as SureModel;
use app\admin\model\Student as StudentModel;
class Seat{

	//获取座位信息

	public function getSeatInfo(){

		$seat  = new SeatModel();

		$array = array('seat_year'=>$this->getYear(),'seat_state'=>1,'delete_state'=>1);

		$data  = $seat->join("seat_student",'seat_student.number=seat_seat.seat_own')->order("seat_room asc,seat_id asc")->where($array)->paginate(15);

		return $data;

	}

	//获取单条数据

	public function getOneInfo($array=array()){

		$seat  = new SeatModel();

		$arrayid = array(

			       'seat_year'=>$this->getYear(),

			       'seat_own'=>$array['student_number'],

			       'seat_state'=>1,

			       );

		//联表查询

		$data  = $seat->join('seat_student','seat_student.number=seat_seat.seat_own')->where($arrayid)->find();

		return $data;

	}

	//更改座位信息

	public function updateInfo($array=array()){

		if(is_array($array)){

			$seat               = new SeatModel();

			$year               = $this->getYear();

			$arrayid            = array();

			$data               = array(

                                   'seat_id'=>$array['seatid'],

                                   'seat_room'=>$array['room'],

                                   'seat_year'=>$year

				                  );

			$old                =array(

                                  'seat_state'=>1,

                                  'seat_own'=>$array['number'],

                                  'seat_year'=>$year

				                 );

			$arrayid['seat_own']= $array['number'];

			//查询修改座位号是否被选

			$sid                = $seat->where($data)->value('seat_state');

			if($sid==0){

                $arrayid['seat_state'] = 1;

                //将原来的座位修改

               $seat->where($old)->update(array('seat_own'=>['exp','null'],'seat_state'=>0));

               return  $seat->where($data)->update($arrayid);

			}else{

				return false;

			}		

		}else{

			return false;

		}

	}

	//修改座位状态

	public function updateSeatByStatus($year,$id){

		$seat   = new SeatModel();

		$array  = array("seat_year"=>$year,"seat_own"=>$id);

		$data['seat_status']=0;

		return  $seat->where($array)->update($data);

	}

	//获取 待审核 数据

	public function getCheckList(){

		$seat   = new SeatModel();

		$year   = $this->getYear();

		$data   = $seat->join('seat_student',"seat_student.number=seat_seat.seat_own")->order('sid')->where(array('seat_year'=>$year))->paginate(15);

		return $data;

	}

	//获取最新的学年

	public  function getYear(){

        $publish  = new PublishModel();

        $year     = $publish->order("pid desc")->find();

        return $year['syear'];

    }

    //座位审核

    public function updateStatusByNumber($number,$status){

    	$seat     = new SeatModel();

    	$array    = array("seat_own"=>$number);

    	if($status==1)

    	{

    		return $id = $seat->where($array)->update(array("seat_status"=>1));

    	}else{

    		return $id = $seat->where($array)->update(array("seat_status"=>2));

    	}

    	//return $id;

    }

    public function getDataToExcel($year){

      $seat   = new SeatModel();

      $array  = array('seat_year'=>$year,'seat_state'=>1,'delete_state'=>1);

      return $seat->join('seat_student','seat_seat.seat_own=seat_student.number')->where($array)->order('seat_room asc,seat_id asc')->select();

   }
    public function enteringData($array=array()){
    	$seat    = new SeatModel();
    	$room    = new RoomModel();
    	$sure    = new SureModel();
    	if(is_array($array)){
    		$where  = array("seat_year"=>$array["syear"],"seat_room"=>$array["room"],"seat_id"=>$array["seatid"]); 
    		$id     = $seat->where($where)->value("seat_state");
    		if($id){
    			return false;
    		}else{
    		   $seat->where($where)->update(array("seat_own"=>$array["number"],"seat_state"=>1));
    		   $room->where(array("room_year"=>$array["syear"],"room_id"=>$array["room"]))->setInc('seat_changed',1);
    		   $this->seatIsFull($array["room"],$array["syear"]);
    		   $sure->insert(array("year"=>$array["syear"],"number"=>$array["number"],"status"=>1));
    		   return true;
    		}
    	}
    }
     //增加已选座位数量
    public function seatIsFull($roomid,$year){
        $room   = new RoomModel();
        $array  = array('room_year'=>$year,'room_id'=>$roomid);
        $num    = $room->where($array)->field('room_number,seat_changed')->find();
        if($num['room_number'] == $num['seat_changed']){
          $room->where($array)->update(array('room_state'=>1));
        }
    }
    //查询学号
    public function isNumber($number){
    	$student = new StudentModel();
        $res     = $student->where(array("number"=>$number))->count();
        if($res){
        	return true;
        }
        return false;
    }

}

?>