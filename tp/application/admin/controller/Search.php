<?php
/**
 * 座位、学生查询
 */
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\service\Search as SearchModel;
use app\admin\service\Seat as SeatModel;
class Search extends Base{
    //学生查询
    public function student(){
        $search   = new SearchModel();
        if(request()->isAjax()){
            $array      = array();
            if(!empty($_POST['institute'])){
                $array['college'] = $_POST['institute'];
            }else if(!empty($_POST['major'])){
                $array['major']     = $_POST['major'];
            }else if(!empty($_POST['grade'])){
                $array['grade']     = $_POST['grade'];
            }else if(!empty($_POST['number'])){
                $array['number']    = $_POST['number'];
            }else if(!empty($_POST['name'])){
                $array['name']      = $_POST['name'];
            }
            // var_dump($array);exit;
            $data       = $search->getDataByConditions($array);
            //$page       = $data->render();
            if($data){
                // $page   = $data->render();
                return json(array("code"=>1,"message"=>"查询成功","data"=>$data));
                
            }else{
                return json(array("code"=>0));
            }
        }else{
            return $this->fetch();
        }

        
    }
    //座位查询
    public function seat(){
        $search   = new SearchModel();
        if(request()->isAjax()){
            $array    = array(
                'branchid'=>$_POST['branchid'],
                'seatid'=>$_POST['seatid']
            );
            $data     = $search->getDataBySeat($array);
            
            if($data){
                return json(array("code"=>1,"message"=>"查询成功","data"=>$data));
            }
        }else{
            return $this->fetch();
        }  
    }
}
?>