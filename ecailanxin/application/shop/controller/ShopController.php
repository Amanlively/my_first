<?php
namespace app\shop\controller;
use think\Controller;

use think\Db;
use think\Request;
class ShopController extends Controller
{
//	显示店铺
    public function myshop()
    {
    	if(session('userid') == null) {
		return $this->redirect(url('/index/login/login'));
		} else {
		$oneid = input('param.id');
//  	print_r($oneid);
    	$twoid = input('param.twoid');
    	$rowset = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	$query = Db::table('ycl_bazaar')->where('id',$rowset['bazaarid'])->find();
    	$one = Db::table('ycl_category_one')->select();
    	$two = Db::table('ycl_category_two')->where('up_catid',$oneid)->select();
    	if($twoid == null) {
    		$goods = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
    		$this->assign('goods',$goods);
    	} else {    		
    		$goods = Db::table('ycl_goods')->where('shopid',$rowset['id'])->where('cattwoid',$twoid)->select();
    		$this->assign('goods',$goods);
    	}
    	$this->assign('one',$one);
    	$this->assign('two',$two);
    	$this->assign('query',$query);
    	$this->assign('rowset',$rowset);
		}
    	
		return $this->fetch();
    }


	//显示尾货列表
	public function tailGoodsArea() {
		if(session('userid') == null) {
			return $this->redirect(url('/index/login/login'));
		} else {
			$rowset = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$goods = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
			$gg = Db::table('ycl_spec')->select();
			$goodsgg = array_column($gg,'name','id');
			$this->assign('goodsgg',$goodsgg);
			$this->assign('rowset',$rowset);
			$this->assign('goods',$goods);
		}
		
		return $this->fetch();
	}
	
	//添加尾货
     public function addinggoods() {
     	$id = input('param.id');
		$row = Db::table('ycl_goods')->where('id',$id)->find();
		$this->assign('row',$row);
		$this->assign('goodsid',$id);
		return $this->fetch();
	}
	// 添加尾货保存
	public function tailsave() {
		$id = input('param.id');
		$number = input('param.number');
		$price = input('param.price');
		$arr = array(
		'stock' => $number,
		'goodsprice' => $price,
		'tail' => 1
		);
		Db::table('ycl_goods')->where('id',$id)->update($arr);
		return $this->redirect(url('/shop/shop/tailGoodsArea'));
	}


	// 取消尾货
	public function taildel() {
		$id = input('param.id');
		Db::table('ycl_goods')->where('id',$id)->update(['tail' =>0]);
		return $this->redirect(url('/shop/myshop/tailGoodsArea'));
	}
     
}
