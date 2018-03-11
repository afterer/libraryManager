/**
 * 学生管理
 */
<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\service\Signin as SigninModel;

class Student extends Base{
	function __construct(){
		
	}
	/**
	 * 学生总馆6，7楼扫码签到
	 */
	public function signindex(){
       if(!empty(Input("param"))){
           $signtime   = Input('param.time');
           $id         = Input('param.id');
           //这里还需要获取到openid
           $todaytime  = strtotime(date('ymd',time()));
           if($signtime==$todaytime){
              $sign    = new SigninModel();
              $array   = array(
                             
              	         );
           }

       }else{

       }
	}
}
?>