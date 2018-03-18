<?php

/*

 * 关于考研和考证的座位选择

 */



namespace app\index\controller;

use app\index\service\Select  as SelectModel;

use app\index\controller\Base;

use think\Controller;

use think\Session;

use think\Url;

class Select extends Base{



	//考研或考证选座的渲染

	public function select(){
        $select = new SelectModel();
        if(!empty(Input("param.id"))){
            //id表示考证或考研
            $roomid         = Input("param.id");
            $data           = $select->getRoomInfo($roomid);
            $this->assign('data',$data);
            $this->assign("usage",$roomid);
            return $this->fetch();
        }else{
            return view('Index/select');
        }        
    }
    //到自习室中选座位
    //实现方法->将room.html座位一个模板，从数据库中取数据然后渲染到模板上
    public  function seat(){ 
        $select  = new SelectModel();
        $roomid  = Input("param.id");
        $data    = $select->getSeatInfo($roomid);
        $room    = $select->getRoomById($roomid);
        $choosed = array();//已选
        $i       = 0;
        foreach($data as $k=>$v){
           if($v['seat_state']==1){
            //表示该座位号被选了
            $choosed[$i++] = $v['seat_id'];
           }
        }
        $choosed = implode(",", $choosed);
        $this->assign("choosed",$choosed);
        $this->assign("data",$data);
        $this->assign("room",$room);
        return $this->fetch("room");
    } 

    //座位选择的确定

    public function seatSure(){
      $select          = new SelectModel();
    	if(request()->isAjax()){
            $usage           = $_POST['usage'];
            $roomid          = $_POST['roomid'];
            $seatid          = $_POST['seatid'];
            $number          = Session::get("number");
            $isSelect        = $select->getIsSelect($number);
            $isTime          = $this->checkTime();
            //此处应该加一个判断，判断大一大二不能选
            $num             = "20".substr($number,0,2);
            $num             = (int)$num;
            $year            = date('Y',time());
            $month           = date('m',time());
             //是否在时间范围内
            if(!$isTime){
              return json(array("code"=>0,"message"=>"不在规定时间范围内"));
            }
            if($isSelect){
                return json(array("code"=>0,"message"=>"您已经选完座位"));
            }
            if($usage==1){
               if($year-$num<=2){
                  if($month<9){
                   return json(array("code"=>0,"message"=>"大一大二只能选考证"));
                  }
              }
            }          
            //否则 开始选座
            $id            = $select->saveStudentSeatInfo($number,$roomid,$seatid);
            if($id){
            	return json(array("code"=>1,"message"=>"选座成功"));
            }
            return json(array("code"=>0,"message"=>"该座位已被选"));
    	}else{
    		return view("select");
    	}

    }

    //检验抢座时间是否过期
    public function checkTime(){
        $select   = new SelectModel();
        $array    = $select->getTimeArrange();
        $time     = time();//获取当前时间戳
        $stime    = strtotime($array['stimer']);//开始时间
        $etime    = strtotime($array['etimer']);//结束时间
        if($time>$etime||$time<$stime){
           //不在规定时间范围内
           return false;
        }else{
           return true;
        }
    }   

}

?>