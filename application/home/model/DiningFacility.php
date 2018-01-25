<?php 
namespace app\home\model;

use think\Model;
use app\home\model\FacilityTags;

class DiningFacility extends Model {
    /**
     * 包厢设施数据
     */
    protected $table = 'dining_facility';

    // 根据包厢id查询关联的包厢设备(包厢详情页)
    public function getDiningFacility($id){
        $fields = 'id,tag_id,attach_tag';
        $diningFacilityList = $this->alias('d')
                            ->field($fields)
                            ->where(['d.is_deleted'=>0,'dining_id'=>$id])
                            ->select()->toArray();
        if($diningFacilityList){
            return $diningFacilityList;
        }
        return false;
    }
    // 根据包厢id，设施id查询单条
    public function getDiningFacilityOne($dining_id,$tag_id){
        $res = $this->field('id')
                    ->where(['is_deleted'=>0,'dining_id'=>$dining_id,'tag_id'=>$tag_id])
                    ->find();
        if($res){
            return $res->toArray();
        }
        return false;
    }
    // 删除关联的包厢设施
    public function delFacilityTags($id){
        return $this->where(['dining_id'=>$id,'is_deleted'=>0])->update(['is_deleted'=>1]);
    }
    public function deleteDiningFacility($id){
        return $this->where(['id'=>$id,'is_deleted'=>0])->update(['is_deleted'=>1]);
    }
    // 添加包厢设施信息
    public function addDiningFacility($data){
        return $this->insertGetId($data);
    }
    // 修改包厢设施信息
    public function saveDiningFacility($id,$data){
        return $this->where(['id'=>$id,'is_deleted'=>'0'])->update($data);
    }

}

 ?>