<?php 
namespace app\home\model;

use think\Model;

class DiningRoom extends Model {
    /**
     * 包厢数据
     */
    protected $table = 'dining_room';

    // 获取全部包厢数据(列表页)
    public function getDiningRoomList($map,$page){
        $map['is_deleted'] = 0;
        $fields = 'id,hotel_id,name,type,img_id,floor,min_desk,max_desk,desk_size,max_capacity,space,height,net_height,min_consumption,selling_point,note,status';
        $diningRoomLists = $this->field($fields)->where($map)->order('id desc')->paginate(10, false, [
            'page' => $page,
        ]);
        if($diningRoomLists){
            return $diningRoomLists->toArray();
        }
        return false;
    }
    // 根据包厢id获取单条包厢数据
    public function  getDiningRoomDetail($id){
        $fields = 'id,hotel_id,name,type,img_id,floor,min_desk,max_desk,desk_size,max_capacity,space,height,net_height,min_consumption,selling_point,note,status';
        $diningRoomDetail = $this->field($fields)->where(['is_deleted'=>0,'status'=>0,'id'=>$id])->find($id);
        if($diningRoomDetail){
            $diningRoomDetail = $diningRoomDetail->toArray();
        }
        return $diningRoomDetail;
    }
    // 删除包厢信息
    public function delDiningRoom($id){
        return $this->where(['id'=>$id,'is_deleted'=>0])->update(['is_deleted'=>1]);
    }
    // 添加包厢信息
    public function addDiningRoom($data){
        return $this->insertGetId($data);
    }
    // 修改包厢信息
    public function saveDiningRoom($data){
        return $this->where(['id'=>$data['id'],'is_deleted'=>0])->update($data);
    }
    // 修改包厢状态
    public function editStatus($id,$status){
        return $this->where(['id'=>$id,'is_deleted'=>0])->update(['status'=>$status]);
    }

}

 ?>