<?php
namespace app\admin\service;
use think\Db;
use think\Model;
use app\admin\model\Admin as AdminModel;
class Admin{
	// private $admin ="";
	// function __construct(){
		
	// }
	//登录检测
	public function check($username,$password){
		$admin  = new AdminModel();
		//svar_dump($admin);exit;
        $rstId  = $admin->where(array("username"=>$username,"password"=>$password))->count();
        return $rstId;
	}
	//登录用户资料
	public function getAdminInfo($username){
	   $admin  = new AdminModel();
	   $array  = array("username"=>$username);
       return  $admin->where($array)->find();
	}
	//修改用户名
	public function updateUsername($username,$name){
		$admin  = new AdminModel();
		$array  = array("username"=>$username);
		$data['name'] = $name;
		return  $admin->where($array)->update($data);
	}
	//修改密码
	public function updatePasswd($username,$oldPasswd,$newPasswd){
		$admin     = new AdminModel();
		$array     = array("username"=>$username,"password"=>$oldPasswd);
		//验证旧密码是否正确
		$id        = $admin->where($array)->count();
		if($id){
			$array = array("username"=>$username);
			// $data['password'] = $newPasswd;
			return $admin->where($array)->setField('password',$newPasswd);
		}else{
			return false;
		}
	}
	//添加管理员
	public function addAdmin($array=array()){
		$admin     = new AdminModel();
		if(is_array($array)){
			//防止重复添加
			$arrayid  = array('username'=>$array['username']);
			$id       = $admin->where($arrayid)->count();
			if($id){
				return false;
			}
           return $admin->insert($array);
		}else{
			return false;
		}
	}
	//获取管理员列表
	public function getAdminList(){
		$admin     = new AdminModel();
		return $admin->order("id")->paginate(5);
	}
}
?>