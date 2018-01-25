<?php
namespace app\home\model;
use think\Model;

class Upai extends Model 
{

    protected $table = 'qiniu_img';
    public   $field = array(
            'id'=>'',
            'img'=>'',
            'status'=>'',
            'is_deleted'=>''
    );
    // 获取图片列表
    public  function getImgList($page){
        $map = ['status'=>0,'is_deleted'=>0];
        $list = $this->where($map)->order('id desc')->paginate(3,false,['page'=>$page]);
        if($list){
            return $list->toArray();
        }
        return false;
    }
    // 添加图片
    public function addImg($data){
        return $this->insertGetId($data);
    }
    // 修改图片状态
    public function editStatus($id,$status){
        $map = ['status'=>0,'is_deleted'=>0,'id'=>$id];
        return $this->where($map)->update(['status'=>$status]);
    }
    // 删除图片
    public function delImg($id){
        $map = ['status'=>0,'is_deleted'=>0,'id'=>$id];
        return $this->where($map)->update(['is_deleted'=>1]);
    }

} 
