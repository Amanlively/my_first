<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class GoodstjController extends controller {
	//	显示推荐商品
	public function tjboom() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐 畅销榜
	public function updatetj(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',1);
			return $this->redirect(url('/admin/goodstj/tjboomlist'));
		}
	}
	public function delboomlist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/tjboomlist');
	}
	
	public function tjboomlist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',1)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function meat() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐 肉禽
	public function updatemeat(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',2);
			return $this->redirect(url('/admin/goodstj/meatlist'));
		}
	}
	public function delmeatlist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/meatlist');
	}
	public function meatlist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',2)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
		public function cargo() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐冻货专场
	public function updatecargo(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',3);
			return $this->redirect(url('/admin/goodstj/cargolist'));
		}
	}
	public function delcargolist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/cargolist');
	}
	public function cargolist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',3)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	
		public function muddle() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐调料专场
	public function updatemuddle(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',4);
			return $this->redirect(url('/admin/goodstj/muddlelist'));
		}
	}
	public function delmuddlelist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/muddlelist');
	}
	public function muddlelist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',4)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	
	
		public function drink() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐酒饮 粮油推荐
	public function updatedrink(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',5);
			return $this->redirect(url('/admin/goodstj/drinklist'));
		}
	}
	public function deldrinklist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/drinklist');
	}
	public function drinklist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',5)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
		public function process() {
		$rowset = Db::table('ycl_goods')->where('is_tj',0)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	改为推荐酒饮 粮油推荐
	public function updateprocess(Request $request) {
		$id = input('param.id');
		$tj = input('param.tj');
		if ($tj == 1) {
			Db::table('ycl_goods')->where('id',$id)->setField('is_tj',6);
			return $this->redirect(url('/admin/goodstj/processlist'));
		}
	}
	public function delprocesslist($id) {
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('is_tj',0);
		return $this->redirect('/admin/goodstj/processlist');
	}
	public function processlist() {
		$rowset = Db::table('ycl_goods')->where('is_tj',6)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	
}
