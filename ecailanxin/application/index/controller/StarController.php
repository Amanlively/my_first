<?php
namespace app\index\Controller;
use think\Controller;
use think\Db;
class StarController extends Controller{
	
	public function star(){
//		$shop1  = Db::table('ycl_shop_info')->find();
		$collect     = Db::table('ycl_collect')->where('uid',session('userid'))->where('shop_id','not null')->select();
		foreach($collect as $k=>$v){
		$shop  = Db::table('ycl_shop_info')->where('id',$v['shop_id'])->find();
		$collect[$k]['shopid']  = $shop['id'];
		$collect[$k]['shop_id'] = $shop['shop_name'];
		$collect[$k]['shopimg'] = $shop['shop_img'];
		$collect[$k]['dizhi']   = $shop['address'];
//		print_r($collect);die;
		}
		$this->assign('collect',$collect);
		
		$collect1  = Db::table('ycl_collect')->where('uid',session('userid'))->where('goods_id','not null')->select();
		foreach($collect1 as $k=>$v){
		$goods     = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
		$shop_info = Db::table('ycl_shop_info')->where('id',$goods['shopid'])->find();
//		print_r($shop_info);
		$collect1[$k]['goodsid']      = $goods['id'];
		$collect1[$k]['goods_id']     = $goods['goodsname'];
		$collect1[$k]['goodsimg']     = $goods['goodspic'];
		$collect1[$k]['goodsmoney']   = $goods['discount'];
		$collect1[$k]['goodsgg']      = $goods['goodsgg'];
		$collect1[$k]['shop_id']      = $shop_info['shop_name'];
		$collect1[$k]['shopimg']      = $shop_info['shop_img'];
		$collect1[$k]['dizhi']        = $shop_info['address'];
//		print_r($collect);die;
		}
		
		$gg1 = Db::table('ycl_spec')->select();
		$gg = array_column($gg1,'name','id');
		$this->assign('gg',$gg);
		$this->assign('collect1',$collect1);
		return $this->fetch();
	}
	
	
	
}


