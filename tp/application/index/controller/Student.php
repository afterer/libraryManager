<?php
/**
 * 学生管理
 */
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Cookie;
use app\index\service\Student as StudentModel;

class Student extends Base{
	/**
	 * 
	 * @return 学生个人信息设置
	 */
	public function index(){
       return $this->fetch();
	}
	/**
	 * 学生账号界面
	 */
	public function user(){
       $number  = Session::get("number");
	   $student = new StudentModel();
	   $data    = $student->getUserInfo($number);
	   $this->assign("data",$data);
       return $this->fetch();
	}
	/**
	 * 版本号信息界面
	 */
	public function version(){
       return $this->fetch();
	}
	/**
	 * 学生预约的历史信息
	 */
	public function history(){
		return $this->fetch();
	}
	//6,7楼座位申请信息
	public function info67(){
        $student     = new StudentModel();
        $number      = Session::get('number');
        $data        = $student->getFloorInfo($number);
        $res         = $student->getIsStatus($number);
        if($res){
        	$isStatus = $res['status'];
        }else{
        	$isStatus = 0;
        }
        $this->assign('status',$isStatus);
        $this->assign('data',$data);
		return $this->fetch();
	}
	public function logout(){
	    Session::set("binding",false);
	    Session::set("number",null);
	    Cookie::set("number",null);

	    return json(array("code"=>1));
	}
	public function update(){
		$student  = new StudentModel();
		if(request()->isAjax()){
			$roomid  = $_POST['roomid'];
			$seatid  = $_POST['seatid'];
			$number  = Session::get('number');
			$status  = $student->checkSeatTabel($roomid,$seatid);
			if($status){
				return json(array('code'=>0,'message'=>'座位已经被选'));
			}
			$res     = $student->updateSeat($roomid,$seatid,$number);
			if($res){
				return json(array('code'=>1,'message'=>"修改成功"));
			}
			return json(array('code'=>0,'message'=>"修改失败"));
		}else{
			return $this->fetch();
		}
	}
	//退选
	public function withdrawal(){
		$student  = new StudentModel();
		if(request()->isAjax()){
			$number  = Session::get('number');
			$res     = $student->cancel($number);
			if($res){
				return json(array("code"=>1,"message"=>"退选成功"));
			}
			return json(array("code"=>0,"message"=>"退选失败"));
		}
	}
}
?>