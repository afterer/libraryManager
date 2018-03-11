<?php

 /*

  *登录操作

  */

 namespace app\index\service;

 use think\Db;

 use app\index\model\Wechat as WechatModel;

 use app\index\model\Student as StudentModel;



 class Login{

 	//学生登录信息核对

  public function loginCheck($number,$idcard,$phone){

      $student  = new StudentModel();

      

      $array    = array("number"=>$number,"idcard"=>$idcard);

      $res      = $student->where($array)->find();



      if($res){
        $rst   = $student->where($array)->value('phone');
              if(empty($rst)){
               $student->where(array("number"=>$number))->insert(array("phone"=>$phone));
              }
        return true;
      }else{

        return false;

      }

      //$cnt      = $wechat->where($arrayid)->count();

      // if(is_array($arrayid)){

      //   $openid     = $arrayid["openid"];

      //   $nickname   = $arrayid["nickname"];

      //   $sex        = $arrayid["sex"];

      //   $headimgurl = $arrayid["headimgurl"];

      // }

      // if($res){

      //   if(!$cnt){

      //     $rstid      = $wechat->insert(array("student_number"=>$number,"openid"=>$openid,"nickname"=>$nickname,"sex"=>$sex,"headimgurl"=>$headimgurl,"create_time"=>date("Y-m-d H:i:s",time())));

      //      return $rstid;

      //   }

      //   return true;

        

      // }else{

      //   return false;

      // }

         

  }

  //将openid写入数据库

  public function saveOpenid($studentNo,$openid){

     $wechat    = new WechatModel();

    

     $time    = time();

     $array   = array('student_number'=>$studentNo,'openid'=>$openid,'creat_time'=>$time);

     $rstid   = $wechat->insert($array);

     return $rstid;

  }

 }

?>