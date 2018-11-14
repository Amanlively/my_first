<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
include EXTEND_PATH.'/qrcode/qrcode.php';
use qrcode\QRcode;
use think\Request;
header("Content-Type: text/html; charset=UTF-8");
class PurchaseController extends Controller
{
//	工作群
    public function group()
    {
    	if(session('userid') == null || session('phone') == null){
			return $this->redirect('/index/login/login');
		}
        $fromid = input('fromid');
        $toid = input('toid');
        $userid = session('userid');
        //门店ID   即为分组ID
        $group = Db::table('ycl_user')->where('id',$userid)->find();
        //头部 工作群所在人员展示
        $top = Db::table('ycl_role')->where('group_id',$group['work_id'])->order('addtime','asc')->select();
//      print_r($top);die;
        $top_exhibition = [];
        foreach ($top as $top_k => $top_v){
            $top_exhibition[$top_k] = array(
                'content' => $top_v['content'],
                'js_name' => $top_v['js_name'],
                'image'   => Db::table('ycl_user')->where('id',$top_v['uid'])->value('image'),
            );
        }
//		print_r($top_exhibition);die;

        //聊天信息展示
        $rss = Db::table('ycl_chat_group')->where('group',$group['work_id'])->order('addtime','asc')->select();
        $rs = [];
        foreach ($rss as $rss_k => $rss_v){
            $name = Db::table('ycl_role')->where('group_id',$group['work_id'])->where('uid',$rss_v['userid'])->find();
            $purchase = Db::table('ycl_purchase')->where('id',$rss_v['purchase'])->find();
            $rs[$rss_k] = array(
                'content' => $rss_v['content'],
                'js_name' => $name['js_name'],
                'nickname' => $name['content'],
                'image'   => Db::table('ycl_user')->where('id',$rss_v['userid'])->value('image'),
                'status'  => $rss_v['status'],
                'username' => $group['username'],
                'order1' => $purchase['cgdh'],
                'orderstatus' => $purchase['status'],
                'ordertime' => $purchase['add_time'],
                'userid'   => $rss_v['userid'],
            );
        }

        $this->assign('rs',$rs);
        $this->assign('top',$top_exhibition);
        $this->assign('group',$group['work_id']);
        $this->assign('fromid',$fromid);
        $this->assign('toid',$toid);

		return $this->fetch();
    }
    
	//骑手完成配货扫描二维码发送的方法
	public function wstatus() {
		$ddh=input('post.path');
		$data['status']=1;
		$data['info']=$ddh;
		$msg=json_encode($data);
		echo $msg;
		return;
	}
	public function scan(){ //显示扫一扫
		
		return $this->fetch();
		
	}
	
//  采购单
   //  采购单
    public function vegetablebasket() {
    	if(session('userid') == null || session('phone') == null){
    		return $this->redirect(url('/index/login/login'));
    	}
    	
    	
    		$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));//今日开始时间戳
	    	$order = Db::table('ycl_purchase')->where('uid',session('userid'))->where('pron',1)->find();
	    	
	    	  //代接单
	    		$daipron = Db::table('ycl_purchase')->where('cgdh',$order['cgdh'])->where('status',1)->count();
			   //已接单
				$yipron = Db::table('ycl_purchase')->where('cgdh',$order['cgdh'])->group('shop_id')->where('status',2)->count();
			
				$query = Db::table('ycl_user')->where('id',session('userid'))->find();
//		    	$top   = Db::table('ycl_role')->where('group_id',$query['work_id'])->select();
				$wo    = 0;
				$wo    = Db::table('ycl_purchase')->where('uid',session('userid'))->where('pron',1)->where('status',0)->count();
//	    	foreach($top as $k => $v){
	    		$rowset = Db::table('ycl_purchase')->where('uid',session('userid'))->where('pron',0)->order('id desc')->group('cgdh')->select();
//		    		print_r($rowset);die;
					foreach($rowset as $rowset_k => $rowset_v){
								if($rowset) {
					    		//未接单数量
					    		$rowset[$rowset_k]['wjd'] = Db::table('ycl_purchase')->where('cgdh',$rowset_v['cgdh'])->where('status',1)->count();
					    		//已接单
					    		$rowset[$rowset_k]['yjd'] = Db::table('ycl_purchase')->where('cgdh',$rowset_v['cgdh'])->where('status',2)->count();
								//代下单
								$rowset[$rowset_k]['dai'] = Db::table('ycl_purchase')->where('cgdh',$rowset_v['cgdh'])->where('status',0)->count();
								
								//巨单
								$rowset[$rowset_k]['ju'] = Db::table('ycl_purchase')->where('cgdh',$rowset_v['cgdh'])->where('status',4)->count();
			//					我淘的菜//数量
//								print_r($dai);die;
					   }
				}	
				$this->assign('rowset',$rowset);
//			}
			
			$this->assign('query',$query);
			$this->assign('wo',$wo);
			$this->assign('daipron',$daipron);
	    	$this->assign('yipron',$yipron);
	    	$this->assign('order1',$order);
    	return $this->fetch();
    }
    	
//  添加采购单页面
     public function neworder(Request $request) {
     	$shous = input('post.shous');
     	$status = input('param.status');
     	$shopid = input('param.shopid');
     	$sc = input('param.sc');
     	$shop = input('param.shopname');
//		$zz = Db::table('ycl_goods')->where('goodsname',"like %$shous%")->select();
//				print_r($zz);die;
     	$rowset2 = Db::table('ycl_goods')->where('shopid',$shopid)->where('goodsname',$sc)->find();
     	$aa =$rowset2['goodsprice'];
//   	$money = cookie('goodsmoney',$aa,3600);
		$this->assign('shopid',$shopid);
     	$this->assign('aa',$aa);
     	$this->assign('sc',$sc);
     	$this->assign('shopname',$shop);
		if($status == 1) {
				$arr = cookie('xinarray');
				$count = count($arr);
				for($i=0; $i<$count; $i++) {
					$arr[$i]['suoy'] = $i;
				}
//				print_r($arr);die;
		} else {
				$arr = array(
					  array(
					'goodsname' => null,
					'number' => null,
					'content' => null,
					'goodsmoney' => null,
					'money' => null,
					'shop' => null,
					'add_time' => null,
					'suoy' => null
					),
				);
		}
			
		$name = $request->post('name1');
    	$rowset = Db::table('ycl_goods')->where('goodsname',$name)->select();
    	$jy = array();
    	for($i = 0; $i<count($rowset);$i++){
			$book = Db::table('ycl_shop_info')->where('id',$rowset[$i]['shopid'])->find();
			$norm = Db::table('ycl_spec')->where('id',$rowset[$i]['goodsgg'])->find();
//			print_r($norm);die;
			$jy[$i]['shopid']     = $book['id'];
			$jy[$i]['shop_name']  = $book['shop_name'];
			$jy[$i]['shop_img']   = $book['shop_img'];
			$jy[$i]['address']    = $book['address'];
			$jy[$i]['goodsprice'] = $rowset[$i]['goodsprice'];
			$jy[$i]['goodsname']  = $rowset[$i]['goodsname'];
			$jy[$i]['name']       = $norm['name'];
		}
		cookie('jy',$jy);
		if ($jy) {
		 	$data['status'] = 1;
			$data['info'] = "请选择页面!";
			$msg = json_encode($data);
			echo $msg;
			return;
		 }
     	if($shous !== null) {
//		 	$this->assign('arr',$arr); 
			$rowset1 = Db::table('ycl_goods')->whereGoodsname('like', "%$shous%")->select();
			$abr = array(); 
				foreach($rowset1 as $key=>$val){ 
				if(!in_array($rowset1[$key]['goodsname'],$abr)){ 
				$abr[] = $rowset1[$key]['goodsname']; 
				}else{ 
				unset($rowset1[$key]); 
				} 
				} 

//				 print_r($rowset1);die;
       		$this->assign('rowset1',$rowset1);

     	} else {
//   		$arr = cookie('arr');
     		$rowset1 = Db::table('ycl_goods')->limit(6)->select();
//   		print_r($rowset1);
     		$this->assign('rowset1',$rowset1);
     	}

     	$this->assign('arr',$arr);	
     	return $this->fetch();
    }
    
    public function cgdsave (Request $request) {
    	$name1 = $request->post('name1');
		$num1 = $request->post('num1');
		$sm = $request->post('sm1');
		$dj = $request->post('dj1');
		$xj = $request->post('xj1');
		$shopid = $request->post('shopid');
//		print_r($shopid);die;
		$time = time();
		$shop = $request->post('shop1');
		session('goods', $name1);
		session('shop_id', $shopid);
		session('number', $num1);
		session('content', $sm);
		session('goodsmoney', $dj);
		session('money', $xj);
		session('shop', $shop);
		session('time', $time);
		$arr = array(
				'uid' 		=> session('userid'),
				'goodsname' => session('goods'),
				'number' => session('number'),
				'content' => session('content'),
				'goodsmoney' => session('goodsmoney'),
				'money' => session('money'),
				'shop_id' => session('shop_id'),
				'shop' => session('shop'),
				'add_time' => session('time')
		);
		$xinarray = array();
		if(cookie('xinarray') == null) {
			if(!empty($arr)){
			$xinarray[] = $arr;
//			array_push($xinarray,$arr);
			}
		} else {
			$temp = cookie('xinarray');
			foreach($temp as $k=>$v) {
				$xinarray[] = $temp[$k];
			}
			$xinarray[] = $arr;
		}
		
		cookie('xinarray',$xinarray);
//		print_r(cookie('arr'));die;
		if ($arr) {
			$data['status'] = 1;
			$data['info'] = "保存成功!";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
    }
    
//  店铺
    public function dishes() {
		$jy = cookie('jy');
//		print_r($jy);die;
		$this->assign('jy',$jy);
//  	cookie('jy',null); //清空cookie
    	return $this->fetch();
    }
    
     public function cpdel() {
    	$souy = input('param.suoy');
    	$arr = cookie('xinarray');
    	unset($arr[$souy]);
//  	cookie($souy,null);
		
    	$xinarray = array_values($arr);
    	for($i=0; $i<count($xinarray); $i++) {
    		$xinarray[$i]['suoy']= $i;
    	}
    	cookie('xinarray',$xinarray);
		return $this->redirect(url('/index/purchase/neworder/status/1'));
    }
    
    
   public function cgdsave1 (Request $request) {
    	$cgid = "CGDH".time().rand(100000,999999);
    	$shopid = input('param.shopid');
    	$rowset = cookie('xinarray');
    		if($rowset !== null) {
    		foreach ($rowset as $k => $v) {

    		$rowset[$k]['cgdh'] = $cgid;
//  		print_r($rowset[$k]['cgdh']);die;
    		$query = Db::table('ycl_purchase')->insert($rowset[$k]);
    		}
//  		die;
    		if($query) {
    		cookie('xinarray',null);
    		$data['status'] = 1;
			$data['info'] = "保存成功!";
			$msg = json_encode($data);
			echo $msg;
			return;	
    			}
    		} else {
    		$data['status'] = -2;
			$data['info'] = "没有数据!";
			$msg = json_encode($data);
			echo $msg;
			return;	
    	}
		
    }


    
     public function purchaseorderdetail() {
    	$cgdh = input('param.cgdh');
    	$rowset = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select();
    	$res= [];
//  	print_r($res);
		foreach($rowset as $k=>$v){
			$shop = Db::table('ycl_shop_info')->where('id',$v['shop_id'])->find();
			$v['shop_id'] = $shop['shop_name'];
			$res[$v['shop_id']]['status'] = $v['status'];
			$res[$v['shop_id']][$v['goods_id']][]=$v;
		}
//  	print_r($);die;
    	$this->assign('rowset',$res);
    	$this->assign('cgdh',$cgdh);
    	return $this->fetch();
    }
    
    public function orderpurchase() {
    	$cgdh = input('param.cgdh');
    	$rowset = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select();
//  	print_r($rowset);die;
    	$this->assign('rowset',$rowset);
    	$this->assign('cgdh',$cgdh);
    	return $this->fetch();
    }
    
    public function confirmorder() {
    	$shop  = input('param.shopid');//店铺id
    	$cgdh  = input('param.cgdh');  //采购单号
    	$shopname = Db::table('ycl_shop_info')->where('id',$shop)->find();
    	
    	$shopname1 = Db::table('ycl_shop_info')->select();
    	$aa = array_column($shopname1,'shop_name','id');
    	$this->assign('shopname',$shopname);
    	$this->assign('aa',$aa);
    	$this->assign('cgdh',$cgdh);
    	
		
    	$rowset = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select();
    	$this->assign('rowset',$rowset);
//    	  	print_r($rowset);die;

    	$this->assign('cgdh',$cgdh);
    	return $this->fetch();
    }           
    
     public function gmdishes() {
     	$id = input('param.id');//采购单ID
     	$goodsname = input('param.goodsname');//商品名称
     	$cgdh = input('param.cgdh');//采购单号
     	$goodsid = input('param.goodsid');//商品id
     	$shopid = input('param.shopid');//店铺id
    	$rowset = Db::table('ycl_goods')->where('goodsname',$goodsname)->select();
    	$jy = array();
    	for($i = 0; $i<count($rowset);$i++){
			$book = Db::table('ycl_shop_info')->where('id',$rowset[$i]['shopid'])->find();
			$norm = Db::table('ycl_spec')->where('id',$rowset[$i]['goodsgg'])->find();
//			print_r($norm);die;

			$jy[$i]['shopid']     = $book['id'];
			$jy[$i]['shop_name']  = $book['shop_name'];
			$jy[$i]['shop_img']   = $book['shop_img'];
			$jy[$i]['address']    = $book['address'];
			$jy[$i]['goodsprice'] = $rowset[$i]['goodsprice'];
			$jy[$i]['goodsname']  = $rowset[$i]['goodsname'];
			$jy[$i]['name']       = $norm['name'];
			$jy[$i]['id']         = $rowset[$i]['id'];
		}
//		print_r($id);die;
 		$this->assign('shopid',$shopid);
		 $this->assign('id',$id);
		 $this->assign('jy',$jy);
		 $this->assign('cgdh',$cgdh);
		 $this->assign('goodsname',$goodsname);
    	return $this->fetch();
    }
    
 
    
// public function xzdel() {
//  	$cgdh = input('param.cgdh');
//  	$shop1 = cookie('shop');
//  	cookie($shop1,null);
//  	return $this->redirect(url('/index/purchase/confirmOrder/cgdh/' . $cgdh));
//  }
//  
   public function ordersave(){
    	$cgdh = input('param.cgdh');//采购单号
    	$id   = input('param.id');//采购单id
//  	print_r($id);die;
		if(empty($id)){
			$this->success('请选择商品!');
		}
    	foreach($id as $id_k => $id_v){
    	$c[] = $id_v['ddid'];//ID
//  	$n[] = $id_v['num'];//数量
//    	 $nu['number'] = $n;
    	Db::table('ycl_purchase')->where('id',$id_v['ddid'])->update(['number' => $id_v['num']]);//更新采购单数量
    	}    	
    		$purchase   = Db::table('ycl_purchase')->whereIn('id',$c)->select();//采购单
//  		print_r($a);die;
    		foreach ($purchase as $k => $v) {
    				
    			$order_id   = "DDH".rand(100000,999999).time();
    			$goods = Db::table('ycl_goods')->where('goodsname',$v['goodsname'])->find();
    			$order = Db::table('ycl_order')->where('cgdh',$v['cgdh'])->where('shopid',$v['shop_id'])->value('order_id');
    			$sum = Db::table('ycl_purchase')->where('cgdh',$v['cgdh'])->where('shop_id',$v['shop_id'])->sum('money');//采购单号总金额
    			if(!empty($order)){
    				$order_id = $order;
    			}
    			if(empty($v['shop_id'])){
    				$this->success('请选择商家!');
    			}
    			   $total = $v['number'] * $v['goodsmoney'];
	    			$arr=array(
	    			'goods_id' 	=> $goods['id'],
	    			'shopid'  	=> $v['shop_id'],
	    			'good_pirce'=> $v['goodsmoney'],
	    			'total'  	=> $total,
	    			'good_num'  => $v['number'],
	    			'order_id'  => $order_id,
	    			'cgdh'      => $v['cgdh'],
	    			'cq_id'     => $v['uid'],
	    			'buy_id'    => $v['uid'],
	    			'complate_time'=>time(),
	    			'money'     => $sum,
	    			'goodsgg'   => $goods['goodsgg'],
	    			'add_time'  => time()
	    			);
	    			$shop = Db::table('ycl_shop_info')->where('id',$v['shop_id'])->find();//查询店铺销量
	    			$good = Db::table('ycl_goods')->where('id',$goods['id'])->find();
	    			$up['sales']  = $good['sales'] + $v['number'];
					$up['stock']  = $good['stock'] - $v['number'];
					$sh['sales']  = $shop['sales'] + $v['number'];
//					print_r($purchase);die;
					Db::table('ycl_shop_info')->where('id',$v['shop_id'])->update($sh);//查询店铺销量
					Db::table('ycl_goods')->where('id',$good['id'])->update($up);
					Db::table('ycl_purchase')->where('id',$v['id'])->update(['status' => 1]);
	    			$query = Db::table('ycl_order')->insert($arr);	
    			
    	
    }
//  print_r($purchase);die;
    	
    	if ($query) {
			$this->success('下单成功','/index/purchase/order1');
		}
    }
    
    //ajax  获取聊天信息

    public function ChatContent(){
        $content = input('param.content');
//      print_r($content);die;
        $userid = session('userid');
        //门店ID   即为分组ID
        $group = Db::table('ycl_user')->where('id',$userid)->find();
//		print_r($group);die;
        $data = [
//      print_r($data);
            'userid'   => $userid,
            'group'    => $group['work_id'],
            'content'  => $content,
            'status'   => 1,
            'addtime'  => time(),
            'nickname' => $group['nickname'],
            'portrait' => $group['image'],
            ];
        $rs = Db::table('ycl_chat_group')->insert($data);
        if(!$rs){
            return '发送失败，检查后重试';
        }else{
            return '发送成功';
        }
    }


   
//	public function  shopcenter(){		
//		$shopid = input('param.shopid'); //店铺ID
//		$cgdh   = input('param.cgdh'); //采购单号
//		$id     = input('param.id'); //采购单id
//		$cgd    = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select();
//		$a = 0;
//		foreach ($cgd as $k=>$v){
//			$rows  = Db::table('ycl_goods')->where('shopid',$shopid)->select();//搜索这个店铺下所有商品
//			$i = 1;
//			foreach($rows as $row_k => $row_v){
//				if($a >= 1){
//					continue;
//				}
//				if($v['goodsname'] == $row_v['goodsname']){
//					$row[0]['goodsname']  = $row_v['goodsname']; //商品名
//					$row[0]['goodspic']   = $row_v['goodspic']; //商品图片
//					$row[0]['id'] 		  = $row_v['id']; //商品id
//					$row[0]['shopid'] 	  = $row_v['shopid']; //所属店铺
//					$row[0]['goodsarea']  = $row_v['goodsarea'];//商品产地
//					$row[0]['goodsprice'] = $row_v['goodsprice'];//商品单价
//					$row[0]['goodsgg']    = $row_v['goodsgg'];//商品产地
//
//				}else{
//					$row[$i]['goodsname']  = $row_v['goodsname'];
//					$row[$i]['goodspic']   = $row_v['goodspic']; //商品图片
//					$row[$i]['id'] 		   = $row_v['id']; //商品id
//					$row[$i]['shopid'] 	   = $row_v['shopid']; //所属店铺
//					$row[$i]['goodsarea']  = $row_v['goodsarea'];//商品产地
//					$row[$i]['goodsprice'] = $row_v['goodsprice'];//商品单价
//					$row[$i]['goodsgg']    = $row_v['goodsgg'];//商品产地		
//			}
//				$i++;	
//			}
//	 		$a++;
////	 		print_r($row);
//		}
////		dump($row);die;
//	 	
//	 	//	print_r($cgd);die;
//		
//
//		$shop = Db::table('ycl_shop_info')->select(); //将规格表的 id 转为name显示
//		$aa   = array_column($shop,'shop_name','id');
//		
//		$yi=Db::table('ycl_spec')->select(); //将规格表的 id 转为name显示
//		$gg = array_column($yi,'name','id');
//		
//		$this->assign('gg',$gg);
//		$this->assign('aa',$aa);
//		$this->assign('row',$row);
//		$this->assign('id',$id);
//		$this->assign('cgdh',$cgdh);
//		$this->assign('shopid',$shopid);
////		print_r($row);die;
//		return $this->fetch();
//	
//	}
	
	
		public function affirm() {// 店铺列表 确认选择按钮
		$shopid = input('param.shopid');
		$gid 	= input('param.goodsid');//商品单ID
		$id 	= input('param.id');//采购单ID
		$cgdh 	= input('param.cgdh');//采购单ID
//		print_r($id);die;
		$goods = Db::table('ycl_goods') ->where('id',$gid)->find();//商品表
		$pur  = Db::table('ycl_purchase') ->where('id',$id)->find();//采购单
		$zong = $pur['number'] * $goods['goodsprice'];
//		print_r($pur);die;
		
		$arr =array(
		'shop_id' 	 =>$shopid,
		'goodsmoney' =>$goods['goodsprice'],
		'money'		 =>$zong
//		'goodsname'	 =>$goods['goodsname']
		);
//		print_r($arr);die;
	
		if ($shopid) {

			$up = Db::table('ycl_purchase') ->where('id',$id)->update($arr);
//			print_r($up);die;
		}	
		return redirect('/index/purchase/confirmOrder/cgdh/' .$cgdh);
	}
	
	
	
	public function order() {
		if (session('userid') == null) {
			return $this->redirect(url('/index/login/login'));
		}
			$order = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status != 8')->where('sales_return',0)->order('complate_time desc')->group('order_id')->select();
//			print_r($order1);die;
			$num = 0;
			$yan = 0;
			$fu  = 0;
			$zheng=0;
			if(!empty($order)){
				foreach($order as $k=>$v){
					$row = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
					$order[$k]['shopid'] = $row['shop_name'];
					$yan = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',1)->where('sales_return',0)->group('order_id')->count();
					$fu = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->group('order_id')->count();
					$zheng = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',2)->group('order_id')->count();
				}
			}
			$num = count($order);
			$this->assign('yan',$yan);
			$this->assign('fu',$fu);
			$this->assign('zheng',$zheng);
			$this->assign('num',$num);
			
			$this->assign('order1',$order);
		
		return $this->fetch();
	}
	    public function processingorder() {
	    	$yan = 0;
			$fu  = 0;
			$zheng=0;
			$quan=0;
    		$rowset= Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',1)->where('sales_return',0)->group('order_id')->select();
    		$quan  = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status != 8')->order('complate_time desc')->group('order_id')->count();
			$yan   = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',1)->where('sales_return',0)->group('order_id')->count();
			$fu    = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->group('order_id')->count();
			$zheng = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',2)->group('order_id')->count();

//  		print_r($rowset);die;
    		$count = count($rowset);
    		foreach ($rowset as $k=>$v) {
    				
    			$shop = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
//  			print_r($shop);die;
    			$rider= Db::table('ycl_user')->where('id',$v['rider_id'])->find();
    			$goods= Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
    			$rowset[$k]['goods_id'] = $goods['goodsname'];
    			$rowset[$k]['shop_id']  = $shop['shop_name'];
    			$rowset[$k]['rider_id'] = $rider['true_name'];
    			
    			
    			$this->assign('shop',$shop);
    		}
    		$this->assign('yan',$yan);
			$this->assign('fu',$fu);
			$this->assign('zheng',$zheng);
			$this->assign('quan',$quan);
    		$this->assign('count',$count);
    		$this->assign('rowset',$rowset);    	
    	
    	return $this->fetch();
    }
    
    //待付款
	public function pendingpayment() {
//			$yan  = 0;
//			$quan = 0
//			$fu   = 0;
//			$zheng=0;
			$sum1 = 0;
    		$rowset = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->group('order_id')->select();
    		$quan = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status != 8')->group('order_id')->order('complate_time desc')->count();
			$yan = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',1)->where('sales_return',0)->group('order_id')->count();
			$fu = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->group('order_id')->count();
			$zheng = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',2)->group('order_id')->count();
//  		$rowset1 = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->sum('total');
//  		print_r($rowset1);die;
    		foreach($rowset as $k=>$v){
    			$temp = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
    			$rowset[$k]['goods_id'] = $temp['goodsname']; 
//  			
//  		    $aa += $v['total'];
    		}
//  		print_r($aa);die;
    		
    		
    		$count = count($rowset);
//  		$this->assign('aa',$aa);
    		$this->assign('yan',$yan);
			$this->assign('fu',$fu);
			$this->assign('zheng',$zheng);
			$this->assign('quan',$quan);
    		$this->assign('sum1',$sum1);
    		$this->assign('count',$count);
    		$this->assign('rowset',$rowset);    	
		return $this->fetch();
	}    
	
	
	//待验证
	public function pendingverification() {
//			$yan = 0;
//			$quan = 0
//			$fu  = 0;
//			$zheng=0;
			$quan = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status != 8')->group('order_id')->order('complate_time desc')->count();
			$yan = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',1)->where('sales_return',0)->group('order_id')->count();
			$fu = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',0)->group('order_id')->count();
			$zheng = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',2)->group('order_id')->count();
    		$rowset = Db::table('ycl_order')->where('cq_id',session('userid'))->where('order_status',2)->group('order_id')->select();
    		$count = count($rowset);
    		foreach ($rowset as $k => $v) {
    			$rider = Db::table('ycl_user')->where('id','rider_id')->find();
    			$rowset[$k]['rider_id'] = $rider['username'];
    		}
//  		$this->assign('count',$count);
    		$this->assign('rowset',$rowset);
    		$this->assign('yan',$yan);
			$this->assign('fu',$fu);
			$this->assign('zheng',$zheng);    	
    	$this->assign('quan',$quan);  
		return $this->fetch();
	}
	

	public function code(){     //二维码验证
		$id = input('param.id');//订单ID
//		print_r($id);die;
		$row = Db::table('ycl_order')->where('id',$id)->find();
		$row1 = Db::table('ycl_order')->where('order_id',$row['order_id'])->select();
		
 				header('content-type:image/png');  //设置gif Image
				ob_clean();
				//$url = urldecode("http://www.baidu.com");//连接后跳转地址
				$url = urldecode($row['order_id']);//连接后跳转地址
				$qrcode = new QRcode();
				$png = QRcode::png($url,false,"H",4,1);
				$imageString = base64_encode(ob_get_contents());
				ob_end_clean();
				$png = "data:image/jpg;base64,".$imageString;
				
		foreach($row1 as $k=>$v){
			$row2 = Db::table('ycl_order')->where('order_id',$row['order_id'])->where('sales_return',1)->select();
			$temp=Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$user=Db::table('ycl_user')->where('id',$v['rider_id'])->find();
			$row['rider_id'] 	= $user['username'];
			$row1[$k]['shopid'] = $temp['shop_name'];
			$goods=Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
			$row1[$k]['goods_id']= $goods['goodsname'];
//			foreach($row2 as $k1=>$v1){
//			print_r($temp)
//			$row1[$k]['goods_id']= $v1['goods_id'];
//			}
		}
//		print_r($row1);die;
		$num=count($row1);
		$num1=count($row2);
		$this->assign('num',$num);
		$this->assign('num1',$num1);
		$this->assign('png',$png);
//		print_r($row1);
		$this->assign('temp',$temp);
		$this->assign('row1',$row1);
		$this->assign('row',$row);
		return $this->fetch();
	}

	
	public function dishesdetails1(){ //采购单菜品详情
		$id = input('param.id');//采购单id
		$goodsid = input('param.goodsid');  //商品id
		$shopid = input('param.shopid');  //采购单店铺id
		$cgdh    = input('param.cgdh'); //采购单号
		$rowset = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select();
		$shopname1 = Db::table('ycl_shop_info')->select();
    	$aa = array_column($shopname1,'shop_name','id');
//  	$this->assign('shopname',$shopname);
    	$this->assign('aa',$aa);
    	$this->assign('rowset',$rowset);
//    	  	print_r($rowset);die;

		$goods = Db::table('ycl_goods')->where('id',$goodsid)->find();//商品表
		$gg = Db::table('ycl_spec')->where('id',$goods['goodsgg'])->find();//规格表
		$pin = Db::table('ycl_brand')->where('id',$goods['brand_id'])->find();//品牌表
		$goods['goodsgg'] = $gg['name'];
		$goods['brand_id'] = $pin['brand_name'];
		$shop = Db::table('ycl_shop_info')->where('id',$goods['shopid'])->find();//商品表对应店铺
		$this->assign('cgdh',$cgdh);
		$this->assign('id',$id);
		$this->assign('goods',$goods);
		$this->assign('shop',$shop);
		$this->assign('shopid',$shopid);
		return $this->fetch();
	}
	
	public function tail(){//订单详情
		   	$ddh = input('param.ddh');//订单id
    		$rowset = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_id',$ddh)->select();
//  	print_r($rowset);die;
    		foreach($rowset as $k=> $v) {
    		$query = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
    		$goodsgg = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
    		$rowset[$k]['goods_id'] = $query['goodsname'];
    		$rowset[$k]['goodsgg'] = $goodsgg['name'];
    	}
    	$this->assign('rowset',$rowset);
    	return $this->fetch();
	}
}
