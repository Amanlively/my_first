<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\File;
use think\Db;

Class CategorytwoController extends Controller{
	
	public function categorytwo(){
		$rowset = Db::table('ycl_category_two')->select();
			foreach($rowset as $k=>$v){
    		$one = Db::table('ycl_category_one')->where('id',$v['up_catid'])->find();
    		$rowset[$k]['up_catid'] = $one['catonename'];
    	}
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function addtwotype(){
		$rowset = Db::table('ycl_category_one')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function save(Request $request){
		$data['up_catid'] = $request->post('yiji');
		$data['cattwoname'] = $request->post('cattwoname');
		$model = Db::table('ycl_category_two')->insert($data);
		return $this->redirect(url('admin/categorytwo/categorytwo'));
	}
	
	public function del($id){
		
		$row = Db::table('ycl_category_two')->where('id',$id)->delete();
		$this->assign('row',$row);
		return $this->redirect(url('/admin/categorytwo/categorytwo'));
	}
	
	public function edit($id){
		$row = Db::table('ycl_category_two')->where('id',$id)->find();
		$rowset = Db::table('ycl_category_one')->select();
		$this->assign('rowset',$rowset);
		$this->assign('row',$row);
		return $this->fetch();
	}
	
	public function update(Request $request,$id){
		$data['up_catid'] = $request->post('yiji');
		$data['cattwoname'] = $request->post('cattwoname');
    	Db::table ( 'ycl_category_two' )->where ( 'id', $id )->update($data);
    	return $this->redirect(url('/admin/categorytwo/categorytwo'));
    }
	
}
