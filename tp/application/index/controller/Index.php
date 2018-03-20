<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\service\Index as IndexModel;
class Index extends Base
{
    
    public function index(){
      $index   = new IndexModel();
      //$openid  = Session::get("openid");
      $number  = Session::get("number");
      $info    = $index->getUserInfo($number);
      $this->assign("info",$info);
      return $this->fetch();
    }
    //考研和考证选择页面
    public function select(){
       //$openid   = Input("param.openid");
       
       $number = Session::get("number");
       if(!empty($number)){
        return $this->fetch("select");
       }
           
       
    }
    //个人信息页面，显示选座信息
    public function user(){
       // $index      = new IndexModel();
       // $studentNo  = Session::get('number');
       // $data       = $index->getUserInfo($studentNo);
       // $this->assign('data',$data);
       return $this->fetch();
        
    }
    /**
     * 版本号信息界面
     */
    public function version(){
       return $this->fetch();
    }
    /**
     * 学生预约的历史信息
     */
    public function history(){
        return $this->fetch();
    }
}
