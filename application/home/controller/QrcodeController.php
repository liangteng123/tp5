<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;

class QrcodeController  extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // $this->admin_id =  Session::get('user_id');
        // $this->admin_name = Session::get('realname');
        $this->admin_id =  "ceshi";
        $this->admin_name = "Qiniu_cloud";
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  生成二维码
    * @ return :  
    */
    public function twocode(){
        $url = "https://www.baidu.com";
        Vendor('phpqrcode.phpqrcode');
        $errorCorrectionLevel = 'L';    //容错级别   
        $matrixPointSize = 20;           //生成图片大小    20    
        // //生成二维码图片 
        $object = new \QRcode();
        // // 直接在浏览器显示
        // $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
        // exit; 
        // //生成二维码图片  
        if(!file_exists('./qrcode')) mkdir('./qrcode',0777,true);
        $filename = 'qrcode/'.time().rand(1000,9999).'.png';  
        $object->png($url,$filename , $errorCorrectionLevel, $matrixPointSize, 2);       
        $QR = $filename;                //已经生成的原始二维码图片文件    
        $QR = imagecreatefromstring(file_get_contents($QR));      
        //输出图片    
        // imagepng($QR, 'qrcode.png');    
        // imagedestroy($QR);  
        // echo '<img src='.$filename.' alt="使用微信扫描支付">'; 
        return $filename;
    }
}
