<?php
namespace app\home\hui;
/**
 * Class Dictionary
 *    词典项 
 */
class Dictionary{
    //供应商类型
    private static $supplierType = array(
        'H'=>'酒店',
        'L'=>'搭建',
        'P'=>'摄影',
        'G'=>'礼品',
        'E'=>'策划',
        'T'=>'旅行社',
        'V'=>'用车',
        'Q'=>'其它'
    );

    //获取字段名
    public static function getFieldName($key = ''){
        if($key !== ''){
            return isset(self::$fileds[$key]) ? self::$fileds[$key] : '';
        }
        return '';
    }
}
