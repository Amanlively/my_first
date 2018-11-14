<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class CqshopController extends controller {
	//	显示店铺数据
	public function cqsh() {
		$rowset = Db::table('ycl_user')->where('is_sh',0)->where('register_type',1)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	
//	修改审核状态
	public function cqshtg() {
		$id   = input('param.id');
		$pass = input('param.pass');
		if ($pass == 1) {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',1);
			return $this->redirect(url('/admin/cqshop/cqshlist'));
		} else {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',2);
			return $this->redirect(url('/admin/cqshop/cqsh'));
		}
		
	}
	
//	显示审核列表
	public function cqshlist() {
		$rowset = Db::table('ycl_user')->where('is_sh',1)->where('register_type',1)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
//	删除餐企审核
	public function del() {
		$id = input('param.id');
		$rowset = Db::table('ycl_user')->where('id',$id)->delete();
		$this->redirect(url('/admin/cqshop/cqsh'));
	}
	
	
	
		//	显示供货商
	public function ghs() {
		$rowset = Db::table('ycl_user')->where('is_sh',0)->where('register_type',2)->select();
		$this->assign('rowset',$rowset);
		$rowset1 = Db::table('ycl_bazaar')->select();
		$shi = array_column($rowset1,'baname','id');
		$this->assign('shi',$shi);
		return $this->fetch();
	}
		
//	修改审核状态
	public function ghssh() {
		$id   = input('param.id');
		$pass = input('param.pass');
		$bazaar = input('param.bazaar');
		if ($pass == 1) {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',1);
            $shichang = Db::table('ycl_bazaar')->where('id',$bazaar)->value('city');
			$data['uid']      = $id;
            $data['city']      = $shichang;
			$data['bazaarid'] = $bazaar;
			$data['add_time'] = time();
			$data['shopmark'] =  date('md') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
			Db::table('ycl_shop_info')->where('id',$id)->insert($data);
			return $this->redirect(url('/admin/cqshop/ghslist'));
		} else {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',2);
			return $this->redirect(url('/admin/cqshop/ghs'));
		}
		
	}
	//	显示审核列表
	public function ghslist() {
		$rowset = Db::table('ycl_user')->where('is_sh',1)->where('register_type',2)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	//	删除供货商
	public function del1() {
		$id = input('param.id');
		$rowset = Db::table('ycl_user')->where('id',$id)->delete();
		$this->redirect(url('/admin/cqshop/ghs'));
	}
	
	
	
	
	
	
	
	
	
	
	
	
			//	显示配送员
	public function qis() {
		$rowset = Db::table('ycl_user')->where('is_sh',0)->where('register_type',3)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
		
//	修改审核状态
	public function qissh() {
		$id   = input('param.id');
		$pass = input('param.pass');
		if ($pass == 1) {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',1);
			return $this->redirect(url('/admin/cqshop/qislist'));
		} else {
			$rowset = Db::table('ycl_user')->where('id',$id)->setField('is_sh',2);
			return $this->redirect(url('/admin/cqshop/qis'));
		}
		
	}
	//	显示审核列表
	public function qislist() {
		$rowset = Db::table('ycl_user')->where('is_sh',1)->where('register_type',3)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	//	删除配送员
	public function del2() {
		$id = input('param.id');
		$rowset = Db::table('ycl_user')->where('id',$id)->delete();
		$this->redirect(url('/admin/cqshop/qis'));
	}
}
