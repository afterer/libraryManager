<?php
namespace app\admin\service;
use app\admin\model\Signin as SigninModel;
use app\admin\model\Day as DayModel;
use app\admin\model\Statistics as StatisticModel;

class Base{
	//归零天数
	public function clearTimer(){
        $day    = new  DayModel();
        $res    = $day->where('id=1')->update(array('day'=>0));
        return $res;
	}
	//更新天数
	public function updateDay(){
		$day    = new DayModel();
		$array  = array('day'=>array('exp','day+1'),'timer'=>date('y-m-d H:i:s',time()));
		$res    = $day->where('id=1')->update($array);
		return $res;
	}
	//获取统计天数
	public  function getDay(){
		$day     = new DayModel();
		$data    = $day->where('id=1')->find();
		return $data;
	}
	//获取统计表 数据记录
	public function getSigninData(){
		$sign    = new SigninModel();
		$data    = $this->getData();
		return $sign->select();
	}
	//获取所有学生学号
	public function getAllStudent(){
		$sign    = new SigninModel();
		$data    = $sign->group('student_number')->select();
		// dump($data);exit;
		return $data;
	}
	//获取 某个学生的 规定签到记录数据
	public function getOneData($student="",$count=""){
		$sign    = new SigninModel();
        if(!empty($student)&&!empty($count)){
           $array = array('student_number'=>$student);
           $data  = $sign->order('id desc')->limit($count)->where($array)->select();
           return $data;
        }else{
           return false;
        }
	}
	//录入签到信息
	public function insertSign($student="",$cnt=""){
		$statis  = new StatisticModel();
		$time    = time();
		$day     = $this->getDay();
        if(!empty($student)&&!empty($cnt)){
           $array = array('student_number'=>$student,'sign_rate'=>$cnt/$day['total_day'],'create_time'=>date('y-m-d H:i:s',$time));
           $rstid = $statis->insert($array);
           return $rstid; 
        }else{
        	return false;
        }
	}
}
?>