<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;

use app\home\model\Upai;

/**
* @ author :  liangteng
* @ params :  
* @ intro  :  各种方法demo
* @ return :  
*/

class DemoController  extends Controller
{
    /*** 循环添加入库，如果有一个失败，输出一个唯一标志，不要使用true或false，否则会在循环中被替换 ***/
    public function addImg(){
        $info = [
            [],
            // ['img'=>'qweqweqweqwe'],
            // ['img'=>'qweqweqweqwe'],
            // ['img'=>'qweqweqweqwe'],
            // ['img'=>'qweqweqweqwe'],
            // ['img'=>'qweqweqweqwe']
        ];
        foreach($info as $k=>$v){
            $upai = new Upai;
            $res = $upai->addImg($v);
            // if($k == 2)
            //     $res = false;
            if(!$res){
                echo 999;
            }
        }
        if($res){
            echo 123;
        }else{
            echo 234;
        }
    }

    /*** 中文字符串 ***/
    public function stringAction(){
        $str = "会小二网中国最大的会议预订平台";
        strlen($str); // 返回字符数
        mb_strlen($str,'utf8'); // 计算中文字数，第二个参数为编码字符集
        mb_substr($str,0,$num1,'utf8'); // 中文字符串截取
    }
}
