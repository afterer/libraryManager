<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function AjaxReturn($res,$message="",$url="",$data=array()){

    if($res){
    	$code =1;
    }else{
    	$code =0;
    }
    $array = array('code'=>$code,'message'=>$message,'data'=>$data,'url'=>$url);
    return $array;
}
//性别判断
function getSex($sex){
   if($sex==0){
   	return "男";
   }else{
    return "女";
   }
}
//管理员权限等级判断
function getLevel($level){
	if($level == 1){
		return "高级管理员";
	}else{
		return "普通管理员";
	}
}
//获取专业学院
function getInstitute($id){
  $name ="";
   switch($id){
     case 1:
        $name ="计算机学院";
        break;
     case 2:
        $name ="信息学院";
        break;
     case 3:
        $name = "工业自动化学院";
        break;
     case 4:
        $name ="材料与环境学院";
        break;
     case 5:
        $name = "航空学院";
        break;
     case 6:
        $name = "数理与土木工程学院";
        break;
     case 7:
        $name ="商学院";
        break;
     case 8:
        $name ="会计与金融学院";
        break;
     case 9:
        $name = "外国语学院";
        break;
     case 10:
        $name ="民商法律学院";
        break;
     case 11:
        $name ="设计与艺术学院";
        break;
     case 12:
        $name = "布莱恩特学院";
        break;
     default:
        $name ="error";
        break;
   }
   return $name;
}
//获取学年
function getYear($sid){
   $syear = "";
   switch($sid){
     case "1_1":
        $syear = "2017-2018-第1学期";
        break;
     case "1_2":
        $syear = "2017-2018-第2学期";
        break;
     case "2_1":
        $syear = "2018-2019-第1学期";
        break;
     case "2_2":
        $syear = "2018-2019-第2学期";
        break;
     case "3_1":
        $syear = "2019-2020-第1学期";
        break;
     case "3_2":
        $syear = "2019-2020-第2学期";
        break;
     case "4_1":
        $syear = "2020-2021-第1学期";
        break;
     case "4_2":
        $syear = "2020-2021-第2学期";
        break;
     case "5_1":
        $syear = "2021-2022-第1学期";
        break;
     case "5-2":
        $syear = "2021-2022-第2学期";
        break;
     case "6_1":
        $syear = "2022-2023-第1学期";
        break;
     case "6_2":
        $syear = "2022-2023-第2学期";
        break;
     default:
        $syear = "年份出错";
        break;
   }
   return $syear;
}
