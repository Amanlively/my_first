<?php
namespace app\courier\Controller;
use think\Controller;
use think\Request;
use think\Db;
class MycenterController extends Controller{
	//任务单
    public function mycenter()
    {
    	$year = date("Y");
		$month = date("m");
		$day = date("d");
		$start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
//		print_r($start);die;
		$end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳
    	$rowset = Db::table('ycl_user')->where('id',session('userid'))->find();
//  	print_r($rowset);
    	$this->assign('rowset',$rowset);
    	$query = Db::table('ycl_order')->where('rider_id',$rowset['id'])->select();
    	$count = count($query); //订单数量
    	$sum = 0;  //总收入
    	$num = 0; //今日收入
    	foreach ($query as $k=>$v) {
    		$sum += $v['inmong'];
    		if ($v['complate_time'] >= $start && $v['complate_time'] <= $end) {
    			$num += $v['inmong'];
    		}
    	}
    	$this->assign('count',$count);
    	$this->assign('sum',$sum);
    	$this->assign('num',$num);
		return $this->fetch();
    }
    //设置页面
    public function setting () {
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
                
        if($newpass==''){
			$data['status']=-3;
			$data['info']="新密码不能为空";
			$msg=json_encode($data);
			echo $msg;
			return;
		}
		$yzpass = preg_match('/^([a-zA-Z0-9]){6,16}$/', $newpass);
		if (!$yzpass) {
			$data['status']=-8;
			$data['info']="密码最少六位,最多16位!";
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
    //骑手设置
    public function missionsetting() {
    	$user = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$this->assign('user',$user);
    	return $this->fetch();
    }
    
    //骑手设置保存
    public function missionsave(Request $request) {
    	$username = input('param.name');
//  	print_r($username);die;
    	$phone    = input('param.phone');
    	if ($request->has ( 'image', 'file' )) {
			// think\File
			// 上传文件的信息
			$file = $request->file ( 'image' );
//			var_dump($file);die;
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/missionimg' );
			$data['image'] = $uploadFile->getSaveName ();
		   }
		  
		    $data['username'] = $username;
		    $data['phone']    = $phone;
		   
//		    print_r($arr);die;
    		$query = Db::table('ycl_user')->where('id',session('userid'))->update($data);
    		if ($query) {
    			$this->redirect('/courier/mycenter/missionsetting');
    		}
    }
    
    //我的钱包
    public function missionpurse() {
    	$row = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$num = $row['money'];
    	$this->assign('num',$num);
    	$query = Db::table('ycl_withdraw')->where('uid',session('userid'))->select();
    	$this->assign('query',$query);
    	return $this->fetch();
    }
     
    //  提现申请
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
//    	print_r($username);die;
    	$yhkh = input('post.yhkh');
    	$khh = input('post.khh');
    	$txmoney = input('post.txmoney');
    	$row = Db::table('ycl_user')->where('id',session('userid'))->find();
    	$xj = $row['money'] - $txmoney;
    	if($username == null) {
    		$data['status'] = -1;
			$data['info'] = "账户名不能为空";
			$msg = json_encode($data);
			echo $msg;
			return;
    	}
    	if($username !== $row['true_name']) {
    		$data['status'] = -2;
			$data['info'] = "账户名有误";
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
	
	public function missionmessage(){ //骑手消息
		return $this->fetch();
	}
	
	
	
}
