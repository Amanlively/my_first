<?php
namespace app\shop\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\File;
class MyshopController extends Controller{
	
	public function myshop(){
		   
			$one1 = input('param.one'); //接收一级分类过来的ID
    		$two1 = input('param.two'); //接收二级分类过来的ID
			$rowset = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
//			print_r($rowset);die;
			$shop = $rowset['id'];


    	    $this->assign('rowset',$rowset);
 		
  			$one = Db::table('ycl_category_one')->order('id asc')->select();//查询一级分类表
    		$this->assign('one',$one);
    		
    		$two = Db::table('ycl_category_two')->where('up_catid',$one1)->order('id asc')->select(); //查询二级分类表
    		$this->assign('two',$two);
    		
    		if($two1 !== null){
    		$cai = Db::table('ycl_goods')->where('cattwoid',$two1)->where('shopid',$rowset['id'])->order('id asc')->select();
    	    $this->assign('cai',$cai);
    	
    		}else{
    		$cai = Db::table('ycl_goods')->where('catoneid',$one1)->where('shopid',$rowset['id'])->order('id asc')->select();
//  		$cai = Db::table('ycl_goods')->where('shopid',$rowset['id'])->select();
    	    $this->assign('cai',$cai);
    	    }
    	    if($one1 == null && $two1 == null){
    	    	$cai = Db::table('ycl_goods')->where('shopid',$rowset['id'])->order('id asc')->select();
    	    	$this->assign('cai',$cai);
    	    }
    		$this->assign('one1',$one1);
    		$this->assign('shop',$shop);
		
			return $this->fetch();
		
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
		
		$xin = Db::table('ycl_comment')->where('shop_id',$shop)->order('add_time desc')->select();//查看该店铺最新评论
		$this->assign('xin',$xin);
		$di = Db::table('ycl_comment')->where('shop_id',$shop)->order('di')->select();//查看该店铺最低分
		$this->assign('di',$di);
		$img     = Db::table('ycl_comment')->where('pingimg','not null')->where('shop_id',$shop)->select();//查看该店铺带图片所有评论
		$num1 = count($img);
		$this->assign('img',$img);
		$this->assign('num1',$num1);
//		print_r($img);
		$rowset = Db::table('ycl_shop_info')->where('id',$shop)->find(); 
		$time = date('H');
			if($time >= $rowset['open_time'] && $time < $rowset['close_time']){
				$kai = '营业中' ;
			}else{
				$kai = '已打烊' ;
			}
		$this->assign('kai',$kai);
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

	public function modifyproduct($shopid){ //添加商品显示页面
//		print_r($shopid);die;
		$one = Db::table('ycl_category_one')->select();//搜索一级分类
		$this->assign('one',$one);
		
		$two = Db::table('ycl_category_two')->select();//搜索二级分类
		$this->assign('two',$two);
        $three = Db::table('ycl_category_three')->select();//搜索三级分类 也是商品
        $this->assign('three',$three);
		$brand = Db::table('ycl_brand')->select();//搜索品牌表
		$this->assign('brand',$brand);
		
		$gg = Db::table('ycl_spec')->select();//搜索规格表
		$this->assign('gg',$gg);
		
		$gg1 = Db::table('ycl_spec')->select();//搜索规格表
		$this->assign('gg1',$gg1);
		$this->assign('shopid',$shopid);
		 return $this->fetch();
	}
	
	
	public function goodssave(Request $request,$shopid){ //保存商品
		
		$data['shopid']      = $shopid;//店铺id
		$data['goodsprice']  = input('param.goodsprice'); //商品价格
		$data['goodsgg']     = input('param.gg'); //商品规格
		$data['catoneid']    = input('param.one'); //一级分类
		$data['cattwoid']    = input('param.two');//二级分类
        $data['catthreeid']  = input('param.name');//三级分类
        $san = Db::table('ycl_category_three')->where('id',$data['catthreeid'])->value('catthreename');
        $data['goodsname']   = $san;   //商品名字
		$data['introduce']   = input('param.introduce');//商品描述. 介绍
		$data['stock']       = input('param.stock');//库存
		$data['stockgg']     = $data['goodsgg'];//库存规格
		$data['goodsarea']   = input('param.goodsarea');//产地
		$data['brand_id']    = input('param.brand');//商品品牌
		$data['discount']    = input('param.discount');//折扣
		$data['alias']       = input('param.alias');//别名
		$data['pinyin']      = $this->huoqu($data['goodsname']);//商品首字母
		$data['addtime']     = time();
		$data['city']        = Db::table('ycl_shop_info')->where('uid',session('userid'))->value('city');//别名
//		print_r($data);die;
		$file = $request->file('goodspic');
//		print_r($file);die;
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
				if($info){
					$data['goodspic']=$info->getSaveName();
//					print_r($data);die;
				}
			}
		Db::table('ycl_goods')->insert($data);
		return $this->redirect('/shop/myshop/myshop/id/' .$shopid);
	}
	
	public function goodsedit($id,$shopid){
//		print_r($shopid);
		$this->assign('shopid',$shopid);
		
		$row = Db::table('ycl_goods')->where('id',$id)->find();
		$this->assign('row',$row);
		
		$one = Db::table('ycl_category_one')->where('id',$row['catoneid'])->value('catonename');//搜索一级分类
		$this->assign('one',$one);

		$two = Db::table('ycl_category_two')->where('id',$row['cattwoid'])->value('cattwoname');//搜索二级分类
		$this->assign('two',$two);
		
		$brand = Db::table('ycl_brand')->select();//搜索品牌表
		$this->assign('brand',$brand);
		
		$gg = Db::table('ycl_spec')->select();//搜索规格表
		$this->assign('gg',$gg);
		
		$gg1 = Db::table('ycl_spec')->select();//搜索规格表
		$this->assign('gg1',$gg1);
		return $this->fetch();
	}
	public function goodsupdate(Request $request,$id,$shopid){
		$data['shopid']      = $shopid;//店铺id
		$data['goodsname']   = input('param.name');//商品名字
		$data['goodsprice']  = input('param.goodsprice'); //商品价格
		$data['goodsgg']     = input('param.gg'); //商品规格
		$data['catoneid']    = input('param.one'); //一级分类
		$data['cattwoid']    = input('param.two');//二级分类
		$data['introduce']   = input('param.introduce');//商品描述. 介绍
		$data['stock']       = input('param.stock');//库存
		$data['stockgg']     = $data['goodsgg'];//库存规格
		$data['goodsarea']   = input('param.goodsarea');//产地
		$data['brand_id']    = input('param.brand');//商品品牌
		$data['discount']    = input('param.discount');//折扣
		$data['alias']       = input('param.alias');//别名
		$data['addtime']     = time();
		
		$file = $request->file('goodspic');
//		print_r($file);die;
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
				if($info){
					$data['goodspic']=$info->getSaveName();
//					print_r($data);die;
				}
			}
		$ww = Db::table('ycl_goods')->where('id',$id)->update($data);
		return $this->redirect('/shop/myshop/myshop/id/' .$shopid);
		
	}
	
	public  function del($id,$shopid){
		
//		print_r($shopid);die;
		Db::table('ycl_goods')->where('id',$id)->delete();
		return $this->redirect('/shop/myshop/myshop/id/'.$shopid);
	}







	//显示尾货列表
	public function tailgoodsarea() {
		if(session('userid') == null) {
			return $this->redirect(url('/user/login/login'));
		} else {
			$rowset = Db::table('ycl_shop_info')->where('uid',session('userid'))->find();
			$goods = Db::table('ycl_goods')->where('shopid',$rowset['id'])->where('tail',1)->select();
			$gg = Db::table('ycl_spec')->select();
			$goodsgg = array_column($gg,'name','id');
			$this->assign('goodsgg',$goodsgg);
			$this->assign('rowset',$rowset);
			$this->assign('goods',$goods);
		}
		
		return $this->fetch();
	}
	
	//添加尾货
     public function addinggoods() {
     	$id = input('param.goodsid');
		$row = Db::table('ycl_goods')->where('id',$id)->find();
//		print_r($row);die;
		$this->assign('row',$row);
		$this->assign('goodsid',$id);
		return $this->fetch();
	}
	// 添加尾货保存
	public function tailsave() {
		$id = input('param.id');
		$number = input('param.number');
		$price = input('param.price');
		$arr = array(
		'stock' => $number,
		'goodsprice' => $price,
		'tail' => 1
		);
		Db::table('ycl_goods')->where('id',$id)->update($arr);
		return $this->redirect(url('/shop/myshop/tailGoodsArea'));
	}
	
	
	
	public function details(){  //菜品详情预览页
			$id = input('param.goodsid');//商品id
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
//			print_r($rowset);die;
    	    //商品所属商家
            $shopid = Db::name('goods')->where('id',$id)->value('shopid');
            //店主id
            $userid = Db::name('shop_info')->where('id',$shopid)->value('uid');
            $this->assign('toid',$userid);
    	    
    	
		    return $this->fetch();
			}

		public function liandong(){
			$cate_id = input('post.cate_id');
            $three = Db::table('ycl_category_three')->where('id',$cate_id)->find();
			$san = Db::table('ycl_category_two')->where('id',$three['up_catid'])->find();
            $yi  = Db::table('ycl_category_one')->where('id',$san['up_catid'])->find();
                $jo['id']           = $yi['id'];
                $jo['catonename']   = $yi['catonename'];
                $jo['cattwoname']   = $san['cattwoname'];
                $jo['cattwonameid'] = $san['id'];

//            print_r($jo);die;
			return json_encode($jo);
		}
	
	
	
	//获取中文字符拼音首字母
 function getFirstCharter($str){  
    if(empty($str)){
        return '';
    }  
    $fchar=ord($str{0});
    if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
    $s1=iconv('UTF-8','gb2312',$str);
    $s2=iconv('gb2312','UTF-8',$s1);
    $s=$s2==$str?$s1:$str;
    $asc=ord($s{0})*256+ord($s{1})-65536;
    if($asc>=-20319&&$asc<=-20284) return 'A';
    if($asc>=-20283&&$asc<=-19776) return 'B';
    if($asc>=-19775&&$asc<=-19219) return 'C';
    if($asc>=-19218&&$asc<=-18711) return 'D';
    if($asc>=-18710&&$asc<=-18527) return 'E';
    if($asc>=-18526&&$asc<=-18240) return 'F';
    if($asc>=-18239&&$asc<=-17923) return 'G';
    if($asc>=-17922&&$asc<=-17418) return 'H';
    if($asc>=-17417&&$asc<=-16475) return 'J';
    if($asc>=-16474&&$asc<=-16213) return 'K';
    if($asc>=-16212&&$asc<=-15641) return 'L';
    if($asc>=-15640&&$asc<=-15166) return 'M';
    if($asc>=-15165&&$asc<=-14923) return 'N';
    if($asc>=-14922&&$asc<=-14915) return 'O';
    if($asc>=-14914&&$asc<=-14631) return 'P';
    if($asc>=-14630&&$asc<=-14150) return 'Q';
    if($asc>=-14149&&$asc<=-14091) return 'R';
    if($asc>=-14090&&$asc<=-13319) return 'S';
    if($asc>=-13318&&$asc<=-12839) return 'T';
    if($asc>=-12838&&$asc<=-12557) return 'W';
    if($asc>=-12556&&$asc<=-11848) return 'X';
    if($asc>=-11847&&$asc<=-11056) return 'Y';
    if($asc>=-11055&&$asc<=-10247) return 'Z';
    return null;
 }
 //获取字符串中汉字的拼音首字母，循环调用上面的getFirstCharter方法。
 public function huoqu($str){
//     $str=input('param.cizu');
     $str=preg_replace('|[0-9a-zA-Z\/\@\!\#\$\%\^\&\*\(\)\_\+\=\-\<\>\?\,\.\|\~\`\{\}\[\]\{\}\:\;]+|','',$str);//去掉字符串中的非汉字字符
     $str1='';
     $arr=  str_split($str,3);
//     print_r($arr);die;
     for($i=0;$i<count($arr);$i++){
         $str1=$str1.$this->getFirstCharter($arr[$i]);
     }
     //$str1=$this->getFirstCharter($str);
     //$str1=  strtolower($str1);//转成小写字母
        return $str1;
 }
}




