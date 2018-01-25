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

class importDining extends Command
{

    protected function configure(){
        $this->setName('importDining')->setDescription('导入包厢数据');
    }


    protected function execute(Input $input, Output $output){

        $file_path = 'application/home/command/dining.xlsx';

        $reader = PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档

        $PHPExcel = $reader->load($file_path); // 文档名称

        $objWorksheet = $PHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // 取得总行数

        $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
        //echo $highestRow.$highestColumn;
        // 一次读取一列
        $res = array();
        $field_arr = [0=>'hotel_id',3=>'name',4=>'floor',5=>'max_desk',6=>'max_capacity',7=>'space',8=>'desk_size',9=>'height',10=>'net_height',21=>'min_consumption',22=>'selling_point',23=>'note'];
        $tag_arr = [11,12,13,14,15,16,17,18,19,20];
        $tag = array();
        for ($row = 3; $row <= $highestRow; $row++) {
            for ($column = 0; $column<=24; $column++) {
                $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                if(empty($val) && $column === 0)
                    break;
                if(isset($field_arr[$column])){
                    if(empty($val))
                        $val = '';
                    $res[$row-2][$field_arr[$column]] = $val;
                }
                $has_projection = false;
                switch ($column){
                    case 11:
                        $has_projection = $val == '是' ?  true: false;break;
                    case 12:
                        $projection_lumen = $val;break;
                    case 13:
                        $projection_inch = $val;break;
                    case 14:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>2,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 15:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>3,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 16:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>4,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 17:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>5,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 18:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>6,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 19:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>7,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                    case 20:
                        $val == '是' ? $tag[$row-2][] = ['tag_id'=>8,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[]'] : '';break;
                }
                if($has_projection)
                    $tag[$row-2][] = ['tag_id'=>1,'create_by'=>1,'create_by_name'=>'root','attach_tag'=>'[{"name":"\u6d41\u660e\u5ea6","value":7000},{"name":"\u5e55\u5e03\u5c3a\u5bf8","value":60}]'];
            }
        }
        $diningRoomModel = new DiningRoom();
        $diningFacilityModel = new DiningFacility();
        foreach ($res as $k=>$v){
            $v['create_by'] =1;
            $v['create_by_name'] = 'root';
            $v['create_time'] = time();
            $v['status'] = 1;
            $diningRoomModel->insert($v);
            $last_insert_id = $diningRoomModel->getLastInsID();
            if($last_insert_id){
                if(isset($tag[$k])){
                    foreach ($tag[$k] as $kk=>$vv){
                        $vv['dining_id'] = $last_insert_id;
                        $diningFacilityModel->insert($vv);
                    }
                }
            }
        }
        print_r($res);
    }
}