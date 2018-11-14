<?php
namespace app\shop\controller;
use think\Controller;
include EXTEND_PATH.'/qrcode/qrcode.php';
//print_r(EXTEND_PATH);die;
use qrcode\QRcode;
use think\Db;
use think\Request;
class OrderController extends Controller
{
//	店铺订单数据页面
    public function index()
    {
    	if(session('userid') == null) {
    		return $this->redirect(url('/index/login/login'));
    	}
    	
		    	$year  = date("Y");
				$month = date("m");
				$day = date("d");
				$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		    	$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
		
		    	$row = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status != 9')->group('order_id')->select();
//		    	$zcon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status != 9')->group('order_id')->count();//总数量
		    	$mon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->group('order_id')->select();
		    	$count = 0;
		    	$sum = 0;
		    	$goodssum = 0;
		    	foreach($mon as $k1 => $v1){
		    		if ($v1['complate_time'] >= $start) {
		    				$sum += $v1['total']; //今日收入
		    				$count = count($mon); //今日订单
		    				$goodssum += $v1['good_num'];
		    			}
		    		
		    	}
		    		
		    		
		    		
		//  	print_r($row);die;
		    	foreach ($row as $k=>$v) {
		    		$temp = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
		//  		print_r($temp);die;
		    		$row[$k]['cq_id'] = $temp['username'];
		    		
		    	}
		//  	print_r($row);die;
				$this->assign('sum',$sum);
//		    	$this->assign('zcon',$zcon);
		    	$this->assign('count',$count);
		    	$this->assign('goodssum',$goodssum);
		    	$this->assign('shop',$shop);
		    	$this->assign('row',$row);
//		    	print_r($row);die;
		    	 	
				return $this->fetch();
    }


	//订单待接单
	public function orderDetailDjd() {
		$orderid = input('param.orderid');//订单号
		$row = Db::table('ycl_order')->where('order_id',$orderid)->select();
//		print_r($row);
		foreach($row as $k=>$v){
			$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
			$user = Db::table('ycl_user')->where('id',$cq['uid'])->find();
			$god = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
			$gg = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$row[$k]['goods_id'] = $god['goodsname'];
			$row[$k]['goodsgg']  = $gg['name'];
		}
		$row2 = Db::table('ycl_order')->where('order_id',$orderid)->find();
		$num = Db::table('ycl_order')->where('order_id',$orderid)->sum('total');
		$cq['uid'] = $user['username'];
		$this->assign('num',$num); 
		$this->assign('row2',$row2); 
		$this->assign('cq',$cq); 
		$this->assign('user',$user); 
		$this->assign('row',$row); 
		return $this-> fetch();
	}
	
	
	//订单接单拒单
	public function orderjd() {
		$orderid = input('param.id');//订单号
		$jd = input('param.jd');//0 是巨单  1是接单
		$userid = input('param.userid');//买方userid
		$shopid = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();//店铺id
//		print_r($shopid);die;
		
		if($jd == 0) {
			Db::table('ycl_order')->where('order_id',$orderid)->setField('shop_status',9);
			Db::table('ycl_purchase')->where('uid',$userid)->where('shop_id',$shopid['id'])->where('status',1)->update(['status' => 4]);
			return $this->redirect(url('/shop/order/index'));
		} else {
			$data['shop_status'] = 2;
			$data['order_status']= 1;
		    Db::table('ycl_order')->where('order_id',$orderid)->update($data);
			Db::table('ycl_purchase')->where('uid',$userid)->where('shop_id',$shopid['id'])->where('status',1)->update(['status' => 2]);
			return $this->redirect('/shop/order/orderDetailBhz/orderid/' .$orderid);
		}
		
	}
	
	//历史订单
	public function historyorder() {
		if(session('userid') == null) {
		return $this->redirect(url('/index/login/login'));
		}
		
		$cx = input('param.cx');
		$time = input('param.date');//按条件查询
		$data = [];
		$shous = input('post.shous');
			if($time){
			 $aa = strtotime($time);
//			 print_r($aa);
			$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$order = Db::table('ycl_order')->where('shopid',$shop['id'])->where('delivery_time',$aa)->where('shop_status',6)->select();
			if(!empty($order)){
					foreach($order as $k=> $v) {			
					$rider = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
					$shop = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
					$data[$k] = array(
					    'true_name' => $rider['true_name'],
						'phone'  =>  $rider['phone'],
						'delivery_time' => $v['delivery_time'],
						'cqname'  => $shop['cqname'],
						'phone'  =>	 $shop['phone'],
						'address' => $shop['address'],
						'remark' => $v['remark'],
						'order_id' => $v['order_id'],
						'total'  => $v['total'],
						'refund' => $v['refund'],
						'total' => $v['total']
						);
				}
			}
		}
			
		if ($shous !== null) {
			$shop  =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$order  = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->where('order_id',$shous)->select();//搜索订单号
			if($order){
				foreach($order as $k=> $v) {			
					$rider = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
					$shop = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
					$data[$k] = array(
					    'true_name' => $rider['true_name'],
						'phone'  =>  $rider['phone'],
						'delivery_time' => $v['delivery_time'],
						'cqname'  => $shop['cqname'],
						'phone'  =>	 $shop['phone'],
						'address' => $shop['address'],
						'remark' => $v['remark'],
						'order_id' => $v['order_id'],
						'total'  => $v['total'],
						'refund' => $v['refund'],
						'total' => $v['total']
						);
					
				}
			}
//				print_r($order1);die;
		  }else{
		if ($cx == null) {
		    $shop  =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$order = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->select();
			
				foreach($order as $k=> $v) {			
					$rider = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
					$shop = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
					$data[$k] = array(
					    'true_name' => $rider['true_name'],
						'phone'  =>  $rider['phone'],
						'delivery_time' => $v['delivery_time'],
						'cqname'  => $shop['cqname'],
						'phone'  =>	 $shop['phone'],
						'address' => $shop['address'],
						'remark' => $v['remark'],
						'order_id' => $v['order_id'],
						'total'  => $v['total'],
						'refund' => $v['refund'],
						'total' => $v['total']
						);
				}
			}	
		}
		if ($cx == 1) {
			$timestamp = time();  
			$firstday = strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp))); //本周开始时间戳
//			$lastday = strtotime(date('Y-m-d', strtotime("this week Sunday", $timestamp))) + 24 * 3600 - 1;
			$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$order = Db::table('ycl_order')->where('shopid',$shop['id'])->where('delivery_time','>=',$firstday)->where('shop_status',6)->select();
			if(!empty($order)){
					foreach($order as $k=> $v) {			
					$rider = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
					$shop = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
					$data[$k] = array(
					    'true_name' => $rider['true_name'],
						'phone'  =>  $rider['phone'],
						'delivery_time' => $v['delivery_time'],
						'cqname'  => $shop['cqname'],
						'phone'  =>	 $shop['phone'],
						'address' => $shop['address'],
						'remark' => $v['remark'],
						'order_id' => $v['order_id'],
						'total'  => $v['total'],
						'refund' => $v['refund'],
						'total' => $v['total']
						);
				}
			}
			
		
		}
		
		if ($cx == 2) {
			$yc   = mktime(0,0,0,date('m'),1,date('Y')); //本月开始时间戳
			//$yw   = mktime(23,59,59,date('m'),date('t'),date('Y'));//本月结束时间戳
			$shop = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$order= Db::table('ycl_order')->where('shopid',$shop['id'])->where('delivery_time','>=',$yc)->where('shop_status',6)->select();
			if(!empty($order)){
				foreach($order as $k=> $v) {			
					$rider = Db::table('ycl_user')->where('id',$v['rider_id'])->find();
					$shop = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
					$data[$k] = array(
					    'true_name' => $rider['true_name'],
						'phone'  =>  $rider['phone'],
						'delivery_time' => $v['delivery_time'],
						'cqname'  => $shop['cqname'],
						'phone'  =>	 $shop['phone'],
						'address' => $shop['address'],
						'remark' => $v['remark'],
						'order_id' => $v['order_id'],
						'total'  => $v['total'],
						'refund' => $v['refund'],
						'total' => $v['total']
						);
				}
			}
		}
	
//	print_r($row);die;
		$this->assign('order',$data);
	
		return $this->fetch();
}
	
	//订单备货中
	public function orderDetailBhz() {
		$orderid = input('param.orderid');
		$row = Db::table('ycl_order')->where('order_id',$orderid)->where('shop_status',2)->select();
//					print_r($row);die;
		foreach($row as $k=>$v){
			$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
			$user = Db::table('ycl_user')->where('id',$cq['uid'])->find();
			$god = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
			$gg = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$row[$k]['goods_id'] = $god['goodsname'];
			$row[$k]['goodsgg']  = $gg['name'];
		}
		$row2 = Db::table('ycl_order')->where('order_id',$orderid)->find();
		$num = Db::table('ycl_order')->where('order_id',$orderid)->sum('total');
		$cq['uid'] = $user['username'];
		$this->assign('num',$num); 
		$this->assign('row2',$row2); 
		$this->assign('cq',$cq); 
		$this->assign('row',$row); 
		return $this-> fetch();
	}
	
	public function yps(){ //配送中
		$orderid = input('param.orderid');
		Db::table('ycl_order')->where('order_id',$orderid)->setField('shop_status',5);
		return $this->redirect('/shop/order/index');
	}
	
     //打印送货单
	public function orderDetailWc() {
		$orderid = input('param.orderid');
		$pan = Db::table('ycl_order')->where('order_id',$orderid)->find();
		if($pan['shop_status'] == 5){
		return	$this->redirect('/shop/order/psz');
		}
		
		       	header('content-type:image/png');  //设置gif Image
				ob_clean();
				//$url = urldecode("http://www.baidu.com");//连接后跳转地址
				$url = urldecode($orderid);//连接后跳转地址
				$qrcode = new QRcode();
				$png = QRcode::png($url,false,"H",4,1);
				$imageString = base64_encode(ob_get_contents());
				ob_end_clean();
				$png = "data:image/jpg;base64,".$imageString;
				 
//		print_r($set);die;
        if ($pan['shop_status'] !== 7){
		$set = Db::table('ycl_order')->where('order_id',$orderid)->setField('shop_status',4);
            $row = Db::table('ycl_order')->where('order_id',$orderid)->where('shop_status',4)->select();

        }else{
            $set = Db::table('ycl_order')->where('order_id',$orderid)->setField('shop_status',7);
            $row = Db::table('ycl_order')->where('order_id',$orderid)->where('shop_status',7)->select();
        }
		foreach($row as $k=>$v){
			$cq 	= Db::table('ycl_address')->where('uid',$v['cq_id'])->where('is_mr',1)->find();
			$user = Db::table('ycl_user')->where('id',$cq['uid'])->find();
			$god = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
			$gg = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$row[$k]['goods_id'] = $god['goodsname'];
			$row[$k]['goodsgg']  = $gg['name'];
			$cq['uid'] = $user['username'];
		}
		
		$row2 = Db::table('ycl_order')->where('order_id',$orderid)->find();
		$num = Db::table('ycl_order')->where('order_id',$orderid)->sum('total');
		$this->assign('num',$num); 
		$this->assign('row2',$row2); 

		$this->assign("png",$png);
		$this->assign('cq',$cq); 
		$this->assign('row',$row);  
		return $this-> fetch();
	}
	
	//代接单
	    public function djd()
    {
    	if(session('userid') == null) {
    		return $this->redirect(url('/index/login/login'));
    	}
    	
    	$year  = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
//		print_r($start);die;
		//查询店铺
    	$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	//通过店铺查询订单
    	$row  = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',0)->group('order_id')->select();
		//今日订单总数
    	$count    = 0;
    	//今日收入
    	$sum      = 0;
    	$goodssum = 0;
    	$mon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->group('order_id')->select();
    	foreach($mon as $k1 => $v1){
    		
    		if ($v1['complate_time'] >= $start) {
    			$sum += $v1['total']; //今日收入
    			$count = count($mon); //今日订单
    			$goodssum += $v1['good_num'];
//  			print_r($sum);die;
    		}
    		
    	}
    		
    	foreach ($row as $k=>$v) {
    		$temp = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
//  		print_r($temp);die;
    		$row[$k]['cq_id'] = $temp['username'];
    	}
    	
    	$this->assign('sum',$sum);
    	$this->assign('count',$count);
    	$this->assign('goodssum',$goodssum);
    	$this->assign('shop',$shop);
    	$this->assign('row',$row);
    	  	
		return $this->fetch();
    }
	    public function dch()
    {
    	if(session('userid') == null) {
    		return $this->redirect(url('/index/login/login'));
    	} else {
    	$year  = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
//		print_r($start);die;
		
    	$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
//  	$shop_status['shop_status'] = 4;
//  	$shop_status['shop_status'] = 7;
    	$row = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',4)->group('order_id')->select();
    	if(!$row){
    		$row = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',7)->group('order_id')->select();
    	}
//  	print_r($row);die;
    	$count = 0;
    	$sum = 0;
    	$goodssum = 0;
    	   	$mon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->group('order_id')->select();
    	foreach($mon as $k1 => $v1){
    		if ($v1['complate_time'] >= $start) {
    			$sum += $v1['total']; //今日收入
    			$count = count($mon); //今日订单
    			$goodssum += $v1['good_num'];
//  			print_r($sum);die;
    		}
    		
    	}
//  	print_r($row);
    	foreach ($row as $k=>$v) {
    		$temp = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
//  		print_r($temp);die;
    		$row[$k]['cq_id'] = $temp['username'];
    	}
    	$this->assign('sum',$sum);
    	$this->assign('count',$count);
    	$this->assign('goodssum',$goodssum);
    	$this->assign('shop',$shop);
    	$this->assign('row',$row);
    	}   	
		return $this->fetch();
    }
      public function psz()
    {
    	if(session('userid') == null) {
    		return $this->redirect(url('/index/login/login'));
    	} else {
    	$year  = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳

    	$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	$row = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',5)->group('order_id')->select();
    	$count = 0;
    	$sum = 0;
    	$goodssum = 0;
    	   	$mon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->group('order_id')->select();
    		foreach($mon as $k1 => $v1){
    		
    		if ($v1['complate_time'] >= $start) {
    			$sum += $v1['total']; //今日收入
    			$count = count($mon); //今日订单
    			$goodssum += $v1['good_num'];
//  			print_r($sum);die;
    		}
    		
    	}
//  	print_r($row);
    	foreach ($row as $k=>$v) {
    		$temp = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
//  		print_r($temp);die;
    		$row[$k]['cq_id'] = $temp['username'];
    	}
    	$this->assign('sum',$sum);
    	$this->assign('count',$count);
    	$this->assign('goodssum',$goodssum);
    	$this->assign('shop',$shop);
    	$this->assign('row',$row);
    	}   	
		return $this->fetch();
    }
    
    
     public function today()//今日完成
    {
    	if(session('userid') == null) {
    		return $this->redirect(url('/index/login/login'));
    	} else {
    	$year  = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳

    	$shop =  Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	$row = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->where('complate_time','>=',$start)->group('order_id')->select();
    	$count = 0;
    	$sum = 0;
    	$goodssum = 0;
    	   	$mon = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->group('order_id')->select();
    	foreach($mon as $k1 => $v1){
    		
    		if ($v1['complate_time'] >= $start) {
    			$sum += $v1['total']; //今日收入
    			$count = count($mon); //今日订单
    			$goodssum += $v1['good_num'];
//  			print_r($sum);die;
    		}
    		
    	}
//  	print_r($row);
    	foreach ($row as $k=>$v) {
    		$temp = Db::table('ycl_user')->where('id',$v['cq_id'])->find();
//  		print_r($temp);die;
    		$row[$k]['cq_id'] = $temp['username'];
    	}
    	$this->assign('sum',$sum);
    	$this->assign('count',$count);
    	$this->assign('goodssum',$goodssum);
    	$this->assign('shop',$shop);
    	$this->assign('row',$row);
    	}   	
		return $this->fetch();
    }
    
    
    public  function to(){ //配送中详情, 今日完成详情
    	$id = input('param.orderid');//订单号
			
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
//                print_r($cq);die;
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
		
}
