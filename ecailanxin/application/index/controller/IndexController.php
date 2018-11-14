<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\Validate;
Class IndexController extends Controller
{
	public function index(){ //首页
//        phpinfo();
	if(cookie('userid') == null || session('phone') == null){
		return $this->redirect('/index/index/startpage');
	}else{
        if (empty(session('city'))){
            $city = input('param.city');//定位城市
            session('city',$city);
            cookie('city',$city);
        }

//      print_r($city);
	$qer = Db::table('ycl_user')->where('id',session('userid'))->find();
    	if($qer){
    	         
					 if( $qer['register_type'] == 2 && $qer['is_sh'] == 1){
						return $this->redirect('/shop/myshop/myshop');
				}else{
					if($qer['register_type'] == 3 && $qer['is_sh'] == 1) {
                        return $this->redirect('/courier/mycenter/mycenter');

				}
			}
		}
	}
		$shop = Db::table('ycl_shop_info')->where('city',session('city'))->order('id desc')->limit(2)->select();//查询店铺表
		$shi = Db::table('ycl_bazaar')->where('city',session('city'))->where('first',1)->find();//查询首页推荐
		$this->assign('shi',$shi);
		foreach($shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$shop[$k]['id'])->min('discount');
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$shop[$k]['id'])->find();
		$shop[$k]['goodsname']    = $rate1['goodsname'];
		$shop[$k]['discount']     = $rate1['discount'];
		$shop[$k]['goodsprice']   = $rate1['goodsprice'];
		}
//		print_r($shop);
    	$this->assign('shop',$shop);
    	
		$bazaar = Db::table('ycl_bazaar')->where('city',session('city'))->limit(3)->select();//查询市场表
    	$this->assign('bazaar',$bazaar);
		return $this->fetch();
	}	
	
    public function classification() {
    	$type = input('param.type');//输入框里面的值
    	$letter = preg_match("/^[a-zA-Z\s]+$/",$type);
//  	preg_match("/^[a-zA-Z\s]+$/",$str);
    	if($letter){
    		return redirect('/index/index/shop/letter/'.$type);
    	}
//  	print_r($type);die;
    	$one1 = input('param.one'); //接收一级分类过来的ID
    	$two1 = input('param.two'); //接收二级分类过来的ID
  		if($type == null){

  		$one = Db::table('ycl_category_one')->order('id asc')->select();//查询一级分类表
    	$this->assign('one',$one);

            $thr = array();
            $two = Db::table('ycl_category_two')->where('up_catid',$one1)->order('id asc')->select(); //查询二级分类表
            if (!empty($one1)){
                    foreach ($two as $k=>$v){
                        $cc[] = Db::table('ycl_category_three')->where('up_catid',$v['id'])->select();
                            foreach ($cc as $cck => $ccv){
                                    foreach ($ccv as $cc_v){
                                        if(!in_array($cc_v,$thr)) {

                                            $thr[] = $cc_v;
                                        }
                                    }

                            }
                        }
                $this->assign('three',$thr);
               // print_r($thr);die;
            }else{

                $three = Db::table('ycl_category_three')->order('id asc')->select(); //查询三级分类表
                $this->assign('three',$three);
            }
            $this->assign('two',$two);



            if($two1 !== null){
    	$three = Db::table('ycl_category_three')->where('up_catid',$two1)->order('id asc')->select(); //查询三级分类表
    	$this->assign('three',$three);
    	}
   
  		}else{
  			
		$one = Db::table('ycl_category_one')->order('id asc')->select();//查询一级分类表
    	$this->assign('one',$one);
    	
    	$two = Db::table('ycl_category_two')->order('id asc')->where('up_catid',$one1)->select(); //查询二级分类表
    	$this->assign('two',$two);

    	$tj['catthreename'] = array('like','%'.$type.'%');
    	$sp['shop_name']    = array('like','%'.$type.'%');
    	
    	if($tj['catthreename'] !== null){
      	$three = Db::table('ycl_category_three')->whereCatthreename('like', "%$type%")->select();//模糊搜索分类表菜品
      	$this->assign('three',$three);
        }
        
     	if($three == null && $sp['shop_name'] !== null){
//		$tj['shop_name'] = array('like','%'.$type.'%');
      	$shop = Db::table('ycl_shop_info')->whereShopName('like', "%$type%")->where('city',session('city'))->select();
      	cookie('shop',$shop);
      	return redirect('/index/index/businesslist');
	    }

    }
    	$this->assign('one1',$one1);
		return $this->fetch();
    }
    	public function classifidetail(){  //菜品分类
		    $id    = input('param.id');//蔬菜的id
		    $sx    = input('param.sx');
//			print_r($id);die;
			if($sx == 1){
			 $sex  ="sales desc";  //销量
			}
			
			if($sx == 2){
			 $sex  = "distance asc"; //距离
			}

			if($sx == 3){
			 $sex  = "reputation asc"; //好平
			}
			
			if($sx == 6){
			 $sex  = array(
			 'sales' => 'desc',
			 'distance' => 'asc',
			 'reputation' => 'asc'
			 );
			 $cai = Db::table('ycl_goods')->where('catthreeid',$id)->where('city',session('city'))->order($sex)->select();
			 $yi=Db::table('ycl_spec')->select(); //将规格表的 id 转为name显示
			$gg = array_column($yi,'name','id');
			 $this->assign('gg',$gg);
    	    $this->assign('cai',$cai);
			}
			
			if($id !== null){
			$shop=Db::table('ycl_shop_info')->select(); //将规格表的 id 转为name显示
			$aa = array_column($shop,'shop_name','id');
			$this->assign('aa',$aa);
				 
		    $yi=Db::table('ycl_spec')->select(); //将规格表的 id 转为name显示
			$gg = array_column($yi,'name','id');
		    $cai = Db::table('ycl_goods')->where('catthreeid',$id)->where('city',session('city'))->select(); //查询二级分类表
//		    print_r($cai);
		    $this->assign('gg',$gg);
    	    $this->assign('cai',$cai);
    	   }
    	   
			if($id !== null && $sx !== null){
				$cai  = Db::table('ycl_goods')->where('catthreeid',$id)->where('city',session('city'))->order($sex)->select();
				$this->assign('cai',$cai);
			}
    	  
//          }else{
//          	
////  		$this->assign('id',$id);
//			$yi=Db::table('ycl_spec')->select(); //将规格表的 id 转为name显示
//			$gg = array_column($yi,'name','id');
//			$this->assign('gg',$gg);
//			
//		    $cai = Db::table('ycl_goods')->select(); //查询二级分类表
//		    $this->assign('cai',$cai);
//		    
//		   	$shop=Db::table('ycl_shop_info')->select(); //将规格表的 id 转为name显示
//			$aa = array_column($shop,'shop_name','id');
//			$this->assign('aa',$aa);
//			}
			
    			$this->assign('id',$id);
		        return $this->fetch();
			}
			
			
			public function details(){  //菜品详情
			$id = input('param.id');//商品id
			$rowset1 = Db::table('ycl_collect')->where('uid',session('userid'))->where('goods_id',$id)->find();
			$this->assign('rowset1',$rowset1);
			$yi=Db::table('ycl_spec')->select(); //将规格表的 id 转为name显示
			$gg = array_column($yi,'name','id');
			$this->assign('gg',$gg);
			
			$er=Db::table('ycl_brand')->select(); //将品牌表的 id 转为name显示
			$pin = array_column($er,'brand_name','id');
			$this->assign('pin',$pin);
			
 			$rowset = Db::table('ycl_goods')->where('id',$id)->find(); 
    	    $this->assign('rowset',$rowset);

    	    //商品所属商家
            $shopid = Db::name('goods')->where('id',$id)->value('shopid');
            //店主id
            $userid = Db::name('shop_info')->where('id',$shopid)->value('uid');
            $this->assign('toid',$userid);
    	    
    	    //查询当前店铺的商品  显示4条
    	    $shop = Db::table('ycl_goods')->where('shopid',$rowset['shopid'])->order('shopid desc')->limit(4)->select();
//  	    print_r($shop);die;
    	    $this->assign('shop',$shop);
    	
		    return $this->fetch();
			}	
			
		
		public function businesslist(){
		$id   = input('param.id');//市场ID
		$this->assign('id',$id);
		$bazaar_shop1 = cookie('shop');// 模糊查询店铺表
		$sx   = input('param.sx');//类型
		if($sx == 2){
			$sex = "distance desc"; //距离
		}
		if($sx == 1){
			$sex = "sales desc"; //销量
		}
		if($sx == 3){
			$sex = "reputation desc"; //好评
		}
			if($sx == 6){
			 $sex  = array(
			 'sales' => 'desc',
			 'distance' => 'asc',
			 'reputation' => 'asc'
			 );
		$bazaar_shop = Db::table('ycl_shop_info')->where('city',session('city'))->order($sex)->select();//查询商家表
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
		
		$this->assign('bazaar_shop',$bazaar_shop);
		}
		
		if($id !== null){
		$bazaar_shop = Db::table('ycl_shop_info')->where('city',session('city'))->where('bazaarid',$id)->select();//查询商家表
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
		
		$this->assign('bazaar_shop',$bazaar_shop);
		
		}else{
  		if($bazaar_shop1 !== null ){
		//$bazaar_shop = Db::table('ycl_shop_info')->where($shop1)->select();//查询商家表
		$bazaar_shop = cookie('shop');
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
//		print_r($bazaar_shop);die;
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
    	
		}else{
			
  		$bazaar_shop = Db::table('ycl_shop_info')->where('city',session('city'))->select();//查询商家表
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
  		}
		}
		
		if($sx !== null){
		$bazaar_shop  = Db::table('ycl_shop_info')->where('city',session('city'))->where('bazaarid',$id)->order($sex)->select();
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
  		}
				
		
		cookie('shop',null);
		return $this->fetch();
		}
		
		public function businesslistt(){
		$sx = input('param.sx');
			if($sx == 2){
			$sex = "distance desc"; //距离
		}
		if($sx == 1){
			$sex = "sales desc"; //销量
		}
		if($sx == 3){
			$sex = "reputation desc"; //好评
		}
		
		if($sx == 6){
			 $sex  = array(
			 'sales' => 'desc',
			 'distance' => 'asc',
			 'reputation' => 'asc'
			 );
		$bazaar_shop  = Db::table('ycl_shop_info')->where('city',session('city'))->order($sex)->select();
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
		}
		
		if($sx !== null){
		$bazaar_shop  = Db::table('ycl_shop_info')->where('city',session('city'))->order($sex)->select();
		foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
  }else{
  	$bazaar_shop  = Db::table('ycl_shop_info')->where('city',session('city'))->select();
  	foreach($bazaar_shop as $k=>$v){
		$rate  = Db::table('ycl_goods')->where('shopid',$bazaar_shop[$k]['id'])->min('discount');//查询商品表最小的折扣
		$rate1 = Db::table('ycl_goods')->where('discount',$rate)->where('shopid',$bazaar_shop[$k]['id'])->find();
		$bazaar_shop[$k]['goodsname']   = $rate1['goodsname'];
		$bazaar_shop[$k]['discount']    = $rate1['discount'];
		$bazaar_shop[$k]['goodsprice']  = $rate1['goodsprice'];
		}
    	$this->assign('bazaar_shop',$bazaar_shop);
  }
			
			return $this->fetch();
		}
		
		public function tailgoods(){//尾货区
		$rows = Db::table('ycl_goods')->where('city',session('city'))->where('tail',1)->select();
		$rowset1  = Db::table('ycl_shop_info')->select();
		$shopname = array_column($rowset1,'shop_name','id');
		$this->assign('shopname',$shopname);
		$this->assign('rows',$rows);
		return $this->fetch();
		}
		
		public function marketArea(){ //市场专区
		$sx = input('param.sx');
		if($sx == 2){ 
			$sex ="distance desc";//距离
			
		}
		if($sx == 3){ 
			$sex ="scale desc";//规模
		}
		if($sx == 1){
			 $sex  = array(
			 'scale' => 'desc',
			 'distance' => 'asc'
			 );
		$bazaar = Db::table('ycl_bazaar')->where('city',session('city'))->order($sex)->select();//查询市场表
		foreach($bazaar as $k=>$v){
			$temp = Db::table('ycl_spec')->where('id',$v['scalesize'])->find();
			$bazaar[$k]['scalesize'] = $temp['name'];
			$bazaar[$k]['parasang']  = $temp['name'];
		 }
    	$this->assign('bazaar',$bazaar);
			}
		$bazaar = Db::table('ycl_bazaar')->where('city',session('city'))->select();//查询市场表
		foreach($bazaar as $k=>$v){
			$temp = Db::table('ycl_spec')->where('id',$v['scalesize'])->find();
			$bazaar[$k]['scalesize'] = $temp['name'];
			$bazaar[$k]['parasang']  = $temp['name'];
		}
    	$this->assign('bazaar',$bazaar);
    	if($sx !== null){
    	$bazaar = Db::table('ycl_bazaar')->where('city',session('city'))->order($sex)->select();//查询市场表
    	foreach($bazaar as $k=>$v){
			$temp = Db::table('ycl_spec')->where('id',$v['scalesize'])->find();
			$bazaar[$k]['scalesize'] = $temp['name'];
			$bazaar[$k]['parasang']  = $temp['name'];
		}
    	$this->assign('bazaar',$bazaar);
    	}
		return $this->fetch();
	}	
//  畅销榜页面
    	public function bestselling() {
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',1)->order('sales desc')->select();
		$rowset1 = Db::table('ycl_shop_info')->select();
		$shopname = array_column($rowset1,'shop_name','id');
		$this->assign('shopname',$shopname);
		$rowset2 = Db::table('ycl_spec')->select();
		$spcename = array_column($rowset2,'name','id');
		$this->assign('spcename',$spcename);
		$this->assign('rowset',$rowset);
    	return $this->fetch();
    }
    
//  聚实惠显示页面
     public function benefit() {
		$rowset   = Db::table('ycl_goods')->where('is_tj',1)->where('city',session('city'))->order('discount asc')->select();
		$rowset1  = Db::table('ycl_shop_info')->select();
		$shopname = array_column($rowset1,'shop_name','id');
		$this->assign('shopname',$shopname);
		
		$rowset2  = Db::table('ycl_spec')->select();
		$spcename = array_column($rowset2,'name','id');
		$this->assign('spcename',$spcename);
		$this->assign('rowset',$rowset);
    	return $this->fetch();
    }
    
    public function payment(){//处理代付款订单
		$rowset = Db::table('ycl_order')->where('order_status',0)->order('add_time asc')->select();
		foreach ($rowset as $k=>$v){
			$name = Db::table('ycl_goods')->where('id',$rowset[$k]['goods_id'])->find();
			$rowset[$k]['goods_id'] = $name['goodsname'];
//			$jg = $rowset[$k]['good_num'] * $rowset[$k]['good_pirce'];
		}
		
		$num = Db::table('ycl_order')->where('order_status',0)->count();
		$money = Db::table('ycl_order')->where('order_status',0)->sum('good_pirce');
//		print_r($num);die;
//		$this->assign('jg',$jg);
		$this->assign('num',$num);
		$this->assign('money',$money);
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}	
	


	public function save(Request $request){ //保存购买商品
		if(session('userid') == null || session('phone') == null){
			$data['status']= -10;
				$data['info']="请您先登录";
				$msg=json_encode($data);
				echo $msg;
				return;
		}
			$num = input('post.num');
			$cgid="CGDH".time().rand(100000,999999);
//			print_r($num);
			if($num == null || $num == 0){
			$data['status']= -1;
				$data['info']="购买数量不能为空";
				$msg=json_encode($data);
				echo $msg;
				return;
		}
			
		$cgd = Db::table('ycl_purchase')->where('uid',session('userid'))->where('pron',1)->value('cgdh');
//		print_r($cgd);die;
    			if(!empty($cgd)){
    				$cgid = $cgd;
    			}
//  	$group = Db::table('ycl_purchase')->where('cgdh',$cgid)->select();//如果采购单有该菜品则叠加
//  	print_r($group);die;
		$good_id = $request->post('spid');//商品id
		$shop_id = $request->post('dp');//商家id
		$group = Db::table('ycl_purchase')->where('uid',session('userid'))->where('goods_id',$good_id)->where('shop_id',$shop_id)->where('status',0)->find();
		if($group){
				$data['number'] = $group['number']    + $request->post('num');
    			$data['money']  = $data['number'] * $request->post('jg');
    			$order = Db::table('ycl_purchase')->where('id',$group['id'])->update($data);
		}else{
							$data['uid']	    = session('userid');
							$data['goodsname']  = $request->post('goodsname');	
							$data['goods_id']   = $good_id;	
							$data['number']     = $request->post('num');
							$data['goodsmoney'] = $request->post('jg');
							$data['shop_id']    = $shop_id;
							$data['add_time']   = time();
							$data['cgdh']   	= $cgid;
							$data['pron']   	= 1;
					//		$data['waybill']    = date('Ymd').rand();
							$data['money']      = $data['number'] * $data['goodsmoney'];
							$order = Db::table('ycl_purchase')->insert($data);	
		}
				
		if($order){
    	           $data['status']=1;
					$data['info']="已添加到采购单";
					$msg=json_encode($data);
					echo $msg;
					return;
    	}else{
    	 			$data['status']=0;
					$data['info']="添加失败";
					$msg=json_encode($data);
					echo $msg;
					return;
    	
    	}
	}
	
		public function muddle(){ //调料专场
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',4)->select();
		
		foreach($rowset as $k=>$v){
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		
		$this->assign('rowset',$rowset);
		return $this->fetch();		
	}
 	public function meat(){ //肉禽最低价
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',2)->select();
		foreach($rowset as $k=>$v){
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		
		$this->assign('rowset',$rowset);
		return $this->fetch();		
	}
	public function cargo(){ //冻货专场
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',3)->select();
		foreach($rowset as $k=>$v){
			$temp  = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		
		$this->assign('rowset',$rowset);
		return $this->fetch();		
	}
	public function drink(){ //粮油 酒饮
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',5)->select();
		foreach($rowset as $k=>$v){
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		$this->assign('rowset',$rowset);
//		print_r($rowset);die;
		return $this->fetch();		
	}
	public function process(){ //预加工食品
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->where('is_tj',6)->select();
		foreach($rowset as $k=>$v){
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		$this->assign('rowset',$rowset);
//		print_r($rowset);die;
		return $this->fetch();		
	}
	public function shop(){ //全部食品
		$type = input('param.letter');//根据字母搜索菜品
		if($type){
			$rowset = Db::table('ycl_goods')->where('city',session('city'))->wherePinyin('like', "%$type%")->select();
				foreach($rowset as $k=>$v){
			$ce = Db::table('ycl_shop_info')->where('id',$v['shopid'])->select();
			
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		}else{
			
		
		$rowset = Db::table('ycl_goods')->where('city',session('city'))->select();
		foreach($rowset as $k=>$v){
			$ce = Db::table('ycl_shop_info')->where('id',$v['shopid'])->select();
			
			$temp = Db::table('ycl_shop_info')->where('id',$v['shopid'])->find();
			$temp1 = Db::table('ycl_spec')->where('id',$v['goodsgg'])->find();
			$rowset[$k]['shopid']  = $temp['shop_name'];
			$rowset[$k]['goodsgg'] = $temp1['name'];
		}
		}
		$this->assign('rowset',$rowset);
//		print_r($rowset);die;
		return $this->fetch();
	}
	public function startpage(){
		return $this->fetch();
	}
}
