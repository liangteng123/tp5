<?php 
namespace app\home\model;

use think\Model;

class FacilityTags extends Model {
    /**
     * 包厢设施数据
     */
    protected $table = 'facility_tags';

    // 获取全部包厢设施数据
    public function getFacilityList(){
        $fields = 'id,name,attach_name';
        $FacilityList = $this->field($fields)->where(['is_deleted'=>0])->select();
        if($FacilityList){
            $FacilityList = $FacilityList->toArray();
        }
        $facility = array();
        foreach($FacilityList as $k=>&$v){
            $facility[$v['id']]['value'] = 0;
            $facility[$v['id']]['name'] = $v['name'];
            if($v['attach_name']){
                $attach_tag = json_decode($v['attach_name'],true);
                $facility[$v['id']]['attach']= $attach_tag;    
            }else{
                $facility[$v['id']]['attach']=false;
            }
        }
        return $facility;
    }


}

 ?>