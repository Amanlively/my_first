<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\File;
use think\Db;

Class CategoryoneController extends Controller{
	
	public function categoryone(){
		$rowset = Db::table('ycl_category_one')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function addonetype(){
		return $this->fetch();
	}
	
	public function save(Request $request){
		$data['catonename'] = $request->post('catonename');
		$model = Db::table('ycl_category_one')->insert($data);
		return $this->redirect(url('admin/categoryone/categoryone'));
	}
	
	public function del($id){
		$row = Db::table('ycl_category_one')->where('id',$id)->delete();
		$this->assign('row',$row);
		return $this->redirect(url('/admin/categoryone/categoryone'));
	}
	
	public function edit($id){
		$row = Db::table('ycl_category_one')->where('id',$id)->find();
		$this->assign('row',$row);
		return $this->fetch();
	}
	
	public function update(Request $request,$id){
		$data['catonename'] = $request->post('catonename');
    	Db::table ( 'ycl_category_one' )->where ( 'id', $id )->update($data);
    	return $this->redirect(url('/admin/categoryone/categoryone'));
    }
	
}
