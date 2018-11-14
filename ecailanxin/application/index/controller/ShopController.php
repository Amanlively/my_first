<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Store;
use think\Db;
use think\Request;
use think\File;
class ShopController extends Controller
{
//	显示我的餐厅
	public function mystore()
    {
    	//$rowset2 = Db::table('ycl_role')->where('uid',session('userid'))->find();
//  	$query = Db::table('ycl_user')->select();
//  	$shopname = array_column($query,'cqname','id');
//  	$this->assign('rowset2',$rowset2);
    	$rowset = Db::table('ycl_user')->where('id',session('userid'))->find();
//  	$rowset1 = Db::table('ycl_shop_info')->where('shop_name',$rowset['cqname'])->find();
    	$rowset2 = Db::table('ycl_role')->where('uid',$rowset['id'])->find();
    	$this->assign('rowset2',$rowset2);
    	$this->assign('rowset',$rowset);
    	$row = Db::table('ycl_store')->where('cq_id',$rowset['id'])->find();
    	$this->assign('shopmd',$row);
		return $this->fetch();
    }
//	显示餐厅人员
    public function personmanagement1()
    {
    	$cqid = input('param.cqid');
    	$rowset = Db::table('ycl_role')->where('group_id',$cqid)->select();
    	foreach($rowset as $k => $v) {
    		$query = Db::table('ycl_user')->where('id',$v['uid'])->find();
    		$rowset[$k]['uid'] = $query['username'];
    	}
    	$this->assign('rowset',$rowset);
//  	$this->assign('js',$js);
    	$this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
     public function personmanagement()
    {
    	$cqid = input('param.cqid');
        $this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
    // 添加餐厅人员
    public function personmanagement2()
    {
    	$cqid = input('param.cqid');
    	
    	$this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
    public function cqrysave()
    {
    	$cqid = input('param.cqid');
		$phone = input('post.phone');
		$content = input('post.content');
		$js = input('post.js');
		$auth = 0;
		if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -5;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		if ($phone == null) {
    		$data['status'] = -1;
			$data['info'] = "手机号不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		if ($content == null) {
    		$data['status'] = -2;
			$data['info'] = "备注不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
		}

		if ($js == "厨师") {
			$auth =  1;
		} elseif($js == "采购") {
			$auth =  2;
		} elseif($js == "验收") {
			$auth =  3;
		} elseif($js == "起草订单") {
			$auth =  4;
		} elseif($js == "管理员") {
			$auth =  5;
		} 
		$rowset = Db::table('ycl_role')->where('group_id',$cqid)->select();
//		foreach ($rowset as $k => $v) {
			$query = Db::table('ycl_user')->where('phone',$phone)->find();
			if(!$query) {
				$data['status'] = -3;
				$data['info'] = "餐厅没有该用户";
				$msg = json_encode($data);
				echo $msg;
				return;
			} else {
				$row =  Db::table('ycl_user')->where('phone',$phone)->find();
				$arr = array(
				'uid' => $row['id'],
				'group_id' => $cqid,
				'js_name'  => $js,
				'content'  => $content,
				'addtime'  => time(),
				'auth'     => $auth
				);
				$cq = Db::table('ycl_user')->where('id',$row['id'])->update(['work_id' => session('userid')]);
				$query1 = Db::table('ycl_role')->insert($arr);

				if ($query1) {
					$data['status'] = 1;
					$data['info'] = "添加成功";
					$msg = json_encode($data);
					echo $msg;
					return;
				}
			}
//		}
    }
    // 餐厅人员详情
    public function persondetail() {
    	$id = input('param.id');
    	$cqid = input('param.cqid');
    	$rowset = Db::table('ycl_role')->where('id',$id)->find();
    	$query = Db::table('ycl_user')->where('id',$rowset['uid'])->find();
    	$this->assign('rowset',$rowset);
    	$this->assign('query',$query);
    	$this->assign('cqid',$cqid);
    	return $this->fetch();
    }
    //修改餐企人员信息
     public function ryupdate(Request $request) {
    	$id = input('param.id');
    	$js = input('post.js');
    	$content = input('post.content');
//  	print_r($js);die;
		$arr = array(
		'js_name' => $js,
		'content' => $content
		);
    	$rowset = Db::table('ycl_role')->where('id',$id)->update($arr);
    	if ($rowset) {
    		$data['status'] = 1;
			$data['info'] = "修改成功";
			$msg = json_encode($data);
			echo $msg;
			return;
    	} else {
    		$data['status'] = -1;
			$data['info'] = "修改失败,请检查!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    }
//  餐企人员删除
    public function rydel() {
    	$id = input('param.id');
//    	print_r(session('userid'));exit;
        $sess = Db::table('ycl_role')->where('id',$id)->find();
        if (session('userid') == $sess['uid']){
            $data['status'] = 5;
            $data['info'] = "您不能删除自己!";
            $msg = json_encode($data);
            echo $msg;
            return;
        }
else{


    	$rowset = Db::table('ycl_role')->where('id',$id)->delete();
    	if ($rowset) {
    		$data['status'] = 1;
			$data['info'] = "删除成功!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	} else {
    		$data['status'] = -1;
			$data['info'] = "删除失败!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
        }
    }
    
    // 显示门店
     public function storemanagement()
    {
    	$cqid = input('param.cqid');
    	$this->assign('cqid',$cqid);
        $mdid = Db::table('ycl_store')->where('cq_id',$cqid)->order('add_time desc')->select();
  	    $this->assign('mdid',$mdid);
		return $this->fetch();
    }
    
    // 显示门店
     public function storemanagement1()
    {
    	$cqid = input('param.cqid');
    	$query = Db::table('ycl_store')->where('cq_id',$cqid)->select();
    	$this->assign('query',$query);
//  	$this->assign('rowset',$rowset);
    	$this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
    // 门店地址
     public function deliveryInformation()
    {
    	$mdid = input('param.mdid');
    	$rowset = Db::table('ycl_address')->where('shop_id',$mdid)->order('id desc')->limit(1)->select();
//  	$sh = Db::table('ycl_store')->select();
//  	$shname = array_column($sh,'manager_name','id');
//  	$this->assign('shname',$shname);
    	$this->assign('rowset',$rowset);
    	$this->assign('mdid',$mdid);
		return $this->fetch();
    }
    
    // 门店地址添加
     public function addaddress()
    {
    	$mdid = input('param.mdid');
    	$this->assign('mdid',$mdid);
    	return $this->fetch();

//  	return $this->fetch();
    }
    
    // 门店地址删除
     public function messagedel()
    {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$rowset = Db::table('ycl_address')->where('id',$id)->delete();
    	return $this->redirect(url('/index/shop/deliveryInformation/mdid/' . $mdid));
    }
    
    // 门店地址修改
     public function addressxg()
    {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$rowset = Db::table('ycl_address')->where('id',$id)->find();
    	$this->assign('rowset',$rowset);
    	$this->assign('mdid',$mdid);
    	return $this->fetch();
    }
    //门店地址修改保存
    public function addressxgsave() {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$consignee = input('post.consignee');
    	$phone = input('post.phone');
    	$region = input('post.region');
    	$street = input('post.street');
    	$details = input('post.details');
    	if ($consignee == null) {
    		$data['status'] = -1;
			$data['info'] = "收货人不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($phone == null) {
    		$data['status'] = -2;
			$data['info'] = "联系人不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($region == null) {
    		$data['status'] = -3;
			$data['info'] = "地区不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($street == null) {
    		$data['status'] = -5;
			$data['info'] = "街道不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($details == null) {
    		$data['status'] = -6;
			$data['info'] = "详细地址不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -9;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
    	
    	$arr = array(
    	'shop_id' => $mdid,
    	'consignee' => $consignee,
    	'phone' => $phone,
    	'region' => $region,
    	'street' => $street,
    	'details' => $details,
    	'is_mr' => 0
    	);
    	
    	$query = Db::table('ycl_address')->where('id',$id)->update($arr);
    	if ($query) {
    		$data['status'] = 1;
			$data['info'] = "地址修改成功!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	} else {
    		$data['status'] = -7;
			$data['info'] = "地址修改失败,请检查!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}   	
    }
    
    public function addressbc() {
    	$mdid = input('param.mdid');
    	$consignee = input('post.consignee');
    	$phone = input('post.phone');
    	$region = input('post.region');
    	$street = input('post.street');
    	$details = input('post.details');
    	if ($consignee == null) {
    		$data['status'] = -1;
			$data['info'] = "收货人不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($phone == null) {
    		$data['status'] = -2;
			$data['info'] = "联系电话不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($region == null) {
    		$data['status'] = -3;
			$data['info'] = "地区不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($street == null) {
    		$data['status'] = -5;
			$data['info'] = "街道不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if ($details == null) {
    		$data['status'] = -6;
			$data['info'] = "详细地址不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -9;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
    	
    	$arr = array(
    	'shop_id' => $mdid,
    	'consignee' => $consignee,
    	'phone' => $phone,
    	'region' => $region,
    	'street' => $street,
    	'details' => $details,
    	'is_mr' => 1
    	);
    	
    	$query = Db::table('ycl_address')->insert($arr);
    	if ($query) {
    		$data['status'] = 1;
			$data['info'] = "地址添加成功!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	} else {
    		$data['status'] = -7;
			$data['info'] = "地址添加失败,请检查!";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}   	
    }
    
    // 添加新门店
     public function storeinfomation()
    {
    	$cqid = input('param.cqid');
    	$this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
     public function mdsave()
    {
    
		$cqid         = input('param.cqid');
		$houseid      = input('post.houseid');
		$name         = input('post.name');
		$address      = input('post.address');
		$manager_name = input('post.manager_name');
		$manager_phone= input('post.manager_phone');
		
	if(!preg_match("/^1[345678]{1}\d{9}$/",$manager_phone)){
		$this->error('手机号,格式不正确');
		}
		if ($houseid == null) {
			$this->error('门牌号不能为空!');
		}
		if ($name == null) {
			$this->error('门店名称不能为空!');
		}
		if ($address == null) {
			$this->error('门店地址不能为空!');
		}
		if ($manager_name == null) {
			$this->error('负责人姓名不能为空!');
		}
		if ($manager_phone == null) {
			$this->error('负责人手机号不能为空!');
		}
		$arr = array(
		'cq_id' => $cqid,
		'house_id' => $houseid,
		'name' => $name,
		'address' => $address,
		'manager_name' => $manager_name,
		'manager_phone' => $manager_phone,
		'add_time' => time()
		);
		$rowset = Db::table('ycl_store')->insert($arr);
		if ($rowset) {
			
			$md = Db::table('ycl_store')->where('name',$name)->find();
//			var_dump($md);
//			exit;
			$this->success('添加成功!','/index/shop/certificationinfo/cqid/'. $cqid. '/mdid/'.$md['id']);
		} else {
			$this->error('添加失败,稍后重试!');
		}
	
		
    }
     
    // 门店认证
     public function certificationinfo()
    {
    	$mdid = input('param.mdid');
    	$cqid = input('param.cqid');
    	$rowset = Db::table('ycl_store')->where('id',$mdid)->find();
    	$this->assign('rowset',$rowset);
    	$this->assign('cqid',$cqid);
		return $this->fetch();
    }
    
     public function approvexg(Request $request)
    {
    	$mdid =  input('param.mdid');
    	$cqid = input('param.cqid');
		$file = $request->file('mdimg');
		
//			print_r($file);die;
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/mdimg' );
				if($info){
					$data['image']=$info->getSaveName();
				}
			}
			

			$file1 = $request->file('certificate');
//			print_r($file1);die;
			if($file1){
				$data['certificate'] = Store::uplodes($file1);
			}
			
//			dump($data);die;
			$file2 = $request->file('qtimg');
			if($file2){
				$info=$file2->move ( \ENV::get('root_path'). '/public/static/uploads/mdimg' );
				if($info){
					$data['qtimg']=$info->getSaveName();
				}
			}
			if ($file !== null && $file1 !== null && $file2 !== null) {
					Db::table('ycl_store')->where('id',$mdid)->update($data);
				return $this->redirect(url('/index/shop/addaddress/mdid/' . $mdid));		
			} else {
				return $this->redirect(url('/index/shop/certificationinfo/cqid/'. $cqid. '/mdid/'.$mdid));
			}
    }

    
//  显示已完成的订单
	public function historyorder() {
		$rowset = Db::table('ycl_role')->where('uid',session('userid'))->find();
			$query = Db::table('ycl_order')->where('cq_id',$rowset['uid'])->where('order_status',8)->group('order_id')->select();
			$user = Db::table('ycl_user')->where('id',$rowset['uid'])->find();
			$coun = 0;
			$sum = 0;
			foreach($query as $k=>$v){
				$query[$k]['buy_id'] = $user['username'];
				$coun = Db::table('ycl_order')->where('order_id',$v['order_id'])->where('order_status',8)->count();
				$sum = Db::table('ycl_order')->where('order_id',$v['order_id'])->where('order_status',8)->sum('good_num');
			}
			$this->assign('query',$query);
			$this->assign('coun',$coun);
		$this->assign('sum',$sum);
		return $this->fetch();
	}
	
	
	public function distribution3(){
		$id = input('param.order_id');//订单号
			$order = Db::table('ycl_order')->where('order_id',$id)->select();
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
			$this->assign('order1',$order);
			$this->assign('shop',$shop);
			$this->assign('cq',$cq);
		return $this->fetch();
	}
    
}
