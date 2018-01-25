<?php
namespace app\home\controller;
use think\Controller;
use think\Env;
use think\Request;

use PHPExcel_IOFactory;
use PHPExcel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\home\model\UserInfo;

/**
* @ author :  liangteng
* @ params :  
* @ intro  :  控制器、方法 完成数据库导出、发送邮件
* @ return :  
*/
class OutUserController extends Controller
{
    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  发送邮件方法、注意：协议ssl支持windows，线上如果不支持，可以换成tls协议，端口号587
    * @ return :  
    */
    public function sendemail($tomail='', $name='', $subject = '', $body = '', $attachment = null){
        $mail = new PHPMailer();            //实例化PHPMailer对象
        $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP();                    // 设定使用SMTP服务
        $mail->SMTPDebug = 0;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
        $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';          // 使用安全协议
        $mail->Host = "smtp.exmail.qq.com"; // SMTP 服务器
        $mail->Port = 465;                  // SMTP服务器的端口号
        $mail->Username = "bin.liang@huixiaoer.com";    // SMTP服务器用户名
        $mail->Password = "FNcgKUqRub5HeCwS";     // SMTP服务器密码
        $mail->SetFrom('bin.liang@huixiaoer.com', '梁斌'); // 参数1，发件人邮箱地址 2，发件人昵称
        $replyEmail = '';                   //留空则为发件人EMAIL
        $replyName = '';                    //回复名称（留空则为发件人名称）
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = '测试邮件';
        $mail->MsgHTML('会小二测试邮件');
        $mail->AddAddress('764069186@qq.com', '梁腾');
        if (is_array($attachment)) { // 添加附件
            foreach ($attachment as $file) {
                is_file($file) && $mail->AddAttachment($file);
            }
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  查询数据库，取出需要导出的信息
    * @ return :  
    */
    public function outInfo(){
        $userinfo = new UserInfo;
        $data = $userinfo->getUserInfo();
        // 设置导出后的文件名
        $file_name = 123;
        // 调用生成txt文件的方发
        // $this->changeTxt($data,$file_name);
        // 调用生成xls文件的方法，返回值为文件所在路径
        $res = $this->changeExcel($data,$file_name);
        // 调用邮件发送
        $this->sendemail('','','','',$res);
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  导出数据生成txt文件
    * @ return :  
    */
    protected function changeTxt($data, $file_name = '')
    {
        $title_arr = array(
            '序号',
            '所在城市',
            '酒店名称',
            '联系人姓名',
            '联系人手机号',
            '联系人邮箱',
            '创建时间',
        );
        $ReportContent = '';
        foreach($title_arr as $k=>$v)
        {    
            $ReportContent .= '"'.$v.'"'."\t";       
        }
        $ReportContent .= "\n";
        foreach($data as $k=>$v)
        {
            $ReportContent .= $v['id']."\t"; //id
            $ReportContent .= $v['city_name']."\t"; //城市
            $ReportContent .= $v['hotel_name']."\t"; //酒店名称
            $ReportContent .= $v['user_name']."\t"; //联系人
            $ReportContent .= $v['mobile']."\t"; //手机号
            $ReportContent .= $v['email']."\t"; //邮箱
            $ReportContent .= $v['create_time']."\t"; //添加时间
            $ReportContent .= "\n";
        }
        // 程序判断文件保存目录是否存在，不存在需要新建
        if(!file_exists('../userinfo')) mkdir('../userinfo','0777',true);
        $path = '../userinfo/'.$file_name . '.txt';
        // 下面header是提供下载
        // header("Content-type:application/vnd.ms-excel;charset=UTF-8");
        // header("Content-Disposition:filename=".$file_name);
        // 数据库查出的文件格式 utf8 ；不需要转码，下面方法是把utf8转成gbk
        // $ReportContent = mb_convert_encoding($ReportContent,"gbk","utf-8");  
        file_put_contents($path, $ReportContent);
    }//方法的结束符

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  数据库数据导出Excel
    * @ return :  文件路径
    */
    protected function changeExcel($data, $file_name = '')
    {
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("huixiaoer.com")
                     ->setLastModifiedBy("huixiaoer.com")
                     ->setTitle($file_name)
                     ->setSubject($file_name)
                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                     ->setKeywords("office 2007 openxml php")
                     ->setCategory("Test result file");

        // Add data header
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '序号')
                    ->setCellValue('B1', '所在城市')
                    ->setCellValue('C1', '酒店名称')
                    ->setCellValue('D1', '联系人姓名')
                    ->setCellValue('E1', '联系人手机号')
                    ->setCellValue('F1', '联系人邮箱')
                    ->setCellValue('G1', '报名时间');
        $cc = 1;
        foreach ($data as $r) {
            $cc++;
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A{$cc}", $r['id'])
                        ->setCellValue("B{$cc}", $r['city_name'])
                        ->setCellValue("C{$cc}", $r['hotel_name'])
                        ->setCellValue("D{$cc}", $r['user_name'])
                        ->setCellValue("E{$cc}", $r['mobile'])
                        ->setCellValue("F{$cc}", $r['email'])
                        ->setCellValue("G{$cc}", $r['create_time']);
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('人气酒店报名表');
        $objPHPExcel->setActiveSheetIndex(0);
        // 下面header是设置浏览器页面下载
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="ted.xls"');
        // header('Cache-Control: max-age=0');
        // header('Cache-Control: max-age=1');
        // header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
        // header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
        // header ('Cache-Control: cache, must-revalidate'); 
        // header ('Pragma: public'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        if(!file_exists('../userinfo')) mkdir('../userinfo','0777',true);
        $path = '../userinfo/'.$file_name.'.xls';
        $objWriter->save($path);
        return $path;
    }
}