<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;

class DataController extends Controller{
	public function data(){ //数据统计
		$year  = date("Y");
		$month = date("m");
		$day   = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
		$end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳
		$rowset  = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->select();
		//$rowset1 = Db::table('ycl_order')->where('order_status',4)->find();
		$num   = 0;
		$count = 0;

		$count = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('complate_time','>=',$start)->count();
		$num   = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('complate_time','>=',$start)->sum('money');
//		print_r($num);die;
		$this->assign('count',$count);
		$this->assign('num',$num);
		
		
		$yc = mktime(0,0,0,date('m'),1,date('Y'));
		$num1 	= 0;
		$count1 = 0;
		
		$count1 = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('complate_time','>=',$yc)->count();
		$num1   = Db::table('ycl_order')->where('buy_id',session('userid'))->where('order_status',8)->where('complate_time','>=',$yc)->sum('money');
//		print_r($num1);die;
		$this->assign('count1',$count1);
		$this->assign('num1',$num1);
		return $this->fetch();
	}


}
