<?php
namespace app\index\controller;
use think\Controller;

use think\Db;
use think\Request;
class ExamineController extends Controller
{
//	显示验货页面
    public function inspection()
    {
    	$ddh = input('param.ddh');//订单id
    	$rowset = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_id',$ddh)->where('order_status',1)->where('sales_return',0)->select();
//  	print_r($rowset);die;
    	foreach($rowset as $k=> $v) {
    		$query = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
    		$goodsgg = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
    		$rowset[$k]['goods_id'] = $query['goodsname'];
    		$rowset[$k]['goodsgg'] = $goodsgg['name'];
    	}
    	$count = count($rowset);
//  	print_r($count);die;
    	$this->assign('count',$count);
    	$this->assign('rowset',$rowset);
		return $this->fetch();
    }
    
    public function xgexamine(Request $request) {
    	$ddid = $request->post('ddid');
    	$count = $request->post('coun');
		if(empty($ddid)){
			$this->error('请选择订单!');
		}
		foreach($ddid as $ddid_k => $ddid_v){
			$id[] = $ddid_v['ddid'];
		}
		$count_id = count($id);
		if($count_id > $count || $count_id < $count){
			$this->error('订单选择不完整!');
		}
//		print_r($count_id);die;
//		print_r($id);die;
    	$row = Db::table('ycl_order')->whereIn('id',$id)->setField('order_status',0);
    	if($row){
    		$this->success("验货成功!",'/index/purchase/pendingPayment');
    	}else{
    		$this->error("验货失败!");
    	}
//  	return $this->redirect(url());
    }
    
	public function payway(){  //选择支付方式
			$ddh   = input('param.ddh');//支付总金额
			//$order1   = input('param.order1');//支付总金额
			$money   = input('param.money');//支付金额
			//$orderid = input('param.orderid');//订单号
    		$this->assign('ddh',$ddh);
			$this->assign('money',$money);
			return $this->fetch();
	}
			public function verification(){ //改变 订单状态为 待验证
				$ddh   = input('param.ddh');
				$aa = explode(',',$ddh);
//				print_r($ddh);die;
				foreach($aa as $k => $v){
					
					Db::table('ycl_order')->where('order_id',$v)->update(['order_status' => 2]);
				}

				$this->redirect('/index/purchase/pendingVerification');
			}
/**
 * 根据商品ID 返回商品名称
 */
	public function goodsname($goodsid){
		
		return Db::name('goods')->where('id',$goodsid)->value('goodsname');
		
	}
	
/**
 * 根据商品规格 返回规格名称
 */
	public function goodsgg($goodsgg){
		
		return Db::name('spec')->where('id',$goodsgg)->value('name');
		
	}
/**
 * 根据商品ID 返回店铺
 */
	public function shopname($shopid){
		
		return Db::name('shop_info')->where('id',$shopid)->value('shop_name');
		
	}




    public  function paydetailsl(){ //支付
    	//$order1 = input('param.order1');//订单号
    	$orderid = input('param.ddh');//订单号
//  	print_r($orderid);die;
    	$aa = explode(',',$orderid);
    	$tui = 0;
    	$zong = 0;
//  	print_r($aa);die;
    	foreach($aa as $k=>$v){
    		$order = Db::table('ycl_order')->where('order_id',$v)->select();//商品信息
    		$goods[$k]['summoney'] = 0;   
    		foreach($order as $order_k =>$order_v){
    			$goods[$k]['shopname'] = $this->shopname($order_v['shopid']);
    			$goods[$k]['summoney'] += $order_v['total'];
    			$goods[$k][$order_k]['goodsname'] = $this->goodsname($order_v['goods_id']);
    			$goods[$k][$order_k]['sum'] = $order_v['good_num'];
     			$goods[$k][$order_k]['good_pirce'] = $order_v['good_pirce'];
     			$goods[$k][$order_k]['total'] = $order_v['total'];
     			$goods[$k][$order_k]['goodsgg'] = $this->goodsgg($order_v['goodsgg']);
     			$zong += $order_v['total'];
//   			$goods[$k]['ji'] += $order_v['total'];
   			
    		}	
    		$sales = Db::table('ycl_order')->where('order_id',$v)->where('sales_return',1)->select();//退货信息
    		foreach($sales as $k1 =>$v1){
    			
    			$sales[$k][$k1]['goods_id'] = $this->goodsname($v1['goods_id']);
    			$sales[$k][$k1]['goodsgg']  = $this->goodsgg($v1['goodsgg']);
    			$sales[$k][$k1]['shopid']  = $this->shopname($v1['shopid']);
    			$sales[$k][$k1]['good_num'] = $v1['good_num'];
    			$sales[$k][$k1]['good_pirce'] = $v1['good_pirce'];
    			$sales[$k][$k1]['total'] = $v1['total'];
    			$tui += $v1['total'];
    		}
//  		print_r($sales);die;
    		
    	}
//  	print_r($goods);die;
    	
		$surplus = $zong - $tui;
		$yu = $surplus * 0.2;
		$wei = $surplus * 0.8;
//		print_r($yu);die;
		$this->assign('wei',$wei);
		$this->assign('orderid',$orderid);
		$this->assign('yu',$yu);
		$this->assign('surplus',$surplus);
		$this->assign('zong',$zong);
		$this->assign('tui',$tui);
		$this->assign('sale',$sales);
		$this->assign('goods',$goods);
    	return $this->fetch();
    }
//  

    
    
    /**
     *   订单退货
     */
    public function refund(){ //全部退货
    	
//  	$refund = $_POST[''];
    	$refund = input('param.refund');
    	$purid = input('param.purid');
    	$ddh = input('param.ddh');
//  	print_r($ddh);die;
    	$data['sales_return'] = 1;
    	$data['recede'] = $refund;
    	$sales = Db::table('ycl_order')->where('order_id',$ddh)->update($data);
    	if($sales){
    		$mon = Db::table('ycl_order')->where('id',$purid)->find();
	    	$user = Db::table('ycl_user')->where('id',session('userid'))->find();
	    	//$money = $mon['total'] + $user['money'];
	    	//Db::table('ycl_user')->where('id',session('userid'))->update(['money' => $money]);
    		$this->success("退货成功!",'/index/examine/Inspection/ddh/'.$ddh);
    	}
    	
    	
    }
        public function none(){  //退货该商品
    	
//  	$none = $_POST['none'];
    	$none = input('param.none');
    	$purid = input('param.purid');
//  	print_r($purid);die;
    	$ddh = input('param.ddh');
    	$data['sales_return'] = 1;
    	$data['recede'] = $none;
    	$sales = Db::table('ycl_order')->where('id',$purid)->update($data);
    		if($sales){
    		$mon = Db::table('ycl_order')->where('id',$purid)->find();
	    	$user = Db::table('ycl_user')->where('id',session('userid'))->find();
	    	$money = $mon['total'] + $user['money'];
	    	Db::table('ycl_user')->where('id',session('userid'))->update(['money' => $money]);
    		$this->success("退货成功!",'/index/examine/Inspection/ddh/'.$ddh);
    	}
    	
    	
    }
        public function partial(){  //修改商品数量
    	$partial = input('param.partial');
//  	$partial = $_POST['partial'];
    	$purid = input('param.purid');
    	if (!empty($purid)){
    	    $this->success('修改','/index/examine/edit/id/'.$purid);
        }
    	//print_r($purid);die;
//    	$ddh = input('param.ddh');
//    	$data['sales_return'] = 1;
//    	$data['recede'] = $partial;
//    	$sales = Db::table('ycl_order')->where('id',$purid)->update($data);
//    		if($sales){
//    			$mon = Db::table('ycl_order')->where('id',$purid)->find();
//	    	$user = Db::table('ycl_user')->where('id',session('userid'))->find();
//	    	$money = $mon['total'] + $user['money'];
//	    	Db::table('ycl_user')->where('id',session('userid'))->update(['money' => $money]);
//    		$this->success("退货成功!",'/index/examine/Inspection/ddh/'.$ddh);
//    	}
    	
    	
    }


    public function edit(){
        $id = input('param.id');
//        print_r($id);die;
//        die;
        $row = Db::table('ycl_order')->where('id',$id)->find();
        $name = Db::table('ycl_goods')->where('id',$row['goods_id'])->value('goodsname');
        $this->assign('row',$row);
        $this->assign('name',$name);
        return $this->fetch();
    }

    public function updatesum(){
        $id = input('param.id');//订单id
        $gid = input('param.goods_id');//商品id
        $order_id = input('param.ddh');//订单号
        $sum = input('param.sum');//订单号
        $pri = input('param.pri');//商品单价
        $dan = $sum * $pri;
        $data['good_num'] = $sum;
        $data['total']    = $dan;
//        $data['money']    = $dan;
         Db::table('ycl_order')->where('id',$id)->update($data);
//        print_r($data);die;
        $total = Db::table('ycl_order')->where('order_id',$order_id)->sum('total');
        Db::table('ycl_order')->where('order_id',$order_id)->update(['money' =>$total]);
        $this->redirect('/index/examine/Inspection/ddh/'.$order_id);
    }
}
