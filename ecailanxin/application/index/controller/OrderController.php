<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;

class OrderController extends Controller{
//	public function historyorder(){ //历史订单
//		$count = 0;
//		$order = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->group('order_id')->select();
//		foreach($order as $k=>$v){
//			$user = Db::table('ycl_user')->where('id',$v['buy_id'])->find();
//			$order[$k]['buy_id'] = $user['username'];
//			$order[$k]['shu'] = Db::table('ycl_order')->where('order_id',$v['order_id'])->sum('good_num');
//		}
//		$userimg = Db::table('ycl_user')->where('id',session('userid'))->find();
////		print_r($userimg);die;
//		$this->assign('userimg',$userimg);
////		$this->assign('count',$count);
//		$this->assign('order',$order);
//		return $this->fetch();
//	}
	
		public function distribution3() { //订单详情
			$id = input('param.order_id');//订单号
				$order = Db::table('ycl_order')->where('order_id',$id)->select();
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
		public function historyorder(){
		$shou = input('param.shou');//搜索框
		$cx = input('param.cx');//查询日期
		$time = input('param.date');//按条件查询

				$timestamp = time(); 
				$firstday = strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp))); //本周开始时间戳
				$yc   = mktime(0,0,0,date('m'),1,date('Y')); //本月开始时间戳
			if($shou !== null){
			   $row = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_id',$shou)->where('order_status',8)->group('order_id')->select();//搜索订单号+已完成配送订单
		}else{
			   $row = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->group('order_id')->select();//已完成配送订单
		   }
		   
		   if($cx == 1){
			 $row = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('delivery_time','>=',$firstday)->group('order_id')->select();
		   }
		   
		   if($cx == 2){
		   	$row = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('delivery_time','>=',$yc)->group('order_id')->select();
		   }

            if($time !== null){ //根据日期查询
                //$aa = strtotime($time);
                $row = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->whereBetweenTime('delivery_time',$time)->group('order_id')->select();
                //print_r($row);die;
            }
			$this->assign('row',$row);
			return $this->fetch();
	}
}
