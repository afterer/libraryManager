<?php
namespace app\index\service;
use app\index\model\Student as StudentModel;
use app\index\model\Wechat as WechatModel;
use think\Session;
class Index{
	// public function getUserInfo($studentNo){
	// 	$user       = new StudentModel();
	// 	$array      = array('number'=>$studentNo);
	// 	$data       = $user->where($array)->find();
	// 	return $data; 
	// }
	//获取用户信息
	public function getUserInfo($number){

       $student  = new StudentModel();
       $array    = array('number'=>$number);
       $data     = $student->where($array)->find();
       return $data;
	}
}
?>