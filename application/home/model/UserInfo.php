<?php 
namespace app\home\model;

use think\Model;

class UserInfo extends Model {
    protected $table = 'user_info';
    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  人气酒店数据
    * @ return :  
    */
    // 查询报名的酒店信息
    public function getUserInfo(){
        $fields = 'id,city_name,hotel_name,user_name,mobile,email,create_time';
        $users = $this->field($fields)
                            ->where("id>6")
                            ->select();
        if($users){
            return $users->toArray();
        }
        return false;
    }

}

 ?>