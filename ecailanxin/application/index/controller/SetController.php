<?php
namespace app\index\controller;
use think\Controller;

use think\Db;
use think\Request;
class SetController extends Controller
{
//	个人中心设置
    public function setting()
    {
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
//  	print_r($password);
		$newpass  = input('post.password1');
		$pass     = input('post.password2');
		$yzpass = preg_match('/^([a-zA-Z0-9]){6,16}$/', $newpass);
		
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
		   
            if($newpass==null){
			$data['status']=-3;
			$data['info']="新密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		    }
		    
            if($pass==null){
			$data['status']=-5;
			$data['info']="重复密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		   }
		   
		if (!$yzpass) {
			$data['status']=-8;
			$data['info']="密码格式不正确!";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		
		if ($newpass < 6) {
			$data['status']=-9;
			$data['info']="密码最少六位,最多16位!";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		
//		$query    = Db::table('ycl_user')->where('id',session('userid'))->find();
//      if(md5($password) !== $query['password']){
//			$data['status']=-2;
//			$data['info']="原密码错误!";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		}
                
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
		if ($phone == null) {
			$data['status']=-3;
			$data['info']="手机号不能为空";
			$msg=json_encode($data);
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
		if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -9;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
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
    
     // 门店地址
     public function deliveryinformation()
    {
    	$status = input('param.status');
//  	print_r($status);die;
    	$open = input('param.open');
    	if ($status == 1) {
    		if ($open == 1) {
    			$row = Db::table('ycl_address')->where('uid',session('userid'))->setField('is_mr',1);
    			if ($row) {
    				return $this->redirect(url('/index/set/deliveryInformation/open/1' . '/status/1'));
    			}
    		} else {
    			$row = Db::table('ycl_address')->where('uid',session('userid'))->setField('is_mr',0);
    			if ($row) {
    				return $this->redirect(url('/index/set/deliveryInformation/open/0' . '/status/1'));
    			}
    		}
    	}
    	$rowset = Db::table('ycl_address')->where('uid',session('userid'))->select();
    	$mdid = session('userid');
    	$this->assign('mdid',$mdid);
    	$this->assign('rowset',$rowset);
		return $this->fetch();
    }
//public function deliveryinformation(){
//		//$row = Db::table('ycl_address')->where('uid',session('userid'))->setField('is_mr');
//		return $this->fetch();
//}
     
    // 门店地址删除
     public function messagedel()
    {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$rowset = Db::table('ycl_address')->where('id',$id)->delete();
    	return $this->redirect(url('/index/set/deliveryInformation/mdid/' . $mdid));
    }
    
    // 地址修改
     public function addressxg()
    {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$rowset = Db::table('ycl_address')->where('id',$id)->find();
    	$this->assign('rowset',$rowset);
    	$this->assign('mdid',$mdid);
    	return $this->fetch();
    }
    //地址修改保存
    public function addressxgsave() {
    	$mdid = input('param.mdid');
    	$id = input('param.id');
    	$consignee = input('post.consignee');
    	$phone = input('post.phone');
    	$region = input('post.region');
    	$street = input('post.street');
    	$details = input('post.details');
    	if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -9;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
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
    	
    	$arr = array(
            'uid' => session('userid'),
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
    
    // 地址添加
     public function addaddress()
    {
    	$mdid = input('param.mdid');
    	$this->assign('mdid',$mdid);
    	return $this->fetch();
    }
    //添加地址保存
     public function addressbc() {
    	$mdid = input('param.mdid');
    	$consignee = input('post.consignee');
    	$phone = input('post.phone');
    	$region = input('post.region');
    	$street = input('post.street');
    	$details = input('post.details');
    	if(!preg_match("/^1[345678]{1}\d{9}$/",$phone)){
		    $data['status'] = -9;
			$data['info'] = "手机号,格式不正确";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
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
    	
    	$arr = array(
            'uid' => session('userid'),
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
    
    //  发送手机验证码方法
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
		$content="【399合伙人】您的验证码为：" . $yzm . "。5分钟内输入有效。";//要发送的短信内容
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
    
}
