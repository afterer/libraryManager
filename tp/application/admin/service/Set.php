<?php
/**
 * 系统设置
 */
namespace app\admin\service;
use app\admin\model\Day as DayModel;
use app\admin\model\Publish as PublishModel;
class Set{
	 //修改统计天数
    public function modifyDay($day){
        if($day){
        	$setday = new DayModel();
        	$res  = $setday->where('id=1')->update(array('total_day'=>$day));
        	return $res;
        }
    }
    //获取当前统计
    public function getRecentDay(){
    	$day  = new DayModel();
    	return $day->where('id=1')->value('total_day');
    }
}
?>