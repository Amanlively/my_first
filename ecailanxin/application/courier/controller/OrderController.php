<?php
namespace app\courier\Controller;
use think\Controller;
use think\Request;
use think\Db;


class OrderController extends Controller{
	
	public function missionhisorder(){
		$shou = input('param.shou');//搜索框
		$cx = input('param.cx');//查询日期
		$time = input('param.date');//按条件查询
//		print_r($time);
		if($time){
			 $aa = strtotime($time);
				$row = Db::table('ycl_order')->where('rider_id',session('userid'))->where('order_status',8)->where('delivery_time',$aa)->group('order_id')->select();
//				print_r($aa);die;
		}
				$timestamp = time(); 
				$firstday = strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp))); //本周开始时间戳
				$yc   = mktime(0,0,0,date('m'),1,date('Y')); //本月开始时间戳
			if($shou !== null){
			   $row = Db::table('ycl_order')->where('rider_id',session('userid'))->where('order_id',$shou)->where('order_status',8)->group('order_id')->select();//搜索订单号+已完成配送订单
		}else{
			   $row = Db::table('ycl_order')->where('rider_id',session('userid'))->where('order_status',8)->group('order_id')->select();//已完成配送订单
		   }
		   
		   if($cx == 1){
			 $row = Db::table('ycl_order')->where('rider_id',session('userid'))->where('order_status',8)->where('delivery_time','>=',$firstday)->group('order_id')->select();
		   }
		   
		   if($cx == 2){
		   	$row = Db::table('ycl_order')->where('rider_id',session('userid'))->where('order_status',8)->where('delivery_time','>=',$yc)->group('order_id')->select();
		   }
		   
			$this->assign('row',$row);
			return $this->fetch();
	}
	
	
	//订单处理  代取货
	public function orderprocessing() {
		if(session('userid') == null) {
			return redirect(url('/index/login/login'));
		} else {
			$order = Db::table('ycl_order')->where('rider_id',session('userid'))->where('shop_status',7)->where('take',0)->group('order_id')->select();
//			print_r($order1);die;
			$jy = array();
	    	for($i = 0; $i<count($order);$i++){
				$shop = Db::table('ycl_shop_info')->where('id',$order[$i]['shopid'])->find();
				$cq 	= Db::table('ycl_address')->where('uid',$order[$i]['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
//				print_r($cq);die;
				$jy[$i]['delivery_time']  = $order[$i]['delivery_time'];
				$jy[$i]['order_status']   = $order[$i]['order_status'];
				$jy[$i]['freight']        = $order[$i]['freight'];
				$jy[$i]['shop_name']      = $shop['shop_name'];
				$jy[$i]['address']        = $shop['address'];
				$jy[$i]['phone']          = $shop['manager_phone'];
				$jy[$i]['cqname']         = $user['username'];
				$jy[$i]['cqaddress']      = $cq['details'];
				$jy[$i]['cqphone']        = $cq['phone'];
				$jy[$i]['id']             = $order[$i]['id'];
				$jy[$i]['order_id']       = $order[$i]['order_id'];
				$jy[$i]['shop_status']       = $order[$i]['shop_status'];
				$jy[$i]['predict_time']   = $order[$i]['predict_time'];
			}
//			print_r($jy);die;
//		$this->assign('order1',$order1);
		$this->assign('jy',$jy);
		}
		return $this->fetch();
	}
	 
	 //订单处理  配送中
	public function orderpsz() {
		if(session('userid') == null) {
			return redirect(url('/index/login/login'));
		} else {
			$order = Db::table('ycl_order')->where('rider_id',session('userid'))->where('shop_status',5)->where('take',0)->group('order_id')->select();
//			print_r($order1);die;
			$jy = array();
	    	for($i = 0; $i<count($order);$i++){
				$shop = Db::table('ycl_shop_info')->where('id',$order[$i]['shopid'])->find();
				$cq 	= Db::table('ycl_address')->where('uid',$order[$i]['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
//				print_r($cq);die;
				$jy[$i]['delivery_time']  = $order[$i]['delivery_time'];
				$jy[$i]['order_status']   = $order[$i]['order_status'];
				$jy[$i]['freight']        = $order[$i]['freight'];
				$jy[$i]['shop_name']      = $shop['shop_name'];
				$jy[$i]['address']        = $shop['address'];
				$jy[$i]['phone']          = $shop['manager_phone'];
				$jy[$i]['cqname']         = $user['username'];
				$jy[$i]['cqaddress']      = $cq['details'];
				$jy[$i]['cqphone']        = $cq['phone'];
				$jy[$i]['id']             = $order[$i]['id'];
				$jy[$i]['order_id']       = $order[$i]['order_id'];
				$jy[$i]['shop_status']       = $order[$i]['shop_status'];
				$jy[$i]['predict_time']   = $order[$i]['predict_time'];
			}
//			print_r($jy);die;
//		$this->assign('order1',$order1);
		$this->assign('jy',$jy);
		}
		return $this->fetch();
	}
	 
	//确认收货
	public function distribution1() {
		if (session('userid') == null) {
			return redirect(url('/index/login/login'));
		} else {
			$id = input('param.ddh');//订单号
//			print_r($id);
			$order = Db::table('ycl_order')->where('order_id',$id)->select();
			foreach($order as $k=>$v){
				$shop   = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
				$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
				$goods  = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
				$order[$k]['goods_id']  = $goods['goodsname'];
				$order[$k]['goodsgg']   = $goodsgg['name'];				
				$cq['uid'] = $user['username'];
			}
			$order1 = Db::table('ycl_order')->where('order_id',$id)->find();
			$num = Db::table('ycl_order')->where('order_id',$id)->sum('total');
//			print_r($cq);
//			print_r($cq);die;
			$this->assign('num',$num);
			$this->assign('order1',$order1);
			$this->assign('order',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		}
		return $this->fetch();
	}
	//扫码验货页面
	public function distribution() {
		if (session('userid') == null) {
			return redirect(url('/index/login/login'));
		} else {
			$id = input('param.id');//订单号
//			print_r($id);
			$order = Db::table('ycl_order')->where('order_id',$id)->select();
//			print_r($order1);
			foreach($order as $k=>$v){
				$shop   = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
//				print_r($shop);die;
				$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
				$goods  = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
				$order[$k]['goods_id'] = $goods['goodsname'];
				$order[$k]['goodsgg']   = $goodsgg['name'];				
			}
			$order1 = Db::table('ycl_order')->where('order_id',$id)->find();
			$num = Db::table('ycl_order')->where('order_id',$id)->sum('total');
			$cq['uid'] = $user['username'];
			$this->assign('num',$num);
			$this->assign('order1',$order1);
			$this->assign('order',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		}
		return $this->fetch();
	}
	//完成配货
	public function distribution2() {
		if (session('userid') == null) {
			return redirect(url('/index/login/login'));
		}
			$id = input('param.id');//订单号	
			$rider = Db::table('ycl_order')->where('order_id',$id)->find();//判断配送员字段是否为空
			if($rider['rider_id'] != session('userid')){
				return "<script>
					alert('您不是该接单人!');
				</script>";	
				//$this->redirect(url('/index/order/distribution/id/'.$id));
//				exit;
			}
			
			$order = Db::table('ycl_order')->where('order_id',$id)->select();
//			print_r($order1);die;
			foreach($order as $k=>$v){
				$shop   = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
//				print_r($shop);die;
				$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
				$goods  = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
				$rider_id = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
				$order[$k]['goods_id']  = $goods['goodsname'];
				$order[$k]['goodsgg']   = $goodsgg['name'];				
			}
			$sales_return = Db::table('ycl_order')->where('order_id',$id)->where('sales_return',1)->select();
			foreach($sales_return as $k1=>$v1){
				$goods  = Db::table('ycl_goods')->where('id',$v1['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v1['goodsgg'])->find();
				$sales_return[$k1]['goods_id'] =  $goods['goodsname'];
				$order[$k1]['goodsgg']   = $goodsgg['name'];	
			}
			$num = Db::table('ycl_order')->where('order_id',$id)->sum('total');
			$order1 = Db::table('ycl_order')->where('order_id',$id)->find();
			$cq['uid'] = $user['username'];
			$this->assign('num',$num);
			$this->assign('order1',$order1);

			$this->assign('sales_return',$sales_return);
			$this->assign('rider_id',$rider_id);
			$this->assign('order',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		
		return $this->fetch();
	}
	
	//验货完成
	public function distribution3() {
		if (session('userid') == null) {
			return redirect(url('/index/login/login'));
		} else {
			$id = input('param.id');//订单号
			
			$data['take'] = 1;
			$data['order_status']  = 8;
			$data['shop_status']   = 6;
			$data['delivery_time'] = time();
			
			$set = Db::table('ycl_order')->where('order_id',$id)->update($data);
			
			if ($set) {
				$order = Db::table('ycl_order')->where('order_id',$id)->select();
			foreach($order as $k=>$v){
				$shop   = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
//				print_r($shop);die;
				$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
				$goods  = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
				$rider_id = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
				$order[$k]['goods_id'] = $goods['goodsname'];
				$order[$k]['goodsgg']   = $goodsgg['name'];				
			}
			$sales_return = Db::table('ycl_order')->where('order_id',$id)->where('sales_return',1)->select();
			foreach($sales_return as $k1=>$v1){
				$goods  = Db::table('ycl_goods')->where('id',$v1['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v1['goodsgg'])->find();
				$sales_return[$k1]['goods_id'] =  $goods['goodsname'];
				$order[$k1]['goodsgg']   = $goodsgg['name'];	
			}
			$num = Db::table('ycl_order')->where('order_id',$id)->sum('total');
			$order1 = Db::table('ycl_order')->where('order_id',$id)->find();		
			$cq['uid'] = $user['username'];
			}
			$this->assign('num',$num);
			$this->assign('order1',$order1);
			
			$this->assign('sales_return',$sales_return);
			$this->assign('rider_id',$rider_id);
			$this->assign('order',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		}
		return $this->fetch();
	}
	
	public function historyorder(){ //历史订单详情
		$id = input('param.id');//订单号
				$order = Db::table('ycl_order')->where('order_id',$id)->where('take',1)->where('order_status',8)->select();
//							print_r($order1);
			foreach($order as $k=>$v){
				$shop   = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
//				print_r($shop);die;
				$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
//				print_r($cq);die;
				$user 	= Db::table('ycl_user')->where('id',$cq['uid'])->find();
				$goods  = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
				$rider_id = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
				$order[$k]['goods_id'] = $goods['goodsname'];
				$order[$k]['goodsgg']   = $goodsgg['name'];				
			}
			$sales_return = Db::table('ycl_order')->where('order_id',$id)->where('sales_return',1)->select();
			foreach($sales_return as $k1=>$v1){
				$goods  = Db::table('ycl_goods')->where('id',$v1['goods_id'])->find();
				$goodsgg= Db::table('ycl_spec')->where('id',$v1['goodsgg'])->find();
				$sales_return[$k1]['goods_id']  =  $goods['goodsname'];
				$sales_return[$k1]['goodsgg']   = $goodsgg['name'];
			}
			$num = Db::table('ycl_order')->where('order_id',$id)->sum('total');
			$order1 = Db::table('ycl_order')->where('order_id',$id)->find();		
			$cq['uid'] = $user['username'];
			$this->assign('num',$num);
			$this->assign('order1',$order1);
			
			$this->assign('sales_return',$sales_return);
			$this->assign('rider_id',$rider_id);
			$this->assign('order',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		return $this->fetch();
	}
	
	public function scan(){ //显示扫一扫
		
		return $this->fetch();
		
	}
	
	
	
}


