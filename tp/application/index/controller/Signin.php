<?php
 /**
  * 签到
  */
 namespace app\index\controller;
 use think\Controller;
 //这里需继承 wechat控制器，先判断是否存在openid

 class Signin extends Base{
 	public function sign(){
 		if(!empty(Input('param.tim'))){
            $time      = Input('param.tim');
            $nowtime   = time();
            //判断获取到的时间是1分钟内
            $res       = $nowtime-$time;
            if($res<=60&&$res>=0){
            	//签到
            }else{
            	//超时
            }
        }
 	}
 }
?>