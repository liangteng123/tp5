<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;
use think\Cache;
use think\Cookie;

class IndexController  extends Controller
{
    public function __construct(){
        $request = Request::instance();
        $ticket = $request->get('ticket');
        //回调地址
        $returnUrl = $request->get('returnUrl', '/foreground/index/user');
        if($ticket){
            //验证ticket，获取ticket的客户,设置session
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, Env::get('boss_center_user_info'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['ticket'=>$ticket,'appkey'=>Env::get('app_key')]);
            $output = curl_exec($ch);
            curl_close($ch);
            $array = json_decode($output, true);
            if($array['code']==1 && isset($array['data']['id'])){
                Session::set('user_id', $array['data']['id']);
                $realname = isset($array['data']['realname'])?$array['data']['realname']:'';
                Session::set('realname', $realname);
                Session::set('user_info', $array);
                $realname = isset($array['data']['realname'])?$array['data']['realname']:'';
                Session::set('realname', $realname);
				Cache::set('uid_'.$array['data']['id'].'_session_id',session_id(),config('session.expire'));
                $returnUrl = Cookie::get('returnUrl', 'crm');
                header('Location:'.$returnUrl);
            }else{
                header('Location:'.Env::get('boss_center_user_login'));
                exit;
            }
        }else{
            //先把跳转的url 存起来
            Cookie::set('returnUrl',$returnUrl,['prefix'=>'crm','expire'=>3600]);
            //跳转到boss获取此用户的ticket
            $session_ticket_url = Env::get('boss_center_callback');
            $dd = $session_ticket_url.'?appkey='.Env::get('app_key');
            header('Location:'.$dd);
            exit;
        }
    }

    public function index() {
        exit;
    }

    public function logout(){
        session(null); 
        header('Location:'.Env::get('boss_center_user_login'));
    }
}
