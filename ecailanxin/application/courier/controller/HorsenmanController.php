<?php
namespace app\courier\Controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;
class HorsenmanController extends Controller{
	
	public function missionapplication(){
		$type    = input('param.type');
//		print_r($type);die;
		$this->assign('type',$type);
		return $this->fetch();
	}
	
		
	public function save(Request $request){ //骑手保存
		
//		$a = $request->all();
//		dump($a);die;
		$data['true_name']    = input('post.true_name'); //姓名
		$data['number']       = input('post.number');//身份证号
		$data['phone']    	  = input('post.phone');//电话
		$data['dwell']        = input('post.dwell');//居住地址
		$data['register_type']= input('param.type');
		$data['site']    	  = input('post.site');//上班地点
		$data['cartype']      = input('param.cartype');//车辆类型
		$data['driving']      = input('param.driving');//驾驶证
		//$file    = input('param.file');//身份证件
		//$file1   = input('post.file1');//营业执照
		//$file2   = input('param.file2');//摊位照片
//		if ($name == null) {
//			$this->error('姓名不能为空!');
//		}
//		
//		if ($number == null) {
//			$this->error('身份证号不能为空!');
//		}
//		
//		if ($phone == null) {
//			$this->error('电话不能为空!');
//		}
//		
//		if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
//		$this->error('电话,格式不正确');
//		}
//		
//		if ($address == null) {
//			$this->error('居住地址不能为空!');
//		}
//		
//		if ($site == null) {
//			$this->error('上班地点不能为空!');
//		}
//		if ($cartype == null) {
//			$this->error('车辆类型不能为空!');
//		}
//		if ($driving == null) {
//			$this->error('驾驶证号不能为空!');
//		}
		
			$file0 = $request->file('file');
//			print_r($file0);die;
			if($file0){
				$info=$file0->move ( \ENV::get('root_path'). '/public/static/uploads/papers' );
				if($info){
					$data['idimg']=$info->getSaveName();
				}
			}
			
			$file1 = $request->file('file1');
			if($file1){
				$info=$file1->move ( \ENV::get('root_path'). '/public/static/uploads/papers' );
				if($info){
					$data['licence']=$info->getSaveName();
				}
			}
			
			$file2 = $request->file('file2');
			if($file2){
				$info=$file2->move ( \ENV::get('root_path'). '/public/static/uploads/papers' );
				if($info){
					$data['health']=$info->getSaveName();
				}
			}
		
//		
//		$arr = array(
//		'true_name'     => $name,
//		'number'        => $number,
//		'phone'         => $phone,
//		'register_type' => $type,
//		'dwell'         => $address,
//		'driving'       => $driving,
//		'site'          => $site,
//		'add_time'      => time(),
//		'cartype'       => $cartype,
//		'idimg'         => $file3,
//		'licence'       => $file4,
//		'health'        => $file5,
//		);
//						print_r($arr);die;
		$rowset = Db::table('ycl_user')->insert($data);
		
		if ($rowset) {
			$this->redirect('/index/login/login');
//			$this->success('添加成功!','/index/login/login');
		} else {
			$this->error('添加失败,稍后重试!');
		}
	} 
	
	
}












