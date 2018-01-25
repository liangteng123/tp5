<?php
namespace app\home\controller;
use app\home\hui\HxeUtil;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;
use think\Cache;
class BaseController extends Controller
{
    public function __construct($request=null) {
        return true;
        parent::__construct($request);
        $array = Session::get('user_info');
        $request = Request::instance();
        if(!$array) {
            $ticket = $request->get('ticket');
            if($ticket){
                //验证ticket，获取ticket的客户,设置session
                $output = HxeUtil::curl(Env::get('boss_center_user_info'),['ticket'=>$ticket,'appkey'=>Env::get('app_key')]);
                $array = json_decode($output, true);
                if($array['code']==1 && isset($array['data']['id'])){
                    Session::set('user_id', $array['data']['id']);
                    $realname = isset($array['data']['realname'])?$array['data']['realname']:'';
                    Session::set('realname', $realname);
                    Session::set('user_info', $array);
					Cache::set('uid_'.$array['data']['id'].'_session_id',session_id(),config('session.expire'));
                }else{
                    echo json_encode(['code'=>1100, 'msg'=>'授权失败！', 'data'=>'']);
                    exit;
                }
            }else{
                header('Location: /index/index?returnUrl='.$_SERVER['PHP_SELF']);
                exit;
            }
        }
        foreach($array['data']['menu'] as $one){
            if (false !== strpos($one['url'], Env::get('SITE_URL'))) {
                return true;
            }
        }
        echo json_encode(['code'=>1200, 'msg'=>'没有权限！', 'data'=>'']);
        exit;
    }
 
}
