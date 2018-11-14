<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;

Class RegisterController extends Controller
{
	public function register(){
		$type = input('param.type');
		$this->assign('type',$type);
		return $this->fetch();
	}
	
	public function choiceregister(){
		return $this->fetch();
	}
	
//	public function storemanagement(){
//		return $this->fetch();
//	}
	
//	public function save(Request $request){
//		$phone    = input('post.phone');
//		$ty       = input('param.ty');
////		print_r($type);die;
//		$password = input('post.password');
//		$tjtime   = time();
////	    $nowsj=time();//点注册按钮的时间
////      $Sphone=session('phonenum');//session中保存的获取验证码的手机号。
////      $Scode=session('code');//session中保存的验证码
////      $Stime=session('sendtime');//session中保存的验证码的发送时间。
////		$reg ='/^(13[0-9]|15[012356789]|18[0-9]|17[678]|14[57])[0-9]{8}$/';
//			if(!preg_match('/^(13[0-9]|15[012356789]|18[0-9]|17[678]|14[57])[0-9]{8}$/',$phone)){
//			$data['status']=-5;
//			$data['info']="手机号格式不对";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		    }
//		if($phone == null) { 
//			$data['status']=-1;
//			$data['info']="手机号不能为空";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		}
//		if($password == null) { 
//			$data['status']=-2;
//			$data['info']="密码不能为空";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		}
//		if(strlen($password) < 6){
//			$data['status']=-7;
//			$data['info']="密码最少6位";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//			}
//			$reg1 = '/^[0-9a-zA-Z]{6,12}$/';
//		if(!preg_match($reg1,$password)){
//			$data['status']=-8;
//			$data['info']="密码只能由数字字母组成密码最多12位";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//			}
//		$info = Db::table('ycl_user')->where('phone',$phone)->find();
//		
//		if(!$info){
//			$qer = array(
//			'phone' => $phone,
//			'password' => md5($password),
//			'add_time' => $tjtime,
//			'register_type' => $ty
//			);
//			$query = Db::table('ycl_user')->insert($qer);
//			if($query){
//				
//				$data['status']=1;
//				$data['info']="注册成功!";
//				$msg=json_encode($data);
//				echo $msg;
//				return;
//			}else{
//				$data['status']=-3;
//				$data['info']="注册失败,请检查!";
//				$msg=json_encode($data);
//				echo $msg;
//				return;	
//			}
//		}else{
//			$data['status']=-4;
//			$data['info']="手机号码注册过！";
//			$msg=json_encode($data);
//			echo $msg;
//			return;
//		}
//		
//	}
	
//  餐企申请页面
    public function storemanagement() {
    	$type = input('param.type');
    	$this->assign('type',$type);
    	return $this->fetch();
    }
//  餐企申请保存
    public function  save(Request $request) {
    $type         = input('param.type');
	$mdname	      =  $request->post('mdname');
	$address      =  $request->post('address');
	$managername  = $request->post('managername');
	$managerphone = $request->post('managerphone');
	if ($mdname == null) {
		$data['status'] =  -1;
		$data['info'] =  "门店名称不能为空!";
		$msg = json_encode($data);
		echo $msg;
		return;
	}
	if ($address == null) {
		$data['status'] =  -2;
		$data['info'] =  "门店地址不能为空!";
		$msg = json_encode($data);
		echo $msg;
		return;
	}
	if ($managername == null) {
		$data['status'] = -3;
		$data['info'] =  "门店联系人不能为空!";
		$msg = json_encode($data);
		echo $msg;
		return;
	}
	if ($managerphone == null) {
		$data['status'] =  -6;
		$data['info'] = "门店联系人电话不能为空!";
		$msg = json_encode($data);
		echo $msg;
		return;
	}
	$reg = array(
	'cqname' => $mdname,
	'address' => $address,
	'contract_name' => $managername,
	'phone' => $managerphone,
	'add_time' => time(),
	'register_type' => $type,
	'is_sh' => 0
	);
	
		//	$rowset = Db::table('ycl_user')->where('variable',0)->find();

		$query = Db::table('ycl_user')->insert($reg);
		$work_id = Db::table('ycl_user')->order('id desc')->limit(1)->value('id');
		$query = Db::table('ycl_user')->where('id',$work_id)->update(['work_id' => $work_id]);
		
		$arr = [
			'js_name' => '总管事',
			'group_id' => $work_id,
			'uid'    => $work_id,
			'content' => '老板',
			'addtime' => time()
		];
		
		Db::table('ycl_role')->insert($arr);
	
    if ($query) {
    	$data['status'] =  1;
		$data['info'] =  "提交成功!";
		$msg = json_encode($data);
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
            session('code',$yzm);
            session('phonenum',$phone);
            session('sendtime',time());
	$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
	$result =file_get_contents($sendurl) ;
	
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
