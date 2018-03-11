<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\service\Admin as AdminModel;
use think\Session;
/**
 * 登录管理
 */
class Login extends Controller{
	//后台登录
	public function login(){
         $admin     = new AdminModel();
		if(request()->isAjax()){
            $username  = $_POST['username'];
            $password  = md5($_POST['password']);
            $id        = $admin->check($username,$password);

            if($id>0){
                Session::set("username",$username);
                Session::set('checked',true);
                //Session::set('expire',time()+7200);
            	return json(array("code"=>1));
            }else{
                Session::set('checked',false);
            	return json(array("code"=>0));
            }
		}else{
	      Session::set('checked',false);
	      return $this->fetch("login");
        }  
	}
}
?>