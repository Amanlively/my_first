<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;
Class CompanydataController extends Controller
{
	public  function businessdetail(){ //店铺详情
//		if(session('userid') == null || session('phone') == null){
//			return $this->redirect('/index/login/login');
//		}
			
		
			$shop = input('param.id'); //店铺ID
			$one1 = input('param.one'); //接收一级分类过来的ID
    		$two1 = input('param.two'); //接收二级分类过来的ID
			$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); //搜索店铺表
			cookie('pei',$rowset['delivery']);
			
			$rowset1 = Db::table('ycl_collect')->where('uid',session('userid'))->where('shop_id',$shop)->find(); //搜索店铺
			$xinarray = cookie('xinarray');
			$zong = cookie('t1');
//			print_r($xinarray);
			$this->assign('zong',$zong);
			$this->assign('xinarray',$xinarray);
			$this->assign('rowset1',$rowset1);
			$time = date('H');
//			print_r($time);die;
    	    $this->assign('rowset',$rowset);
 		
  			$one = Db::table('ycl_category_one')->select();//查询一级分类表
    		$this->assign('one',$one);
    		
    		$two = Db::table('ycl_category_two')->where('up_catid',$one1)->select(); //查询二级分类表
    		$this->assign('two',$two);
    		
    		if($two1 !== null){
    		$cai = Db::table('ycl_goods')->where('cattwoid',$two1)->where('shopid',$rowset['id'])->select();
    	    $this->assign('cai',$cai);
    	
    		}else{
    		$cai = Db::table('ycl_goods')->where('catoneid',$one1)->where('shopid',$rowset['id'])->select();	
//  		$cai = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
    	    $this->assign('cai',$cai);
    	    }
    	     if($one1 == null && $two1 == null){
    	    	$cai = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
    	    	$this->assign('cai',$cai);
    	    }
    		$this->assign('one1',$one1);
    		$this->assign('shop',$shop);
    		
			return $this->fetch();
		}
		
		
	public function postevaluation(){ //商家评价
		$shop   = input('param.id'); //店铺ID
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
//		print_r($rowset);die;
    	$this->assign('rowset',$rowset);
 		$this->assign('shop',$shop);
		return $this->fetch();
	}
	
	public function reviewsave(Request $request){ //商家评价保存
		$shop    = input('param.id'); //店铺ID
		$content = input('param.content'); //评论
		
		$rowset  = Db::table('ycl_shop_info')->where('id',$shop)->find();
		
		
		$jie  = Db::table('ycl_user')->find();
		$data['uid']        = session('userid');//评论的用户
		$data['shop_id']    = $shop; //店铺ID
		$data['username']   = session('username');//用户昵称
		$data['user_img']   = $jie['image'];//用户头像
		$data['content']    = $request->post('content');//评论内容
		$data['add_time']   = time();
		
		if ($request->has ( 'file', 'file' )) {
			// think\File
			// 上传文件的信息
		$file = $request->file ( 'file' );
			// 成功上传的文件信息
		$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/ping_img' );
		$data ['pingimg'] = $uploadFile->getSaveName ();
		}
//		print_r($data);die;
		$row = Db::table('ycl_comment')->insert($data);
    	$this->assign('rowset',$rowset);
 		$this->assign('shop',$shop);
		return $this->redirect('/index/center/center');
	}
		public function businesslocation(){ //商家评价
		$shop    = input('param.id'); //店铺ID
		//$lun     = input('param.lun'); //评论筛选
//		print_r($lun);
		$rowset1 = Db::table('ycl_collect')->where('shop_id',$shop)->find(); //搜索收藏店铺
		$this->assign('rowset1',$rowset1);
		$im = Db::table('ycl_comment')->where('shop_id',$shop)->find();
		$userimg = Db::table('ycl_user')->where('id',$im['uid'])->find(); //搜索用户头像
//		print_r($userimg);die;
		$this->assign('userimg',$userimg);
		
		$di = Db::table('ycl_comment')->where('shop_id',$shop)->order('di')->select();//查看该店铺最低分
		$this->assign('di',$di);
			
		$xin = Db::table('ycl_comment')->where('shop_id',$shop)->order('add_time desc')->select();//查看该店铺最新评论
		$this->assign('xin',$xin);
		$img     = Db::table('ycl_comment')->where('pingimg','not null')->where('shop_id',$shop)->select();//查看该店铺带图片所有评论
		$num1 = count($img);
		$this->assign('img',$img);
		$this->assign('num1',$num1);
//		print_r($img);
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
		$time = date('H');
//			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
//				$kai = '营业中' ;
//			}else{
//				$kai = '已打烊' ;
//			}
//		$this->assign('kai',$kai);
		$con = Db::table('ycl_comment')->where('shop_id',$shop)->select();//查看该店铺所有评论
		$num = count($con); //评论数量
		$this->assign('num',$num);
//		print_r($num);
		$this->assign('con',$con);
    	$this->assign('rowset',$rowset);
 		$this->assign('shop',$shop);
		return $this->fetch();
	}
	
	public function businessevaluation(){ //商家信息
		$shop = input('param.id'); //店铺ID
		$rowset1 = Db::table('ycl_collect')->where('shop_id',$shop)->find(); //搜索收藏店铺
		$this->assign('rowset1',$rowset1);
		
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
    	$this->assign('rowset',$rowset);
    	$time = date('H');
//  	print_r($time);
			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
				$kai = '营业中' ;
			}else{
				$kai = '已打烊' ;
			}
		$this->assign('kai',$kai);
 		$this->assign('shop',$shop);
		return $this->fetch();
	}
	
	public function shoucang(){ //收藏保存
		if(session('userid') == null || session('phone') == null){
			return $this->redirect('/index/login/login');
		}
		$cang   = input('param.cang'); //商品id
		$shop   = input('param.shop'); //店铺id
//		print_r($shop);die;
		if($cang !== null){
		$goods  = Db::table('ycl_goods')->where('id',$cang)->find(); 
		$rowset['uid']      = session('userid');  //用户ID
		//$rowset['shop_id']  = $goods['shopid'];   //店铺ID
		$rowset['goods_id'] = $goods['id'];		  //商品ID
		$rowset['goodsimg'] = $goods['goodspic']; //商品图片
		$rowset['add_time'] = time();			  //保存时间
		Db::table('ycl_collect')->insert($rowset); 
		
		return redirect('/index/index/details/id/'.$cang);
		}
		
		if($shop !== null){
		$shop_id  = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
		$data['uid']      = session('userid');  //用户ID
		$data['shop_id']  = $shop_id['id'];   //店铺ID
		$data['shopimg']  = $shop_id['shop_img']; //商品图片
		$data['add_time'] = time();			  //保存时间
		Db::table('ycl_collect')->insert($data); 
		
		return redirect('/index/companydata/businessdetail/id/'.$shop);
		}
//		 echo "<script type='text/javascript'>alert('测试');</script>";
	}
	
	public function delete(){ //取消商品页面收藏
		if(session('userid') == null || session('phone') == null){
			return $this->redirect('/index/login/login');
		}
		$goods   = input('param.shan'); //商品id
		
		Db::table('ycl_collect')->where('goods_id',$goods)->delete(); 
		return redirect('/index/index/details/id/'.$goods);
 
	}
	
	public function delete2(){ //取消我的里面商品收藏
		$goods   = input('param.id'); //商品id
		
		Db::table('ycl_collect')->where('uid',session('userid'))->where('goods_id',$goods)->delete(); 
		return redirect('/index/star/star');
 
	}
	
	public function delete1(){ //取消店铺收藏
		$shop   = input('param.id'); //店铺id
		
		Db::table('ycl_collect')->where('uid',session('userid'))->where('shop_id',$shop)->delete(); 
		return redirect('/index/star/star');
 
	}
		
	public function save9(){
		if(session('userid') == null || session('phone') == null){
			return $this->success('请您先登录','/index/login/login');
		}
		$cgdh   = "CGDH".time().rand(100000,999999);
		$saveall = $_POST['saveall'];
		if(empty($saveall)){
			return  '空空空';
		}
		$data = [];
		$arr = explode('&',$saveall);
		$i = 1;
		$a = 0;
		foreach($arr as $arr_k => $arr_v){
			$brr = explode('=',$arr_v);
			if($i % 5 != 0){
				$data[$a][$brr[0]] =  $brr[1];	
			}else{
				$data[$a][$brr[0]] =  $brr[1];	
				$a++;
			}
			$i++;
		}
			$cgd = Db::table('ycl_purchase')->where('uid',session('userid'))->where('pron',1)->value('cgdh');
//		print_r($cgd);die;
    			if(!empty($cgd)){
    				$cgdh = $cgd;
    			}
		foreach($data as $data_k => $data_v){
			$group = Db::table('ycl_purchase')->where('uid',session('userid'))->where('goods_id',$data_v['goodsid'])->where('shop_id',$data_v['shopid'])->where('status',0)->find();
			if($group){
				$up['number'] = $group['number']    + $data_v['count'];
    			$up['money']  = $up['number'] * $data_v['thisprice'];
//  			print_r($up);die;
    			$row = Db::table('ycl_purchase')->where('id',$group['id'])->update($up);
			}else{
				
			$mon = $data_v['count'] * $data_v['thisprice'];
//			print_r($data);die;
			$array = array(
						'uid' 		 => session('userid'),
						'goodsname'  => urldecode($data_v['thisname']),
						'goodsmoney' => $data_v['thisprice'],
						'money'		 => $mon,
						'number'	 => $data_v['count'],
						'cgdh'		 => $cgdh,
						'add_time'	 => time(),
						'shop_id'	 => $data_v['shopid'],
						'goods_id'   => $data_v['goodsid'],
						'pron'   => 1
				);
//				print_r($data);die;
//				
				$row = Db::table('ycl_purchase')->insert($array);
			}
		}						
			if($row){
				$this->success('已添加到我淘的菜!','/index/companydata/businessdetail/id/'.$data_v['shopid']);
		  }
	}

//
//    public function postPay($order1 = []){
//
//        import('WxPayAPI.lib.WxPayDataBase', EXTEND_PATH);
////        import('WxPayAPI.lib.WxPay', EXTEND_PATH,'.JsApiPay.php');
////        $openids = new \JsApiPay();
////        $openid = $openids->GetOpenid();
//        $order1['amount'] = 50;
//        $result    = [];
//        $fullTitle =   '商城消费' . $order1['amount']. '元';
//        $transNo       = WxPay::genOrderNo('trans');             //调用生成商户订单号方法
////        dump($transNo); die;
//        $amount    = $order1['amount'];
//
//        //微信支付
//        $Order     = new \WxPayUnifiedOrder();
//        $NativePay = new \WxPayDataBase();
//        $Order->SetBody($fullTitle);              //商品简单描述
//        $Order->SetDetail($fullTitle);            //商品详细描述，对于使用单品优惠的商户
//        $Order->SetAttach($fullTitle);            //附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用。
//        $Order->SetOut_trade_no($transNo);
//        //商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|* 且在同一个商户号下唯一。
//        $weixinAmount = $amount * 100;
//        $Order->SetTotal_fee($weixinAmount);      //订单总金额，单位为分
//        $Order->SetTime_start(date("YmdHis"));    //订单生成时间
//        $Order->SetTime_expire(date("YmdHis", time() + 60 * 30));     //订单失效时间
//        $Order->SetGoods_tag($fullTitle);          //订单优惠标记，使用代金券或立减优惠功能时需要的参数
//        $Order->SetNotify_url('');
//        //异步接收微信支付结果通知的回调地址
//        $Order->SetTrade_type("MWEB");             //JSAPI 公众号支付  NATIVE 扫码支付   APP APP支付
////        $Order->SetOpenid($openid);                 //用户标识
//        $order_pay = $NativePay->GetPayUrl($Order); //调动统一下单
//        if (($order_pay['return_code'] == 'SUCCESS') && ($order_pay['result_code'] == 'SUCCESS')) {
//            return $order_pay;
//        } else {
//            return '微信创建预付单失败, ' . $order_pay['return_msg'];
//        }
//        return $result;
//    }


    public function pay()
    {
        $headers = array();
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3';
        $headers[] = 'Accept-Encoding: gzip, deflate';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0';
        $money = 1;//充值金额
        $userip = $_SERVER["REMOTE_ADDR"]; //获得用户设备IP
        $appid = "wxa26ff762844df223";//微信给的
        $mch_id = "1405390402";//微信官方的
        $key = "18wkazYlpfx5V1UCKvzKV62sM5f4A6kH";//自己设置的微信商家key

        $rand = rand(00000, 99999);
        $out_trade_no = date('YmdHis', time()) . $rand;//平台内部订单号
        $nonce_str = MD5($out_trade_no);//随机字符串
        $body = "H5充值";//内容
        $total_fee = $money; //金额
        $spbill_create_ip = $userip; //IP
        $notify_url = ""; //回调地址(支付完成之后微信会将结果参数带入这个方法) 这个根据自己逻辑需求填写
        $trade_type = 'MWEB';//交易类型 具体看API 里面有详细介绍
        $scene_info = '{"h5_info":{"type":"Wap","wap_url":"http://www.baidu.com","wap_name":"支付"}}';//场景信息 必要参数
        $signA = "appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";

        $strSignTmp = $signA . "&key=$key"; //拼接字符串 注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML 是否正确
        $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写

        $post_data = "<xml><appid>$appid</appid><body>$body</body><mch_id>$mch_id</mch_id><nonce_str>$nonce_str</nonce_str><notify_url>$notify_url</notify_url><out_trade_no>$out_trade_no</out_trade_no><scene_info>$scene_info</scene_info><spbill_create_ip>$spbill_create_ip</spbill_create_ip><total_fee>$total_fee</total_fee><trade_type>$trade_type</trade_type><sign>$sign</sign>
        </xml>";//拼接成XML格式

        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信下单接口

        $dataxml = self::http_post($url, $post_data, $headers);//传参调用curl请求
        $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组

        dump($objectxml);die;
//        if($objectxml['return_code'] == 'SUCCESS'){
//            　　$mweb_url= $objectxml['mweb_url'];
//        }
    }

    function http_post($url='',$post_data=array(),$header=array(),$timeout=30) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


    public function postZfbPay(){

        header('Content-type:text/html; Charset=utf-8');
        /*** 请填写以下配置信息 ***/
        $appid = '2016091800539227';  //https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
        $returnUrl = 'http://www.xxx.com/alipay/return.php';     //付款成功后的同步回调地址
        $notifyUrl = 'http://www.xxx.com/alipay/notify.php';     //付款成功后的异步回调地址
        $outTradeNo = uniqid();     //你自己的商品订单号
        $payAmount = 0.01;          //付款金额，单位:元
        $orderName = '支付测试';    //订单标题
        $signType = 'RSA2';			//签名算法类型，支持RSA2和RSA，推荐使用RSA2
        $rsaPrivateKey='MIIEpQIBAAKCAQEApeUGNhd/MU8Fv8wgnMoD44s2Y0+h4gIeqoSsLz4DxlfhnE1QodiohQVgG6n3xR7sdYwXo1oUwmflHMX3MiQ5mkpN/lJ+AdgdmbB3Fr6OUtYY7ldgKmkokXkHZ5B38FwTm5SDk03nNldCTYRKRPMkgi51dwxESmtKPy4cObAojsIumtG9KD51tmHLj/VAMSBzvacpCEdqSnMT0KnrwcahmtloKcYmpdP01Xs57mzrGEfvXtPJEwlOkYhiqzWv/QBvIIE0rDmCLdGc192N5Ec+VrY8JOf1inkil/4DtLcMltF6lwbOFVab1uCnPnfgr+53AgUPXlOPYGDKNI6fFyMdFQIDAQABAoIBADRyPk91iDmfgPLM5vaKi0YxqcUl1Mjt4KIKBaF92pWnDOVsL/Sq2UQMmgDE8Fb6WskivAphnTSEwhMhpu/MMgXMPfIMRFfy6hC/kDa5kacwlnsrVnSyAChVefjM3I45nd1Oy3YTZ+hvF8AH9a7sq3sYkvxK/YAFgViODFBUl83hpaXS3thUgBhVnWKpKFzAKKtpRqgV/4TkWoKXi9cnZJKfVP0BQouiyoPZUP0HxVY4aABkeMNZILMNrJefAoQmjU+n582Wo1dnvm7/5Sd4TuZ+rHcMnCHRcYP4aV3nEmhNCKhpHLkpPqW7gg1fpKiHup8C7EiMjIU7vEgcqNByWcECgYEA0ZvTvnZGfDTFulEUVz/gpgepW5SXLtEOYzg7HNVnjliF3d8ThD9lrc9e/8KtZGvqPRzMNBV67TaLDOvLJkPGKMiK8K74FfkMY1JJ7OU9mO5xEF5AQm13CGowloU/BnH5eLh0HmgjCoDR4E3EEwKW8DUIGB5cj9KlDoFtH2Zg25ECgYEAypxpP1abBEIEk4WYs8nwYA70M4TOMzWiuS7zWycxy2jtU03lFrTl+oiTy+Dvy7Fl4q7N5zVOkwYGxE3I4p8hnoZBqtuOSf4LpHboATsq7Zelyz5VH6EMMV2bpAqU0lGtdFQBZINHUI4QjxsWJ7+ypha+384YhMn9TJLPDKTrf0UCgYEAvu4zna19HQyxA7txTNyJ1JLsCNi8MdAKTATfi680aixmnCjkTTW2d/GKNmztpqjKMKq3s8XROJzTYoyyewOHUIUEUqL+pn06dIpzfk9+oXypDuDbpeayY77ezW1IcKWHOhjC5SO0r4+SHcCYlzxnoxybZ+TYKcYVxbXNYanPFpECgYEAjrS8LLCDXuxg7MccVwXVGNNvjRntYoRUqLo5Der9V5gAELy8rtGbamroLqGwRHgemxskS8VwIn4MJhfjdjs/IrjNZ9pcziDxclWN89AI3HADhrPQoQZ94AdeqJwLVlfRJC5HDNSqVkK5xxH8+OI8ol9C8b/n5R+gGV8OFonSlUECgYEAjAm7r43vHc2FYAwGrj45fCgl4TrHkv/8yrcV/1FUpa16GgIl7BCo7/ioZRGB+z3MK+EMhT+jU+L7hXjWS5vTB/XiNWrKqFzT9lsmHpYRL+ZP6ZKL3TQg7CGT5/8E6OTNIRngaz2QT9jIj5KHXkAdL0k7BOjRVJeq86ohkTheLwE=';		//商户私钥，填写对应签名算法类型的私钥，如何生成密钥参考：https://docs.open.alipay.com/291/105971和https://docs.open.alipay.com/200/105310
        /*** 配置结束 ***/
        $aliPay = new AliyunPay();
        $aliPay->setAppid($appid);
        $aliPay->setReturnUrl($returnUrl);
        $aliPay->setNotifyUrl($notifyUrl);
        $aliPay->setRsaPrivateKey($rsaPrivateKey);
        $aliPay->setTotalFee($payAmount);
        $aliPay->setOutTradeNo($outTradeNo);
        $aliPay->setOrderName($orderName);
        $sHtml = $aliPay->doPay();
        dump($sHtml);die;
    }
}
