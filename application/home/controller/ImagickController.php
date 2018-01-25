<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;

class ImagickController  extends BaseController
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
    * @ params :  链接地址，代言介绍，返回的图片名称
    * @ intro  :  人气酒店海报页生成,生成二维码,图片水印,文字水印
                                                                    (一定要记得设置字体，一定要记得设置字体，一定要记得设置字体)
    * @ return :  生成后的图片文件名
    */

    // 二维码生成  引入phpqrcode.php文件，生成二维码（文件在public下）
    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  生成二维码，下载phpqrcode文件，整体复制到vendor下，使用Vendor调用,方法内必须实例化，使用对象调用生成二维码文件
    * @ return :  
    */
    public function twocode($url){ 
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
        $filename = 'qrcode/'.time().'.png';  
        $object->png($url,$filename , $errorCorrectionLevel, $matrixPointSize, 2);       
        $QR = $filename;                //已经生成的原始二维码图片文件    
        $QR = imagecreatefromstring(file_get_contents($QR));      
        //输出图片    
        // imagepng($QR, 'qrcode.png');    
        // imagedestroy($QR);  
        // echo '<img src='.$filename.' alt="使用微信扫描支付">'; 
        return $filename;
    }

    // 图片水印 （为海报添加酒店二维码）
    public function image_mark($src_file, $mark_file, $dest_file, $position='south', $frame='+0+16') {
        $convert = Env::get('CONVERT');
        @exec("\"{$convert}\" {$src_file} {$mark_file} -transparent white -gravity {$position} -geometry {$frame} -composite {$dest_file}");
    }

    // 文字水印 last    mogrify 直接在图片上修改
    public function font_mark($str,$file_name,$qr_code){
        $mogrify = Env::get('MOGRIFY');
        $num = mb_strlen($str,'utf8');
        $img_name = time().'.jpg';
        if($num>12){
            $this->image_mark('./images/2.jpg',$qr_code,$file_name,'center','+0+788');
            $num1 = ceil($num/2);
            $str1 = mb_substr($str,0,$num1,'utf8');
            file_put_contents('a.txt',$str1);
            @exec("\"{$mogrify}\" -font ./images/PingFang_3.otf -pointsize 140 -fill #E2B679 -weight bolder -gravity center -annotate +0-280 @\"a.txt\" ".$file_name);
            $str2 = mb_substr($str,$num1,$num,'utf8');
            file_put_contents('a.txt',$str2);
            @exec("\"{$mogrify}\" -font ./images/PingFang_3.otf -pointsize 140 -fill #E2B679 -weight bolder -gravity center -annotate +0-100 @\"a.txt\" ".$file_name);
        }else{
            $this->image_mark('./images/1.jpg',$qr_code,$file_name,'center','+0+788');
            file_put_contents('a.txt',$str);
            exec("\"{$mogrify}\" -font ./images/PingFang_3.otf -pointsize 140 -fill #E2B679 -weight bolder -gravity center -annotate +0-280 @\"a.txt\" ".$file_name);
        }
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  测试调用
    * @ return :  
    */
    public function test(){
        $url = "https://www.baidu.com";
        $str = "为北京香格里拉大酒店为北京香格里拉代言";
        // $str = "为北京香格里拉代言";
        $file_name = "./images/".time().rand(1000,9999).".jpg";
        $qr_code = $this->twocode($url);
        $this->font_mark($str,$file_name,$qr_code);
    }

}
