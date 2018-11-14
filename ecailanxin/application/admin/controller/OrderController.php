<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class OrderController extends controller {
//	显示订单页面
	public function order() {
		return $this->fetch();
	}
//	显示订单列表
	public function orderlist(){
		$shous= input('post.shous');
		$shous1= input('post.shous1');
		$shous2= input('post.shous2');
		$rowset = Db::table('ycl_order')->paginate(1);
		$wxlist = $rowset->all();
//		print_r($wxlist);die;
		foreach($wxlist as $k => $v){
			$buy = Db::table('ycl_user')->where('id',$v['buy_id'])->find();
			$wxlist[$k]['buy_id'] = $buy['username'];
			
		}
//		    	$aa = array_column($buy,'username','id');
//		    	$this->assign('aa',$aa);
		$this->assign('rowset',$rowset);
		$this->assign('wxlist',$wxlist);
//	    if($shous == null){		
//	   
//	    	if($shous1 !==null && $shous2 !==null){
//		    	$rowset = Db::table('ycl_order')->whereTime('add_time', 'between', ["$shous1", "$shous2"])->select();
//		    	$this->assign('rowset',$rowset); 
//	    	}else{
//		    	$rowset = Db::table('ycl_order')->paginate(10);
//		    	$buy = Db::table('ycl_user')->select();
//		    	$aa = array_column($buy,'username','id');
//		    	$this->assign('aa',$aa);
//		    	$this->assign('rowset',$rowset);
//	    	}
//	    	}else{
//				$data['order_type'] = array('like' , "%$shous%");
//				$rowset = Db::table('ycl_order')->where($data)->select();
//				$this->assign('rowset',$rowset);
//			}
		return $this->fetch();
	
	}
	//	向数据库保存订单数据
	public function save(Request $request) {
		$data['order_type'] = $request->post('ordertype');
		$data['order_status'] = $request->post('status');
		$data['add_time'] = $request->post('add');
		$data['good_num'] = $request->post('goodnum');
		$data['good_pirce'] = $request->post('good');
		$data['complate_time'] = $request->post('complate');
		$rowset = Db::table('ycl_order')->insert($data);
		return $this->redirect(url('/admin/order1/orderlist'));
	}
//	显示修改订单列表
	public function orderedit() {
	 	$id = input('param.id');
		$rowset = Db::table('ycl_order')->where('id',$id)->find();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
//	修改订单数据
	public function update(Request $request) {
		$id = input('param.id');
		$data['order_type'] = $request->post('ordertype');
		$data['order_status'] = $request->post('orderstatus');
		$data['good_num'] = $request->post('goodnum');
		$data['good_pirce'] = $request->post('goodpirce');
		$data['complate_time'] = $request->post('complate');
	$rowset = Db::table('ycl_order')->where('id',$id)->update($data);
	return $this->redirect(url('/admin/order1/orderlist'));
	}
//	删除订单数据
	 public function delete($id) {
		$rowset = Db::table('ycl_order')->where('id',$id)->delete();
		return $this->redirect(url('/admin/order1/orderlist'));
	}
	
	
		public function shoplist(){ //商家订单
		$rowset = Db::table('ycl_order')->where('shop_status != 0')->paginate(1);
		$wxlist = $rowset->all();
//		print_r($wxlist);die;
		foreach($wxlist as $k => $v){
			$buy = Db::table('ycl_user')->where('id',$v['buy_id'])->find();
			$wxlist[$k]['buy_id'] = $buy['username'];
		}

		$this->assign('rowset',$rowset);
		$this->assign('wxlist',$wxlist);
		return $this->fetch();
	
	}
}