<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class WithdrawController extends controller {
	//	显示审核列表
	public function txsq() {
		$rowset = Db::table('ycl_withdraw')->where('is_sh',0)->select();
	        foreach ($rowset as $key=>$value){
	            $user = Db::table('ycl_user')->where('id',$value['uid'])->value('true_name');
	            $rowset[$key]['uid'] = $user;
            }
		$this->assign('rowset',$rowset);

		return $this->fetch();
	}
	
	
//	修改审核状态
	public function txsqtg() {
		$id = input('param.id');
		$pass = input('param.pass');
		if ($pass == 1) {
			$rowset = Db::table('ycl_withdraw')->where('id',$id)->setField('is_sh',1);
			return $this->redirect(url('/admin/withdraw/txsqlist'));
		} else {
			$rowset = Db::table('ycl_withdraw')->where('id',$id)->setField('is_sh',2);
			$row = Db::table('ycl_withdraw')->where('id',$id)->find();
			$uid = $row['uid'];
			$txmoney = $row['tx_money'];
			$query = Db::table('ycl_user')->where('id',$uid)->find();
			$xjmoney = $query['money'] + $txmoney;
			Db::table('ycl_user')->where('id',$uid)->setField('money',$xjmoney);
			return $this->redirect(url('/admin/withdraw/txsqlist'));
		}
		
	}
	
//	显示审核列表
	public function txsqlist() {
		$rowset = Db::table('ycl_withdraw')->select();
        foreach ($rowset as $key=>$value){
            $user = Db::table('ycl_user')->where('id',$value['uid'])->value('true_name');
            $rowset[$key]['uid'] = $user;
        }
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
//	删除餐企审核
	public function del() {
		$id = input('param.id');
		$rowset = Db::table('ycl_withdraw')->where('id',$id)->delete();
		$this->redirect(url('/admin/withdraw/txsqlist'));
	}
	
}
