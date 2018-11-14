<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Request;


class MoneyController extends Controller{
	
	//  我的余额
	public function money()
    {
    	$rowset = Db::table('ycl_user')->where('id',session('userid'))->find();
//    	$query = Db::table('ycl_order')->where('buy_id',$rowset['id'])->where('sales_return',1)->select();
        $query = Db::table('ycl_withdraw')->where('uid',session('userid'))->select();
    	$this->assign('query',$query);
    	$this->assign('rowset',$rowset);
		return $this->fetch();
    }
	
	//  余额提现
	public function putforward()
    {
        $true_name = Db::table('ycl_user')->where('id',session('userid'))->value('true_name');
        $this->assign('true_name',$true_name);
		return $this->fetch();
    }
    
    
    
	  // 提现审核
    public function txaudit()
    {
    	$username = input('post.username');
    	$yhkh     = input('post.yhkh');
    	$khh      = input('post.khh');
    	$txmoney  = input('post.txmoney');
    	$row = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$xj       = $row['money'] - $txmoney;
    	if($username == null) {
    		$data['status'] = -1;
			$data['info'] = "账户名不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
 
    	if($yhkh == null) {
    		$data['status'] = -3;
			$data['info'] = "银行卡号不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	$preg_bankcard='/^(\d{15}|\d{16}|\d{19})$/isu';
 		if(!preg_match($preg_bankcard,$yhkh)){
 			$data['status'] = -8;
			$data['info'] = "银行卡号,格式有误!";
			$msg = json_encode($data);
			echo $msg;
			return;
 		}
    	if($khh == null) {
    		$data['status'] = -5;
			$data['info'] = "开户行不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if($txmoney == null) {
    		$data['status'] = -6;
			$data['info'] = "提现金额不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
        if($txmoney > $row['money']) {
            $data['status'] = -9;
            $data['info'] = "余额不足!";
            $msg = json_encode($data);
            echo $msg;
            return;
        }
    	$arr = array(
    	'uid' => session('userid'),
    	'username' => $username,
    	'yhkh'     => $yhkh,
    	'khh'     => $khh,
    	'tx_money' => $txmoney,
    	'is_sh'	  => 0,
    	'add_time'=> time()
    	);
    	$query = Db::table('ycl_withdraw')->insert($arr);
    	if ($query) {
    		Db::table('ycl_user')->where('id',session('userid'))->setField('money',$xj);
    		$data['status'] = 1;
			$data['info'] = "提现申请成功";
			$msg = json_encode($data);
			echo $msg;
			return;
    	} else {
    		$data['status'] = -7;
			$data['info'] = "提现申请失败";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    }
}
