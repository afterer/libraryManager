<?php
namespace app\admin\controller;
use app\admin\service\Publish as PublishModel;
use app\admin\controller\Base;
use think\Controller;
class Publish extends Base{
    
	public function index(){
		return $this->fetch();
	}
	
    
}
?>