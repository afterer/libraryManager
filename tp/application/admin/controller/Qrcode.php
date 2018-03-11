<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 可以通过一个id来分别总馆与分馆们，还可以通过渲染一个内容来共同使用同一模板
 * id ：1 总馆
 * id ：2 分馆1
 * id ：3 分馆2
 * id ：4 分馆3
 */
class Qrcode extends Base{
	//引导页
	
	/**
	 * 总馆6、7楼二维码签到
	 */
	public function mainlib(){
		//$sign  = "APP_MAIN/Signin/sign?id=1&tim=";
		$sign   = "http://103.56.113.189/think/index.php/Home/index/responseMsg?id=1&tim=";
		$this->assign('signUrl',$sign);
		return $this->fetch();
		      
	}
	/**
	 * 分馆1,2,3 二维码签到
	 */
	public function divisionlib(){
       
	}

    /*Vendor('phpqrcode.phpqrcode');
    $level                = 3;
    $size                 = 15;
    $time                 = time();
    $value                ='ADMIN/Student/signindex?time='.$time.'&id=7';
	$errorCorrectionLevel = intval($level); // 纠错级别：L、M、Q、H 
	$matrixPointSize      = intval($size); // 点的大小：1到10
	$qrcode               = new \QRcode();
	ob_end_clean();
	header('Content-Type:image/png');
	$qrcode::png($value,false, $errorCorrectionLevel, $matrixPointSize, 2);*/
}
?>
