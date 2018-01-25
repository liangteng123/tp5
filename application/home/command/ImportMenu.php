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
use app\home\model\PPackageMenu;
use app\home\model\PPackageMenuInfo;

class ImportMenu extends Command
{

    protected function configure()
    {
        $this->setName('importMenu')->setDescription('导入菜单信息');
    }

    protected function execute(Input $input, Output $output)
    {
        $file_path = 'application/home/command/menu.xlsx';

        $reader = PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档

        $PHPExcel = $reader->load($file_path); // 文档名称

        $objWorksheet = $PHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // 取得总行数

        $highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
        //echo $highestRow.$highestColumn;
        // 一次读取一列
        $res = array();
        $field_arr = [1=>'hotel_id',3=>'m_name'];
        $food_type_1 = [14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
        $food_type_2 = [30,31,32,33,34,35,36,37];
        $food_type_4 = [38,39];
        $food_type_5 = [40,41];
        $food_type_6 = [42,43];
        $menuInfo = array();
        for ($row = 3; $row <= $highestRow; $row++) {
            for ($column = 0; $column<=43; $column++) {
                $val = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
                if(empty($val) && $column === 0)
                    break;
                if(isset($field_arr[$column])){
                    if(empty($val))
                        $val = '';
                    $res[$row-2][$field_arr[$column]] = $val;
                }
                // 整理菜品       
                if(in_array($column,$food_type_1)){
                    if(!empty($val))
                    $menuInfo[$row-2][] = ['name'=>$val,'type'=>1];
                }elseif(in_array($column,$food_type_2)){
                    if(!empty($val))
                        $menuInfo[$row-2][] = ['name'=>$val,'type'=>2];
                }elseif(in_array($column,$food_type_4)){
                    if(!empty($val))
                        $menuInfo[$row-2][] = ['name'=>$val,'type'=>4];
                }elseif(in_array($column,$food_type_5)){
                    if(!empty($val))
                        $menuInfo[$row-2][] = ['name'=>$val,'type'=>5];
                }elseif(in_array($column,$food_type_6)){
                    if(!empty($val))
                        $menuInfo[$row-2][] = ['name'=>$val,'type'=>6];
                } 
            }
        }
        var_dump($res);exit;
        $menuModel = new PPackageMenu();
        $menuInfoModel = new PPackageMenuInfo();
        foreach ($res as $k=>$v){
            $v['uid'] =1;
            $v['name'] = 'root';
            $v['create_time'] = time();
            $menuModel->insert($v);
            $last_insert_id = $menuModel->getLastInsID();
            if($last_insert_id){
                if(isset($menuInfo[$k])){
                    foreach ($menuInfo[$k] as $kk=>$vv){
                        $vv['m_id'] = $last_insert_id;
                        $menuInfoModel->insert($vv);
                    }
                }
            }
        }
        print_r($menuInfo);
    }
}