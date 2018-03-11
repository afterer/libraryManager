<?php
/**
 * 公共控制器，保障安全问题
 */
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\service\Base as BaseModel;
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
		
		$checked   = Session::get('checked');
		$expire    = Session::get('expire');
		if(!$checked&&$expire<time()){
           //dump($checked);exit;
           $this->error('请先登录','admin/Login/login',1);
         }
         //自动统计 签到情况
        //$this->absent_count();
		
	}
	//对6,7楼的签到情况做统计
	public function absent_count(){
        $base         = new BaseModel();
        $time         = time();
        $day          = $base->getDay();
        //先判断是否达到 规定天数，若达到就进行统计，否则继续累计
        if($day['day']==$day['total_day'])
        {
        	//先通过 group 到 签到表signin中获取所有学生的学号信息，然后通过学号获取 规定记录数，进行计算统计
        	$count        = $day['total_day'];
	        $studentArray = $base->getAllStudent();
	        foreach($studentArray as $k=>$v)
	        {
	            $data     = $base->getOneData($v['student_number'],$count);
	            $cnt      = 0;
                foreach($data as $sign){
                	if($sign['sign_state']==1){
                        $cnt++;
                	}
                }
                $toSign   = $base->insertSign($v['student_number'],$cnt);
	        }
	        //重新将 统计天数表 中的累计天数清零
	        $base->clearTimer();
        }else{
        	$timer    = strtotime($day['timer']);
            if($time-$timer>=86400){
            	//86400=24*60*60
            	$base->updateDay();//更新天数
            }
        }
        
	}
	

}
?>