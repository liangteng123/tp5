<?php
namespace app\home\model;
use think\Env;

class QiniuClass {
    //上传图片到七牛云, $file 要上传的文件名(绝对路径）
    public function upload($file,$key=null,$bucket='hui-images') {
        $qiniu = new \gmars\qiniu\Qiniu(Env::get('ACCESSKEY'),Env::get('SECRECTKEY'),$bucket,$file,$key);
        $result = $qiniu->upload();
        if($result === false) {
            return json(['status'=>'-1','msg'=>"上传失败"]);
        } else {
            return json(['status'=>'0','msg'=>"上传成功"]);
        }
    }   

    //删除七牛空间的图片，传入参数为七牛空间的hash值。
    public function del($hash) {
        //读取七牛的配置
        $setting = C('UPLOAD_IMAGE_QINIU');
        $accessKey = $setting['driverConfig']['accessKey'];
        $secretKey = $setting['driverConfig']['secrectKey'];
        $bucket    = $setting['driverConfig']['bucket'];

        $auth = new Auth($accessKey, $secretKey);
        $bucketManager = new BucketManager($auth);
        return $bucketManager->delete($bucket, $hash);
    }

}
?>
