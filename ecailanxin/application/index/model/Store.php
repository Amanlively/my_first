<?php
namespace app\index\model;

use think\Model;
use think\File;
class Store extends Model
{
	//图片上传
	public static function uplodes($file){
		$info=$file->move (  \ENV::get('root_path') . '/public/static/uploads/mdimg' );
		if($info){
			$data = $info->getSaveName();
		}
		return $data;
	}
}

?>