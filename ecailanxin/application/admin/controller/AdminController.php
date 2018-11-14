<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class AdminController extends controller {
//	显示管理员添加页面
	public function admin() {
		return $this->fetch();
	} 
//	添加管理员
	public function save(Request $request) {
		$data['username'] = $request->post('username');
		$data['password'] = $request->post('password');
		$data['add_time'] = time();
		$data['nickname'] = $request->post('nickname');
		$data['limits'] = $request->post('limits');
		$rowset = Db::table('ycl_admin')->insert($data);
		return $this->redirect(url('/admin/admin/show'));
	}
//	显示管理员
	public function show() {
		$rowset = Db::table('ycl_admin')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	修改管理员页面
	 public function edit() {
	 	$id      = input('param.id');
		$rowset = Db::table('ycl_admin')->where('id',$id)->find();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	保存修改数据
	public function update(Request $request) {
		$id = input('param.id');
		$data['username'] = $request->post('username');
		$data['nickname'] = $request->post('nickname');
		$data['limits'] = $request->post('limits');
	$rowset = Db::table('ycl_admin')->where('id',$id)->update($data);
	return $this->redirect(url('/admin/admin/show'));	
	}
	
//	删除管理员
	 public function delete($id) {
		$rowset = Db::table('ycl_admin')->where('id',$id)->delete();
		return $this->redirect(url('/admin/admin/show'));	
	}
	
//	餐企申请开关
	public function cqset() {
		return $this->fetch();
	}
	
	public function cqsetxg() {
		$sz = input('param.sz');
		if ($sz == 1) {
			$rowset = Db::table('ycl_user')->where('variable',0)->find();
			Db::table('ycl_user')->where('variable',$rowset['variable'])->setField('variable',1);
			return $this->redirect(url('/admin/admin/cqset'));
		}
		
		if ($sz == 0) {
			$rowset = Db::table('ycl_user')->where('variable',1)->find();
			Db::table('ycl_user')->where('variable',$rowset['variable'])->setField('variable',0);
			return $this->redirect(url('/admin/admin/cqset'));
		}
		 
	}
	
}
