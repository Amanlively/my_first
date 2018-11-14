<?php
namespace app\shop\controller;
use think\Controller;

use think\Db;
use think\Request;
class DataController extends Controller
{
//	数据展示
    public function indexzs()
    {
    	if(session('userid') == null) {
		return $this->redirect(url('/index/login/login'));
		} else {
			$year = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
//		print_r($start);die;
		$end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳
//  	$rowset = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$query = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	$shop = $query['id'];
    	$row = Db::table('ycl_order')->where('shopid',$query['id'])->where('shop_status',6)->select();
//    	  	print_r($row);
    	$count1 = count($row); // 订单总量
    	$count = 0;
    	$num = 0;
    	$sum = 0;
    	foreach ($row as $k=>$v) {
            $num += $v['total'];
            if ($v['complate_time'] >= $start) {
                $sum += $v['total']; //今日收入
                $count = count($row); //今日订单
//                $goodssum += $v['good_num'];
//  			print_r($sum);die;
            }

//    		if (($v['complate_time'] >= $start) && ($v['complate_time'] <= $end)) {
//    			$num += $v['total']; //今日收入
//    			$count = count($v); //今日订单
//    		}
//    		$sum += $v['total'];
    	}
    	$this->assign('num',$num);
    	$this->assign('sum',$sum);
    	$this->assign('count1',$count1);
    	$this->assign('count',$count);
    	$this->assign('shop',$shop);
		}
    	
		return $this->fetch();
    }
    
//  订单销售展示
	public function indexzslist()
    {
    	$shop = input('param.shop');
    	$row = Db::table('ycl_order')->where('shopid',$shop)->select();
    	foreach ($row as $k => $v) {
    		$query = Db::table('ycl_goods')->where('id',$v['goods_id'])->find();
    		$rowset = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
    		$row[$k]['goods_id'] = $query['goodsname'];
    		$row[$k]['goodsgg'] = $rowset['name'];
    	}
    	$this->assign('row',$row);
		return $this->fetch();
    }
     
}
