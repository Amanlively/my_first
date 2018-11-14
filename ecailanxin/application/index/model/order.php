<?php
namespace app\index\model;
use think\Db;
use think\Validate;
use think\Loader;
use think\Model;

class order extends model
{

    //根据采购单ID  返回采购单状态
    public static function status($id){

        return 66;
    }
}