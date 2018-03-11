<?php

/*

 * 后台管理员操作

 */

namespace app\admin\controller;

use think\Session;

use think\Db;

use app\admin\service\Admin as AdminModel;

use think\Controller;

use app\admin\controller\Base;

class Admin extends Base{

  //首页

  public function index(){



        $checked   = Session::get('checked');

        $username  = Session::get('username');

        if($checked){

          $admin     =  new AdminModel();

          $data      = $admin->getAdminInfo($username);

          if($data){

              Session::set('level',$data['level']);//保存当前用户的权限等级

              Session::set('name',$data['name']);

              $this->assign('data',$data);

              return view();

          }     

          return $this->fetch("login");   

        }else{

          return $this->fetch("login");

        }

  }

  

  //修改资料   

  public function modifyUser(){

    $admin     = new AdminModel();

    if(request()->isAjax()){

            $name      = $_POST['name'];

            $username  = $_POST['username'];

            $rstId     = $admin->updateUsername($username,$name);

            if($rstId){

               return json(array("code"=>1));

            }else{

              return json(array("code"=>0));

            }

    }else{

      $username  = session("username");

      $data      = $admin->getAdminInfo($username);

      $this->assign("data",$data);

      return $this->fetch("modifyUser");

    }

    

  }

  //修改密码

  public  function modifyPsw(){

    $admin     = new AdminModel();

    if(request()->isAjax()){

           $oldPasswd  = md5($_POST['oldPasswd']);

           $newPasswd  = md5($_POST['newPasswd']);

           $username   = Session::get('username');

           $rstId      = $admin->updatePasswd($username,$oldPasswd,$newPasswd);

           if($rstId){

            return json(array("code"=>1));

           }else{

            return json(array("code"=>0));
           }

    }

    return $this->fetch("modifyPsw");

  }

  //管理员列表

  public function adminList(){

        $admin    = new AdminModel();

        //如果是高级管理员的话，可以查看管理员列表，若不是则查看不了

        if(session("level")==1){

          $data     = $admin->getAdminList();

          $page     = $data->render();

          $status   = 1;

        }else{

          $data     ="抱歉，普通管理员不能查看列表";
          $page         ="null";

          $status   = 2;
          

        }

        $this->assign("data",$data);

        $this->assign("page",$page);

        $this->assign("status",$status);

    return $this->fetch("adminList");

  }

  //添加管理员

  public function addAdmin(){

    $admin    = new AdminModel();

        if(request()->isAjax()){

          $level  = Session::get('level');

            if($level==1){

            $array     = array(

                   'username'=>$_POST['username'],

                   'name'=>$_POST['name'],

                   'sex'=>$_POST['sex'],

                   'password'=>md5($_POST['password']),

                   'level'=>2

            );

              $rstId  = $admin->addAdmin($array);

              if(!$rstId){

                return json(array("code"=>0,"message"=>"用户已经存在"));

              }

              return json(array("code"=>1));

            }else{

              return json(array("code"=>0,"message"=>"用户等级不够"));

            }         

        }

    return $this->fetch("addAdmin");

  }

  //退出登录

  public function logout(){

    session(null);

    return json(array("code"=>1));

    //return $this->fetch("login");

  }

  

}

?>