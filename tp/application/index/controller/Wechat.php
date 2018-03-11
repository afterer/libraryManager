<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\service\Wechat as WechatModel;
/**
 * 微信管理
 */
class Wechat extends Controller{
     
    //初始
    // public function _initialize(){

    //     $binding      = Session::get("binding");
    //     if(empty($binding)||!$binding){
    //         $this->error("请先绑定","Login/login",1);
    //     }
    // }
    
    public function check(){
       $openid   = Input("param.openid");
       $wechat   = new WechatModel();
        if(!empty($openid)){
           $res = $wechat->checkOpenid($openid);
           if($res){
            $this->success("进入首页","http://103.56.113.189/tp/index.php/index/index/selcet");
            Session::set("binding",true);

           }else{
            $this->error("信息核对","http://103.56.113.189/tp/index.php/index/Login/login?openid=".$openid);
           }
        }else{
          $url  = "http://103.56.113.189/think/index.php/Home/index/getBaseInfo";
          $this->error("Openid不存在",$url);
        }
    }
    // public function index(){
    //    $signature = $_GET["signature"];
    //    $timestamp = $_GET["timestamp"];
    //    $nonce     = $_GET["nonce"];
    //    $echostr   = $_GET["echostr"];
    //    $token     = "after123";   
    //    $array     = array();
    //    $array     = array($nonce,$timestamp,$token);

    //    sort($array,SORT_STRING);
    //    $str       = sha1(implode($array));
    //    if($str == $signature){
    //     echo $echostr;
    //     exit;
    //    } 
    // }
    
    // public function getBaseInfo(){
    //        $appid          = "wx50311f9306625b92";
    //        $redirect_uri   = urlencode("http://103.56.113.189/tp/index.php/index/wechat/getUserOpenid");//填写微信公众号的设置 域名  加上 跳转路径，还需 urlencode
    //        $scope          = "snsapi_base";//比较snapi_userinfo则有授权页面
    //        $url            = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=123#wechat_redirect";
    //        header('location:'.$url);
      
     

    // }
    // public function getUserOpenid(){
      
    //     $appid         = "wx50311f9306625b92";
    //     $appsecret     = "f7e5303bbf2baf9850723e06164816ff";
    //     $code          = $_GET['code'];
    //     $url           = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
    //     $res           = $this->http_curl($url);
    //      var_dump($res);
       
    // }
    // /**
    //  * curl 工具
    //  */
    //  public function http_curl($url,$method='get',$type="json",$data){
    //   //初始
    //     $ch              = curl_init();
    //     curl_setopt($ch,CURLOPT_URL,$url);
    //     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    //     curl_setopt($ch, CURLOPT_HEADER, 0);
    //     //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    //     if($method=='post'){
    //       curl_setopt($ch,CURLOPT_POST,1);
    //       curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    //     }
    //     $output          = curl_exec($ch);
    //     if($type == "json"){
    //       if(curl_errno($ch)){
    //         return curl_error($ch);
    //       }else{
    //          return json_decode($output,true);
    //       }
    //     }
    //     //关闭
    //     //curl_close($ch);
    //     //以上获取的 json格式，需要将它转为数组
        
    //     // $res             = json_decode($output,true);
    //     // return $res;
    // }
     
}

?>

