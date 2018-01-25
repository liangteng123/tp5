<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;

use app\home\model\QiniuImg;
use app\home\model\QiniuClass;
use app\home\hui\UpyunUpload;

class BothController  extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        // $this->admin_id =  Session::get('user_id');
        // $this->admin_name = Session::get('realname');
        $this->admin_id =  "ceshi";
        $this->admin_name = "all_img";
    }

    public function imgList()
    {
        $page = input('page/d',1);
        $qiniu = new QiniuImg;
        $imgList = $qiniu->getImgList($page);
        $qiniu_img = Env::get('QINIU_IMG');
        $upai_img = Env::get('UPAI_IMG');
        if($imgList){
            return view('lists',['qiniu_img'=>$qiniu_img,'upai_img'=>$upai_img,'imgList'=>$imgList]);
        }
    }

    public function addImg(){
        if($_FILES){
            if(empty($_FILES['img']['name'])){
                echo '请上传图片';exit;
            }
            if($_FILES['img']['size']>5*1024*1024){
                echo '图片不能大于5M';exit;
            }
            $ext = strtolower(substr($_FILES['img']['name'],strrpos($_FILES['img']['name'],'.')+1));
            if (!in_array($ext,array('jpg','png','jpeg','gif'))) {
                echo '不符合图片的格式要求,请从新上传图片';exit;
            }
            $str = md5(date('YmdHis') . mt_rand(100000,999999));
            $new_file_name = $str . '.' . $ext;
            $upload_path = DOCUMENT_ROOT.'/uploads/qiniu';
            if(!file_exists($upload_path)) mkdir($upload_path,0777,true);
            $org_file_name = $upload_path . '/' . $new_file_name;
            if(!move_uploaded_file($_FILES['img']['tmp_name'],$org_file_name)){
                echo '图片上传失败,请从新上传未成功的图片';exit;
            }

            // 图片上传七牛云
            $img_src = $upload_path.'/'.$new_file_name; // 本地图片地址+图片名
            $qiniuModel = new QiniuClass;
            $uploaded_file_name = Env::get('IMG_DIR').$new_file_name; 
            $qiniuRet = $qiniuModel->upload($img_src,$uploaded_file_name,Env::get('QINIUBUCKET'));    
            if ($qiniuRet === false) { 
                echo '图片上传到七牛云失败,请从新上传未成功的图片';exit; 
            } 

            // 图片上传upaiyun
            $img_src = $upload_path.'/'.$new_file_name; // 本地图片地址+图片名
            $uploaded_file_name = '/'.Env::get('IMG_DIR').$new_file_name;
            $upyunRet = UpyunUpload::upload($img_src, $uploaded_file_name,Env::get('UPAIBUCKET'),Env::get('UPAIUSER'),Env::get('UPAIPASS'));
            if ($upyunRet === false) {
                echo '图片上传到upyun失败,请从新上传未成功的图片';exit; 
            }


            // 图片上传成功，将文件名入库
            $data['img'] = $new_file_name;
            $qiniu = new QiniuImg;
            $res = $qiniu->addImg($data);
            if($res){
                $this->redirect('imgList');
            }else{
                echo "<script>alert('图片上传失败');location.href=history.go(-1);location.reload()</script>";
            }
        }else{
            return view('addimg');
        }
    }
}
