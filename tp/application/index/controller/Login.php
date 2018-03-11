<?php
/**
 * 处理用户登录，若用户没有绑定则需要在这绑定
 */
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Cookie;
use app\index\service\Login as LoginModel;
use app\index\service\Wechat as WechatModel;
class Login extends Controller{

    //学生绑定
    public function login(){
        $login    = new LoginModel();
        
        if($_POST){
            $studentNo   = Input('post.studentNo');
            $idcard      = Input('post.idcard');
            $phone       = Input('post.phone');

            $res         = $login->loginCheck($studentNo,$idcard,$phone);
            if($res){
                Session::set("number",$studentNo);
                Session::set("binding",true);
                Cookie::set("number",$studentNo);
                return json(array("code"=>1,"message"=>"绑定成功"));
            }else{
                return json(array("code"=>0,"message"=>"绑定失败"));
            }
        }else{
            return $this->fetch();
        }
    }

    public function test(){
        return $this->fetch();
    }

}
?>