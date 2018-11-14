<?php
namespace app\shop\controller;
use think\Controller;

use think\Db;
use think\Cookie;
use think\Request;
class CenterController extends Controller
{
//	商家中心
    public function merchantcenter()
    {
    	$shop = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
    	$goods = Db::table('ycl_goods')->where('shopid',$shop['id'])->select();
    	$order = Db::table('ycl_order')->where('shopid',$shop['id'])->where('shop_status',6)->select();
    	$count = count($goods);//商品数
    	$count1 = count($order);//订单数	
    	$sum = 0;
    	foreach ($order as $k=> $v) {
    		$sum += $v['total']; 
    	}
    	$this->assign('sum',$sum);
      	$this->assign('shop',$shop);
    	$this->assign('count',$count);
    	$this->assign('count1',$count1);
		return $this->fetch();
    }


	//设置页面
	public function setting() {
		return $this->fetch();
	}
	
	// 修改密码页面
    public function changepassword()
    {
		return $this->fetch();
    }
    //修改密码保存
    public function xgpassword(Request $request)
    {
    	$password = input('post.password');
//  	print_r($password);die;
		$newpass  = input('post.password1');
		$pass     = input('post.password2');
		$query    = Db::table('ycl_user')->where('id',session('userid'))->find();
				 if($query['password'] != null){
		 	
				if($password ==null){
					$data['status']=-1;
					$data['info']="请输入原密码";
					$msg=json_encode($data);
					echo $msg;
					return;
				}else{
			   if(md5($password) !== $query['password']){
			$data['status']=-2;
			$data['info']="原密码错误!";
			$msg=json_encode($data);
			echo $msg;
			return;
			}
		}
	}
//		if($password ==null){
//			$data['status']=-1;
//			$data['info']="请输入原密码";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		}
     
		$yzpass = preg_match('/^([a-zA-Z0-9]){6,16}$/', $newpass);
		if (!$yzpass) {
			$data['status']=-8;
			$data['info']="密码最少六位,最多16位!";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
                
            if($newpass==''){
			$data['status']=-3;
			$data['info']="新密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
            if($pass==''){
			$data['status']=-5;
			$data['info']="重复密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
            if($newpass !== $pass){
			$data['status']=-6;
			$data['info']="两次密码不一致";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		$res=Db::table('ycl_user')->where('id',session('userid'))->setField('password',md5($newpass));
            if($res){
            $data['status']=1;
			$data['info']="密码修改成功";
			$msg=json_encode($data);
			echo $msg;
			return;
            }else{
            $data['status']=-7;
			$data['info']="密码修改失败";
			$msg=json_encode($data);
			echo $msg;
			return;
            }
    	}
    //换绑手机号
    public function changephotonumber()
    {
    	$row = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$this->assign('row',$row);
		return $this->fetch();
    }
    
    public function hbphone()
    {
		$password = input('post.password');
		$phone = input('post.phone');
		$yzm = input('post.yzm');
		if ($password == null) {
			$data['status']=-1;
			$data['info']="登录密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		$rowset = Db::table('ycl_user')->where('id',session('userid'))->find();
		if(md5($password) !== $rowset['password']) {
			$data['status']=-2;
			$data['info']="登录密码错误";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		if ($phone == null) {
			$data['status']=-3;
			$data['info']="手机号不能为空";
			$msg=json_encode($data);
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
		if ($yzm == null) {
			$data['status']=-5;
			$data['info']="验证码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		
		$query = Db::table('ycl_user')->where('id',session('userid'))->setField('phone',$phone);
		if($query) {
			$data['status']=1;
			$data['info']="手机号绑定成功";
			$msg=json_encode($data);
			echo $msg;
			return;
		} else {
			$data['status']=-6;
			$data['info']="手机号绑定失败,请检查";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		
    }
      public function send(){
		/* $a=input('post.phone');
		print_r($a);
		die;  */
		$statusStr = array(
		"0" => "短信发送成功",
		"-1" => "参数不全",
		"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
		"30" => "密码错误",
		"40" => "账号不存在",
		"41" => "余额不足",
		"42" => "帐户已过期",
		"43" => "IP地址限制",
		"50" => "内容含有敏感词"
		);
		$yzm=rand(100000,999999);
		/* session('sendtime',time());
		session('code',$yzm);
		session('phonenum',$phone); */
                
		$smsapi = "http://api.smsbao.com/";
		$user = "hyl123456789"; //短信平台帐号
		$pass = md5("hyl123456"); //短信平台密码
		$content="【易菜篮】您的验证码为：" . $yzm . "。5分钟内输入有效。";//要发送的短信内容
		$phone = input('param.phone');//"*****";//要发送短信的手机号码
                session('code',$yzm); //验证码存入session
                session('phonenum',$phone); //手机号存入session
                session('sendtime',time());  //发送时间存入session
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		$result =file_get_contents($sendurl);
		
		//print_r(session('code'));die;
		
		//print_r(session('code'));die;
		
		if ($result==0){
			
			$data['status']=1;
			$data['info']="验证码发送成功！";
			$msg=json_encode($data);
			echo $msg;
			return;
		} else {
			$data['status']=0;
			$data['info']="验证码发送失败";
			$msg=json_encode($data);

			echo $msg;
			return;
		}  
		//echo $statusStr[$result];
	}
	
	
	public function orderweighing(){
        $orderid = input('orderid');
        $order_id = Db::table('ycl_order')->where('order_id',$orderid)->select();
        $count = count($order_id);
        $money = 0;
        foreach($order_id as $key=>$val){
         $goods =  Db::table('ycl_goods')->where('id',$val['goods_id'])->value('goodsname');
         $gg =  Db::table('ycl_spec')->where('id',$val['goodsgg'])->value('name');
         $order_id[$key]['goods_id'] = $goods;
         $order_id[$key]['goodsgg']  = $gg;
         $money = $val['money'];
        }
        $this->assign('order_id',$order_id);
        $this->assign('count',$count);
        $this->assign('money',$money);
//        print_r($order_id);die;
//		$temp=array(
//
//			'serialno'=>input('param.serialno'),
//			'weight'=>input('param.weight')
//		);
//		Db::table('weighttemp')->insert($temp);
//		die;
		$userinfo=Db::table('ycl_user')->where('id',session('userid'))->find();
		$chengno=$userinfo['serialno'];//取当前用户绑定的秤的序列号
		$this->assign('chengno',$chengno);
		return $this->fetch();

	}
	
	//接收接口app发送过来的序列号和称重数据方法
	public function getweight(){
		$t=array('serialno'=>input('param.serialno'),'weight'=>input('param.weight'));
		$serialno=input('param.serialno');
		$weight=input('param.weight');
		$res=Db::table('ycl_weighttemp')->where('serialno',$serialno)->find();
		if($res){
			Db::table('ycl_weighttemp')->where('serialno',$serialno)->update($t);
		}else{
			Db::table('ycl_weighttemp')->insert($t);
		}
		//cookie('sn',$serialno);
		//cookie('wt',$weight);
//		$t=array('serialno'=>cookie('sn'),'weight'=>cookie('wt'));
//		Db::table('ycl_weighttemp')->insert($t);
	}
	//前端ajax轮询获取称重数据调用方法
	public function ajaxget(){
		$ajaxsn=input('post.sn');
	//	if(cookie('sn')==$ajaxsn){
		//	$t=array('serialno'=>Cookie::get('sn'),'weight'=>Cookie::get('wt'));
		//	Db::table('ycl_weighttemp')->insert($t);
			$cheng=Db::table('ycl_weighttemp')->where('serialno',$ajaxsn)->find();
			if($cheng){
				$zl=json_encode($cheng['weight']);//将cookie中的重量数据编码返回到前端调用页面ajax
				echo $zl;
				return;
			}
	//	}
	}

	public function orderweighing1(){
		return $this->fetch();
	}
	
	
}
