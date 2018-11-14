<?php
namespace app\index\model;
use think\Db;
use think\Validate;
use think\Loader;
use think\Model;

class WxPay extends model
{
    /**
     * 生成订单号
     * @param string $prefix
     * @return string
     */
    public static function genOrderNo($prefix = '') {
        $no = substr(implode(null, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        return sprintf("%s%s%s", strtoupper($prefix),123, $no);
    }

}			