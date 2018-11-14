<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Request;

class MessageController extends Controller{
	public  function message(){ //消息
		return $this->fetch();
	}
	


}