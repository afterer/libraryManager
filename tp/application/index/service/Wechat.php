<?php
namespace app\index\controller;
use app\index\model\Wechat as WechatModel;

class Wechat{
	public function checkOpenid($openid){
    $wechat   = new WechatModel();
    $res      = $wechat->where(array("openid"=>$openid))->count();
    if($res){
      return true;
    }else{
      return false;
    }
  }
}
?>