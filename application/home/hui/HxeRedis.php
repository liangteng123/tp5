<?php
namespace app\home\hui;
use \Redis;
class HxeRedis
{
    private static $redis;
    private static $prefix;

    public static function redis_connect($prefix = '') {
        $redis_config = config('redis');
        if (!extension_loaded('redis') ) {
            return;
        }
        $prefix = $prefix ? $prefix : \think\Env::get('SITE_PREFIX');
        self::$prefix = $prefix;
        self::$redis = new Redis();
        self::$redis->connect($redis_config['host'],$redis_config['port'],$redis_config['timeout']);
        return self::$redis->auth($redis_config['pass']);
    }

    //设置字符串
    public static function set_string($key,$data,$expire=''){
        if(self::redis_connect()){
            $data = json_encode($data);
            self::$redis->set(self::$prefix . $key,$data);
            self::set_expire($key,$expire);
        }
    }

    //取值字符串
    public static function get_string($key){
        if(self::redis_connect()){
            $data = self::$redis->get(self::$prefix . $key);
            return json_decode($data,true);
        }else{
            return array();
        }
    }

    //设置存活时间
    public static function set_expire($key,$timeout=''){

        if(self::redis_connect()){
            $redis_config = config('redis');
            if($timeout==''){
                self::$redis->expire(self::$prefix . $key,$redis_config['REDIS_EXPIRE']);
            }else{
                self::$redis->expire(self::$prefix . $key,$timeout);
            }
        }
    }
    
    //清空一个值
    public static function rm($key){
        if(self::redis_connect()){
            self::$redis->delete(self::$prefix . $key);
        }
    }
}
