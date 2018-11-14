<?php
namespace app\admin\controller;
use think\Controller;

use think\Request;
use think\Db;
class LoginController extends controller {
//	显示登录页面
	public function login () {
		return $this->fetch();
	}
//	后他登陆程序
	public function logingin (Request $request) {
		$username = $request->post('username');
		$password = $request->post('password');
		if($username == null) {
			$data['status'] = -1;
			$data['info'] = '用户名不能为空';
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		if($password == null) {
			$data['status'] = -2;
			$data['info'] = '密码不能为空';
			$msg = json_encode($data);
			echo $msg;
			return;
		}
		$row = Db::table('ycl_admin')->where('username',$username)->where('password',$password)->find();
		if($row) {
			session('username',$row['username']);
			session('username',$row['username']);
			session('password',$row['password']);
			$data['status'] = 1;
    			$data['info'] = "登录成功!";
    			$msg=json_encode($data);
    			echo $msg;
    			return; 
		} else {
			$data['status'] = -3;
			$data['info'] = '用户名或密码不正确';
			$msg = json_encode($data);
			echo $msg;
			return;
		}
	}
				
//	后台退出程序			
	public function logout(){
    	session('username',null);
    	session('password',null);
    	return $this->redirect(url('/admin/login/login'));
    }
}
