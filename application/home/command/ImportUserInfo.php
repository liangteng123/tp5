<?php
namespace app\home\command;
use think\Env;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use PHPExcel_IOFactory;
use PHPExcel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use app\home\model\UserInfo;
/**
* @ author :  liangteng
* @ params :  
* @ intro  :  导出人气酒店活动报名信息
* @ return :  
*/
class ImportUserInfo extends Command
{     
    protected function configure()
    {
        $this->setName('importUserInfo')->setDescription('导出人气酒店报名信息');
    }
    public function execute(Input $input, Output $output){
        $userinfo = new UserInfo;
        $data = $userinfo->getUserInfo();
        $file_name = date("YmdH");
        // 执行导出
        $res = $this->changeExcel($data,$file_name);
        // 发送邮件  邮件配置
        $host = Env::get('MAIL_HOST');
        $port = Env::get('MAIL_PORT');
        $from_add = Env::get('MAIL_FROM_ADDRESS');
        $from_name = Env::get('MAIL_FROM_NAME');
        $encryption = Env::get('MAIL_ENCRYPTION');
        $username = Env::get('MAIL_USERNAME');
        $password = Env::get('MAIL_PASSWORD');
        $tomail = Env::get('MAIL_TO');
        $tomailname = Env::get('MAIL_TO_NAME');
        $subject = Env::get('MAIL_SUBJECT');
        $body = Env::get('MAIL_BODY');
        $attachment = [$res];
        $tomails = explode(',', $tomail);
        $i = 0;
        $j = 0;
        $data = '';
        $str1 = '';
        foreach($tomails as $v){
            $res = HxeUtil::send_mail($encryption, $host, $port, $username, $password, $from_add, $from_name, $subject, $body, $v, $tomailname, $attachment);
            if($res === true){
                $i++;
            }else{
                $j++;
                $str1.=$v."=>".$res.";"; 
            }
        }
        $time = date("Y-m-d H:i:s",time());
        $data = "发送成功".$i."个，"."失败".$j."个。未发送到".$str1.$time."\r\n";
        file_put_contents('./user/log.txt',$data,FILE_APPEND);
        echo "完成";
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  数据库数据导出Excel
    * @ return :  
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
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ted.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
        header ('Cache-Control: cache, must-revalidate'); 
        header ('Pragma: public'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $path = './user/'.$file_name.'.xls';
        $objWriter->save($path);
        return $path;
    }

    /**
    * @ author :  liangteng
    * @ params :  
    * @ intro  :  数据库数据导出 txt 文件
    * @ return :  
    */
    // protected function changeExcel($data, $file_name = '')
    // {
    //     $title_arr = array(
    //         '序号',
    //         '所在城市',
    //         '酒店名称',
    //         '联系人姓名',
    //         '联系人手机号',
    //         '联系人邮箱',
    //         '创建时间',
    //     );
    //     $ReportContent = "";
    //     foreach($title_arr as $k=>$v)
    //     {    
    //         $ReportContent .= '"'.$v.'"'."\t";    
    //     }
    //     $ReportContent .= "\r\n";
    //     foreach($data as $k=>$v)
    //     {
    //         $ReportContent .= $v['id']."\t"; //id
    //         $ReportContent .= $v['city_name']."\t"; //城市
    //         $ReportContent .= $v['hotel_name']."\t"; //酒店名称
    //         $ReportContent .= $v['user_name']."\t"; //联系人
    //         $ReportContent .= $v['mobile']."\t"; //手机号
    //         $ReportContent .= $v['email']."\t"; //邮箱
    //         $ReportContent .= $v['create_time']."\t"; //添加时间
    //         $ReportContent .= "\r\n";
    //     }

    //     $path_excel = './user';
    //     if(!file_exists($path_excel)) mkdir($path_excel,0777,true);
    //     $path = $path_excel.'/'.$file_name . '.txt';
    //     // $ReportContent = mb_convert_encoding($ReportContent,"gbk","utf-8");  
    //     file_put_contents($path, $ReportContent);
    //     return $path;
    // }//方法的结束符

}