<?php
namespace app\shop\Controller;
use think\Controller;
use think\Db;
use think\Request;
use think\File;
class ShopapplyController  extends Controller{
	
	public function supplierapplication(){ //供货商申请显示页面
		$type = input('param.type');
    	$this->assign('type',$type);
    	
    	$row = Db::table('ycl_bazaar')->select();
    	$this->assign('row',$row);
		return $this->fetch();
	} 
	
	
	public function save(Request $request){ //供货商保存
		$data['true_name']    = input('post.name'); //姓名
		$data['number']       = input('post.number');//身份证号
		$data['phone']    	  = input('post.phone');//电话
		$data['dwell']        = input('post.address');//居住地址
		$data['register_type']= input('param.type');
		$data['site']    	  = input('post.site');//上班地点
		$data['bazaar']    	  = input('post.bazaar');//上班地点
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
					$data['pic']=$info->getSaveName();
				}
			}
			
			$file2 = $request->file('file3');
			if($file2){
				$info=$file2->move ( \ENV::get('root_path'). '/public/static/uploads/papers' );
				if($info){
					$data['boothimg']=$info->getSaveName();
				}
			}
		$rowset = Db::table('ycl_user')->insert($data);
		
		if ($rowset) {
			$this->redirect('/index/login/login');
		} else {
			$this->error('添加失败,稍后重试!');
		}
	} 
	
	
}
















