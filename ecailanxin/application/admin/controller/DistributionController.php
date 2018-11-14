<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;

class DistributionController extends Controller{
	
	public function horse(){//骑手列表
			$rowset = Db::table('ycl_user')->where('user_type',1)->select();
//			print_r($rowset);die; 
			$this->assign('rowset',$rowset);
			return $this->fetch();
		}

    public function delete($id){//删除操作
		Db::table('ycl_user')->where('id',$id)->delete();
		return $this->redirect(url('/admin/distribution/horse'));
	}
	
	public function dining () {//餐厅管理
		$rowset = Db::table('ycl_user')->where('user_type',2)->select();
			$this->assign('rowset',$rowset);
			return $this->fetch();
	}
	
	public function delete1($id){//删除操作
		Db::table('ycl_user')->where('id',$id)->delete();
		return $this->redirect(url('/admin/distribution/dining'));
	}


	public function store () {//店铺管理
		$rowset = Db::table('ycl_user')->where('user_type',3)->select();
			$this->assign('rowset',$rowset);
			return $this->fetch();
	}
	
	public function delete2($id){//删除操作
		Db::table('ycl_user')->where('id',$id)->delete();
		return $this->redirect(url('/admin/distribution/store'));
	}
}