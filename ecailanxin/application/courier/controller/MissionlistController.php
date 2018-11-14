<?php

namespace app\courier\Controller;
use think\Controller;
use think\Request;
use think\Db;


class MissionlistController extends Controller{
	
	public function  missionlist(){
//		print_r(session('city'));die;
		$city = Db::table('ycl_shop_info')->where('city',session('city'))->select();
		$new_arr = array();
		foreach($city as $k=>$v){
			$row[] = Db::table('ycl_order')->where('shop_status',4)->where('shopid',$v['id'])->group('order_id')->select();
			foreach($row as $row_k=>$row_v){
				foreach($row_v as $rowk=>$rowv){
						  if(!in_array($rowv,$new_arr)){
				      
				        $new_arr[]=$rowv;
				   }
				}
			}
		}	
		$openstatus=Db::table('ycl_user')->where('id',session('userid'))->find();
//		print_r($new_arr);die;
		$this->assign('openstatus',$openstatus);
		$this->assign('row',$new_arr);
		return $this->fetch();
	}
		public function  qishoujiedan(){// 改变订单状态为骑手已接单 取货中
		$id = input('param.id');//订单号
		$qi =  Db::table('ycl_order')->where('order_id',$id)->find();
		if($qi['rider_id'] != null){
			$this->error('已被接单!');
		}
		$data['shop_status']  = 7;//骑手取货中
		$data['rider_id']     = session('userid');
		$data['rec_time']     = time();//骑手接单时间
	   Db::table('ycl_order')->where('order_id',$id)->update($data);
	   return redirect('/courier/order/orderprocessing');
	}
	
	public function  status(){// 改变订单状态为配送中
		$id = input('post.path');//订单号
		Db::table('ycl_temp')->where('id',1)->setField('temp',$id);
		$rider_id =  Db::table('ycl_order')->where('order_id',$id)->find();
	 	//print_r(cookie('userid'));die;
		if($rider_id['rider_id'] != cookie('userid')){
			return "<script>
					alert('您不是接单人!');
					</script>";
		}
//		print_r($id);die;
		$data['waybill']      = date('Ymd').rand();//运单号
		$data['shop_status']  = 5;//商家改为配送中
		$data['complate_time']= time();//商家订单完成时间
		//$data['order_status'] = 3;//表示骑手已接单
		$data['rider_id']     = session('userid');
		$data['take_time']     = time();//骑手接单时间
	   Db::table('ycl_order')->where('order_id',$id)->update($data);
	   $data['status']=1;
	   $msg=json_encode($data);
	   echo $msg;
	   return;
	  // return $this->redirect('/courier/order/orderprocessing');
	}

	public function aaa(){
		$open   = input('param.open');
		$status = input('param.status');
//		print_r($open);die; 
			if($status == 1) {
				if ($open == 1) {
					$row = Db::table('ycl_user')->where('id',session('userid'))->setField('is_kg',1);
					
				} else {
					$row = Db::table('ycl_user')->where('id',session('userid'))->setField('is_kg',0);
					
				}
			}
		return;
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
				$order[$k]['goods_id'] = $goods['goodsname'];
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
	
}
