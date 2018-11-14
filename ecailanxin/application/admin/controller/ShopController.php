<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;
class ShopController extends controller {
//	显示添加店铺页面
	public function shop() {
		$rowset2 = Db::table('ycl_bazaar')->select();
		$this->assign('rowset2',$rowset2);
		return $this->fetch();
	}
//	向数据库保存店铺数据
	public function save(Request $request) {
		$data['bazaarid']  = $request->post('baname');
		$data['shop_name'] = $request->post('shop_name');
		$data['address']   = $request->post('address');
		$data['add_time']  = time();
		$data['open_time'] = $request->post('opentime');
		$data['close_time'] = $request->post('closetime');
		$data['delivery'] = $request->post('delivery');
		$data['content'] = $request->post('content');
			$file = request()->file('img');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/shop' );
				if($info){
					$data['shop_img']=$info->getSaveName();
				}
			}
		$rowset = Db::table('ycl_shop_info')->insert($data);
		return $this->redirect(url('/admin/shop/show'));
	}
	//	显示店铺数据
	public function show() {
		$yi=Db::table('ycl_bazaar')->select();
		$one = array_column($yi,'baname','id');
		$rowset = Db::table('ycl_shop_info')->paginate(2);
		$this->assign('rowset',$rowset);
		$this->assign('one',$one);
		return $this->fetch();
	}
//	编辑页面显示数据
	public function edit() {
	 	$id      = input('param.id');
		$rowset = Db::table('ycl_shop_info')->where('id',$id)->find();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	修改店铺数据
	public function update(Request $request) {
		$id = input('param.id');
		$data['shop_name'] = $request->post('shop_name');
		$data['address'] = $request->post('address');
		$data['open_time'] = $request->post('opentime');
		//$data['shop_img'] = $request->post('file');
		$data['close_time'] = $request->post('closetime');
		
		$file = request()->file('file');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/shop' );
				if($info){
					$data['shop_img']=$info->getSaveName();
				}
			}
			
	$rowset = Db::table('ycl_shop_info')->where('id',$id)->update($data);
	return $this->redirect(url('/admin/shop/show'));	
	}
//	删除店铺数据
	 public function delete($id) {
		$rowset = Db::table('ycl_shop_info')->where('id',$id)->delete();
		return $this->redirect(url('/admin/shop/show'));	
	}
	
	
	public function recycle() {
		$id = input('param.news_checkbox/a');
		
//				print_r($id);exit;
		$zt = input('param.zt');
		$model = Db::table('ycl_shop_info')->whereIn('id',$id);
		if($zt == 1) {
//							print_r($zt);die;
			$model->whereIn('id',$id)->delete();
		}
		return $this->redirect(url('/admin/shop/show'));
	}
	
}
