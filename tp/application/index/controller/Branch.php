<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\service\Branch as BranchModel;

/**
 * 分馆1,2,3
 */
class Branch extends Base{
   //分馆 座位 显示
   public function branch(){
      $branch    = new BranchModel();
      if(!empty(Input('param.id'))){
         // $branchId   = Input('param.id');
         // $data       = $branch->getBranchInfo($branchId);
         // $seatArray  = array();
         // $seatempty  = array();

         // foreach($data['data'] as $v){
         //    $seat  = $v['seatid']-1;
         //     for($i=0;$i<30;$i++){
         //       for($j=0;$j<10;$j++){
         //          if($i*10+$j==$seat){
         //             $seatArray[$j]=$i;
         //          }
         //       }
         //    }
         // }
         // for($k=$data['max'];$k<=300;$k++){
         //    for($i=0;$i<30;$i++){
         //       for($j=0;$j<10;$j++){
         //          if($i*10+$j==$k){
         //             $seatempty = array($i=>$j);
         //          }
         //       }
         //    }
         // }
        
         // var_dump($seatArray);exit;
         // $this->assign('seatArray',$seatArray);
         // $this->assign('seat',$seatempty);
         return $this->fetch();
      }
      
   }
   //分馆1
   public function firstLib(){

   }
   //分馆2
   public function secondLib(){

   }
   //分馆3
   public function thirdLib(){

   }
   //预约
   public function orderLib(){

       // if(!empty(Input("param.id"))){
       //   $seatid  = Input("param.id");
       //   $this->assign("seatid",$seatid);
       //   return $this->fetch();
       // }else{
       //   return view('Branchlib/branch');
       // }
       return $this->fetch();
   	  
   }
   //预约情况展示
   public function ordershow(){
        $order  = new BranchModel();
        //$number = Session::get('number');
        $number = "150201102018";
        $data   = $order->getOrderInfo($number);
        $this->assign("data",$data);
   	  return $this->fetch();
   }
   //录入 预约信息
   public function saveOrder(){
      $branch   = new BranchModel();
        if(request()->isAjax()){
            //$number  = Session::get('number');
            $number  = "150201102018";
            $seatid  = $_POST['seatid'];
            $branchid= $_POST['branch'];
            $array   = array(
                       'stimer'=>$_POST['stimer'],
                       'etimer'=>$_POST['etimer'],
                       'dtimer'=>$_POST['dtimer'],
                       'seatid'=>$seatid,
                       'branch'=>$branchid,
                       'number'=>$number
                       );
            //查询 座位 是否还存在

            $state   = $branch->checkSeat($seatid,$branchid);
            if($state==0){
               $rstid   = $branch->recordOrderInfo($array);
               if($rstid){
                  return AjaxReturn(1,"预约成功");
               }else{
                  return AjaxReturn(2,"预约失败");
               }
            }else{
               return AjaxReturn(0,"抱歉，座位已被占");
            }
            
        }
   }
   
}
?>