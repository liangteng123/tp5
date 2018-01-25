<?php
namespace app\home\command;
use app\home\model\DiningFacility;
use think\Controller;
use think\Env;
use think\Session;
use think\Request;
use think\Cache;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\home\hui\HxeUtil;
use app\home\hui\AES;
use PHPExcel_IOFactory;
use PHPExcel;
use app\home\model\DiningRoom;

class ImportConference extends Command
{

    protected function configure()
    {
        $this->setName('importConference')->setDescription('导入会议室数据信息');
    }

    protected function execute(Input $input, Output $output)
    {
        $file_path = 'application/home/command/conference.xlsx';

        $reader = PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档

        $PHPExcel = $reader->load($file_path); // 文档名称

        $objWorksheet = $PHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // 取得总行数

        $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
        //echo $highestRow.$highestColumn;
        // 一次读取一列
        $res = array();
        $conf_field_arr = [1=>'hotel_id',3=>'name',4=>'floor',5=>'banquet_space',6=>'is_square',7=>'length',8=>'width',9=>'height',10=>'net_height',11=>'has_pillar',45=>'class_capicity',46=>'theatre_capicity',47=>'fishbone_capicity'];
        $conf_meal_arr =[17=>'weekday_fee',18=>'weekend_fee',19=>'is_meal_service',20=>'meal_service_fee',21=>'is_bring_drinks',22=>'dinks_service_fee'];
        $tag_arr = [24,25,27,28,29,30,33,34,36,37,38,39,40];
        $price_arr = [41=>'sale_all_price',42=>'sale_half_price',43=>'hxe_all_price',44=>'hxe_half_price'];
        $tag = array();
        $conf_info = [];
        $conf_meal = [];
        $conf_price = [];
        for ($row = 4; $row <= $highestRow; $row++) {
            for ($column = 0; $column<=47; $column++) {
                $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                $res[$row][] = $val;

                if(isset($conf_field_arr[$column]))
                    $conf_info[$row-4][$conf_field_arr[$column]] = $val;
                if(isset($conf_meal_arr[$column]))
                    $conf_meal[$row-4][$conf_meal_arr[$column]] = $val;
                if(isset($price_arr[$column]))
                    $conf_price[$row-4][$price_arr[$column]] = $val;
            }
        }
        print_r($conf_info);
        print_r($conf_meal);
        print_r($conf_price);
    }
}