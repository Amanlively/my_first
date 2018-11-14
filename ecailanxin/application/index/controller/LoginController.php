<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
//include_once EXTEND_PATH.'/aliyun-dysms-php-sdk/api_demo/SmsDemo.php';
Class LoginController extends Controller
{
	public function login(){
		return $this->fetch();
	}
	
	public function loginverify(){
		return $this->fetch();
	}
	
	public function logingin(Request $request){//账号密码登录
	    $phone    = $request->post('phone');
		$password = $request->post('password');
		$GPScity  = $request->post('GPScity');
		if ($phone == null) {
			$this->error('手机号不能为空!');
		}
		
		if ($password == null) {
			$this->error('密码不能为空!');
		}
    	$qer = Db::table('ycl_user')->where('phone',$phone)->find();
		if($phone !== $qer['phone'] || md5($password) !== $qer['password']){
    		$this->error('手机号或密码不正确!');
    	}

//		print_r($qer);die;
    	if($qer){
//  		print_r($qer);
    			if($qer['password'] == md5($password) && $qer['register_type'] == 1 && $qer['is_sh'] == 1){
                    cookie('userid',$qer['id']);
                    session('city',$GPScity);
                    cookie('city',$GPScity);
    			session('phone',$phone);
    			session('username',$qer['username']);
				session('userid',$qer['id']);
					$this->success('登录成功!','/index/index/index/city/'.$GPScity);
				}else{
					 if($qer['password'] == md5($password) && $qer['register_type'] == 2 && $qer['is_sh'] == 1){
				session('phone',$phone);
				session('username',$qer['username']);
				session('userid',$qer['id']);
				$this->success('登录成功!','/shop/myshop/myshop');
				}else{
					if($qer['password'] == md5($password) && $qer['register_type'] == 3 && $qer['is_sh'] == 1){
				session('phone',$phone);
				cookie('phone',$phone);
				session('username',$qer['username']);
				cookie('username',$qer['username']);
				session('userid',$qer['id']);
				session('city',$GPScity);
				cookie('userid',$qer['id']);
					$this->success('登录成功!','/courier/mycenter/mycenter');
				}else{
					$this->error('审核中!');
					
			}
		}
	}

    	}else{
    	$this->error('没有该用户!');
    	}
    	
	}
	
	  public function yzmlogin(Request $request) {//手机验证码登录
    	$phone = $request->post('phone');
    	$yzm = $request->post('yzm');
    	$GPScity  = $request->post('GPScity1');
    	if ($phone == null) {
			$data["status"] =  "-1";
			$data["info"] =  "手机号不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		if ($yzm == null) {
			$data['status'] =  -2;
			$data['info'] =  "验证码不能为空!";
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		$rowset = Db::table('ycl_user')->where('phone',$phone)->find();
		
		if ($rowset) {
			if($rowset['register_type'] == 1 && $rowset['is_sh'] == 1){
		    		session('userid',$rowset['id']);
					session('phone',$rowset['phone']);
					session('username',$rowset['username']);
					$data['status'] = 1;
					$data['info'] = "登录成功!";
					$data['city'] = $GPScity;
					$msg = json_encode($data);
					echo $msg;
					return;
//				$this->success('登录成功!','/index/index/index');
				}else{
			if($rowset['register_type'] == 2 && $rowset['is_sh'] == 1){
				session('userid',$rowset['id']);
				session('phone',$rowset['phone']);
				session('username',$rowset['username']);
				$data['status'] = 2;
				$data['info'] = "登录成功!";
				$msg = json_encode($data);
				echo $msg;
				return;
//				$this->success('登录成功!','/shop/myshop/myshop');
				}else{
					
			if($rowset['register_type'] == 3 && $rowset['is_sh'] == 1){
					session('userid',$rowset['id']);
					session('phone',$rowset['phone']);
					session('username',$rowset['username']);
//					$this->success('登录成功!','/courier/mycenter/mycenter');
					$data['status'] = 3;
					$data['info'] = "登录成功!";
					$msg = json_encode($data);
					echo $msg;
					return;
			}else {
//			session('userid',$rowset['id']);
//			session('phone',$rowset['phone']);
//			session('username',$rowset['username']);
//			$data['status'] = 1;
//			$data['info'] = "登录成功!";
//			$msg = json_encode($data);
//			echo $msg;
//			return;
			$data['status'] =  -3;
			$data['info'] =  "审核中!";
			$msg = json_encode($data);
			echo $msg;
			return;
	    	}		
		}
    }
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
	public function logout(){
		session('username',null);
    	session('userid',null);
		return $this->redirect('/index/login/login');
	}



	public  function sendCode(){   //阿里云短信
	    $phone = '123456';
	    $code = '789789';
       // $aliyun      = new SmsDemo();
//        print_r($aliyun);die;
        
    }











}
