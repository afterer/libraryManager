<?php
/**
 * 公共控制器，保障安全问题
 */
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Cookie;

class Base extends Controller{
	function __construct(){
		//Session::start();
		parent::__construct();
	}
	/**
	 * 
	 * 初始化
	 */
	public function _initialize(){
		
		$checked   = Session::get('binding');
		$cnumber   = Cookie::get('number');
		$expire    = Session::get('expire');
		if(!$checked||!$cnumber){
           $this->error('请先登录','index/Login/login',1);
        }else{
        	if($expire-time()<1000)
        		Session::set("expire",time()+3600);
        }
		
	}
	
	

}
?>