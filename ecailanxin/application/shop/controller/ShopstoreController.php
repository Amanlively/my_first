<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Request;
header("Content-type: text/html; charset=utf-8");
class ShopstoreController extends Controller{
	
	public  function shopsetting(){ //店铺设置
		$row = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
		$this->assign('row',$row);
		return $this->fetch();
	}
	
	
	public  function edit(Request $request,$id){ //店铺信息修改
		$data['shop_name']     = input('post.shop_name'); //店名
		$data['shoptype']      = input('post.shoptype');  //店类型
		$data['address']       = input('post.address');   //店铺地址
		$data['manager_phone'] = input('post.manager_phone');// 联系电话
		$data['content']       = input('post.content');//店铺简介
		$data['status']        = input('post.ying');////营业状态
		$data['make']          = input('post.make');//预约达
		$data['deliver']       = input('post.deliver');//及时送
		$data['open_time']     = input('post.open');//开业时间
		$data['close_time']    = input('post.close');//打烊时间
		
		if($data['status'] == null){
			$data['status'] = input('param.ying1');
		}
		
		if($data['make'] == null){
			$data['make']   = input('param.make1');
		}
		
		if($data['deliver'] == null){
			$data['deliver']  = input('param.deliver1');
		}
		
		if($data['open_time'] == null){
			$data['open_time'] = input('param.open1');
		}
		
		if($data['close_time'] == null){
			$data['close_time'] = input('param.close1');
		}
//		print_r($data);die;
		$file = $request->file('file');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/shop' );
				if($info){
					$data['shop_img']=$info->getSaveName();
				}
			}
		Db::table('ycl_shop_info')->where('id',$id)->update($data);
		return $this->redirect('/shop/shopstore/shopsetting');
	}
}
