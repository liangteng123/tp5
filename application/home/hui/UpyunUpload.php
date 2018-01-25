<?php
namespace app\home\hui;
use app\home\hui\Upyun;
class UpyunUpload {
    public static function upload($src_file, $dest_file,$bucketname='imgykh',$username='cmsimguser',$password='He1601Chun') {
        $upyun = new UpYun($bucketname, $username, $password);
        try {
            $opts = array(
                    UpYun::CONTENT_MD5 => md5(file_get_contents($src_file))
            );
            $fh = fopen($src_file, 'rb');
            $rsp = $upyun->writeFile($dest_file, $fh, True, $opts);   // 上传图片，自动创建目录
            fclose($fh);
            if (!empty($rsp) && isset($rsp['x-upyun-height'])) {
                return true;
            }
        }
        catch(Exception $e) {
            return $e->getCode();
        }
    }
}
?>
