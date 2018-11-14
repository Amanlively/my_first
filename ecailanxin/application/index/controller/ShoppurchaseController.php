<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
header("Content-Type: text/html; charset=UTF-8");
class ShoppurChaseController extends Controller
{
	
	public  function businessdetail(){ //店铺详情
			$shop = input('param.shopid'); //店铺ID
			$shopid = input('param.shopcgd'); //采购单店铺id
			$cgdh = input('param.cgdh'); //采购单号
			$id   = input('param.id');//采购单id
			$gid = input('param.goodsid'); //商品id
			$pur = Db::table('ycl_purchase')->where('cgdh',$cgdh)->select(); //搜索采购表
//			print_r($shop);die;
			$this->assign('pur',$pur);
			$this->assign('cgdh',$cgdh);
			$one1 = input('param.one'); //接收一级分类过来的ID
    		$two1 = input('param.two'); //接收二级分类过来的ID
			$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); //搜索店铺表
//			cookie('pei',$rowset['delivery']);
			$shopname1 = Db::table('ycl_shop_info')->select();
    	$aa = array_column($shopname1,'shop_name','id');
    	$this->assign('aa',$aa);
			$rowset1 = Db::table('ycl_collect')->where('uid',session('userid'))->where('shop_id',$shop)->find(); //搜索店铺
			$xinarray = cookie('xinarray');
			$zong = cookie('t1');
//			print_r($xinarray);
			$this->assign('zong',$zong);
			$this->assign('xinarray',$xinarray);
			$this->assign('rowset1',$rowset1);
			$time = date('H');
			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
				$kai = '营业中' ;
			}else{
				$kai = '已打烊' ;
			}
			$this->assign('kai',$kai);
//			print_r($time);die;
    	    $this->assign('rowset',$rowset);
 		
  			$one = Db::table('ycl_category_one')->select();//查询一级分类表
    		$this->assign('one',$one);
    		
    		$two = Db::table('ycl_category_two')->where('up_catid',$one1)->select(); //查询二级分类表
    		$this->assign('two',$two);
    		
    		if($two1 !== null){
    		$cai = Db::table('ycl_goods')->where('cattwoid',$two1)->where('shopid',$rowset['id'])->select();
    	    $this->assign('cai',$cai);
    	
    		}else{
    			
    		$cai = Db::table('ycl_goods')->where('catoneid',$one1)->where('shopid',$rowset['id'])->select();	
    	    $this->assign('cai',$cai);
    	    }
    	     if($one1 == null && $two1 == null){
    	    	$cai = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
    	    	$this->assign('cai',$cai);
    	    }
    		$this->assign('one1',$one1);
    		$this->assign('shopid',$shopid);
    		$this->assign('shop',$shop);
    		$this->assign('gid',$gid);
    		$this->assign('id',$id);
//  		print_r($shop);
			return $this->fetch();
		}
		
		
	public function businesslocation(){ //商家评价
		$shop    = input('param.shopid'); //店铺ID
		$cgdh    = input('param.cgdh'); //采购单号
		$gid    = input('param.goodsid'); //商品id
		//$lun     = input('param.lun'); //评论筛选
//		print_r($lun);
		$rowset1 = Db::table('ycl_collect')->where('shop_id',$shop)->find(); //搜索收藏店铺
		$this->assign('rowset1',$rowset1);
		$im = Db::table('ycl_comment')->where('shop_id',$shop)->find();
		$userimg = Db::table('ycl_user')->where('id',$im['uid'])->find(); //搜索用户头像
//		print_r($userimg);die;
		$this->assign('userimg',$userimg);
		
		$di = Db::table('ycl_comment')->where('shop_id',$shop)->order('di')->select();//查看该店铺最低分
		$this->assign('di',$di);
			
		$xin = Db::table('ycl_comment')->where('shop_id',$shop)->order('add_time desc')->select();//查看该店铺最新评论
		$this->assign('xin',$xin);
		$img     = Db::table('ycl_comment')->where('pingimg','not null')->where('shop_id',$shop)->select();//查看该店铺带图片所有评论
		$num1 = count($img);
		$this->assign('img',$img);
		$this->assign('num1',$num1);
//		print_r($img);
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
		$time = date('H');
			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
				$kai = '营业中' ;
			}else{
				$kai = '已打烊' ;
			}
		$this->assign('kai',$kai);
		$con = Db::table('ycl_comment')->where('shop_id',$shop)->select();//查看该店铺所有评论
		$num = count($con); //评论数量
		$this->assign('num',$num);
//		print_r($num);
$this->assign('gid',$gid);
		$this->assign('cgdh',$cgdh);
		$this->assign('con',$con);
    	$this->assign('rowset',$rowset);
 		$this->assign('shop',$shop);
		return $this->fetch();
	}
	
	public function businessevaluation(){ //商家信息
		$cgdh    = input('param.cgdh'); //采购单号
		$this->assign('cgdh',$cgdh);
		$gid    = input('param.goodsid'); //商品id
		$this->assign('gid',$gid);
		$shop = input('param.shopid'); //店铺ID
		$rowset1 = Db::table('ycl_collect')->where('shop_id',$shop)->find(); //搜索收藏店铺
		$this->assign('rowset1',$rowset1);
		
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
    	$this->assign('rowset',$rowset);
    	$time = date('H');
//  	print_r($time);
			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
				$kai = '营业中' ;
			}else{
				$kai = '已打烊' ;
			}
		$this->assign('kai',$kai);
 		$this->assign('shop',$shop);
		return $this->fetch();
	}
	
	public function shoucang(){ //收藏保存
		$cang   = input('param.cang'); //商品id
		$shop   = input('param.shop'); //店铺id
//		print_r($shop);die;
		if($shop !== null){
		$shop_id  = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
		$data['uid']      = session('userid');  //用户ID
		$data['shop_id']  = $shop_id['id'];   //店铺ID
		$data['shopimg']  = $shop_id['shop_img']; //商品图片
		$data['add_time'] = time();			  //保存时间
		Db::table('ycl_collect')->insert($data); 
		
		return redirect('/index/ShoppurChase/businessdetail/id/'.$shop);
		}
//		 echo "<script type='text/javascript'>alert('测试');</script>";
	}
	
	
	
}
