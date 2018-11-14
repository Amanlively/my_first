<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\File;
use think\Db;

Class TailController extends Controller{
	public function tail(){
		$rowset = Db::table('ycl_goods')->where('tail',1)->select();
        foreach($rowset as $k=>$v){
        	$yiji = Db::table('ycl_category_one')->where('id',$rowset[$k]['catoneid'])->find();
        	$rowset[$k]['catoneid'] = $yiji['catonename'];
        	
        	$erji = Db::table('ycl_category_two')->where('id',$rowset[$k]['cattwoid'])->find();
        	$rowset[$k]['cattwoid'] = $erji['cattwoname'];
        	
        	$sanji = Db::table('ycl_category_three')->where('id',$rowset[$k]['catthreeid'])->find();
        	$rowset[$k]['catthreeid'] = $sanji['catthreename'];
        	
        	$pp = Db::table('ycl_brand')->where('id',$rowset[$k]['brand_id'])->find();
        	$rowset[$k]['brand_id'] = $pp['brand_name'];
        	
        	$gg = Db::table('ycl_spec')->where('id',$rowset[$k]['goodsgg'])->find();
        	$rowset[$k]['goodsgg'] = $gg['name'];
        }
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	public function tailq(){
		$id = input('param.id');
		$rowset = Db::table('ycl_goods')->where('id',$id)->setField('tail',1);
		return $this->redirect('/admin/tail/tail');
	}
	public function addtail(){
		$rowset = Db::table('ycl_shop_info')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function etail(){
		$id = input('param.id');
    	$row8 = Db::table('ycl_goods')->where('id',$id)->find();
    	$this->assign('row8',$row8); 
		$rowset2 = Db::table('ycl_category_one')->select();
		$this->assign ( 'rowset2', $rowset2 );
		$rowset3 = Db::table('ycl_category_two')->select();
		$this->assign ( 'rowset3', $rowset3 );
		$rowset4 = Db::table('ycl_category_three')->select();
		$this->assign ( 'rowset4', $rowset4 );
		$rowset5 = Db::table('ycl_spec')->select();
		$this->assign ( 'rowset5', $rowset5);
		$rowset6 = Db::table('ycl_brand')->select();
		$this->assign ( 'rowset6', $rowset6);
    	return $this->fetch();
	}
	
	public function save(Request $request){
		$data['goodsname'] = $request->post('goodsname');
		$data['shopid'] = $request->post('sd');
		$data['alias'] = $request->post('alias');
		$data['stock'] = $request->post('stock');
		$data['goodsprice'] = $request->post('goodsprice');
		$data['tail'] = 1;
		
		$file = request()->file('goodspic');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
				if($info){
					$data['goodspic']=$info->getSaveName();
				}
			}
//		print_r($data);
//		exit;
		Db::table('ycl_goods')->insert($data);
		return $this->redirect(url('/admin/tail/tail'));
	}
	
	public function update(Request $request){
		$id = input('param.id');
		$data['goodsname'] = $request->post('goodsname');
		$data['catoneid'] = $request->post('catonename');
		$data['cattwoid'] = $request->post('cattwoname');
		$data['catthreeid'] = $request->post('catthreename');
		$data['is_up'] = $request->post('is_up');
		$data['goodsprice'] = $request->post('goodsprice');
		$data['goodsarea'] = $request->post('goodsarea');
		$data['alias'] = $request->post('alias');
		$data['introduce'] = $request->post('introduce');
		$data['goodsgg'] = $request->post('gg');
		$data['brand_id'] = $request->post('pp');
		$data['addtime'] = time();
		
		$file = request()->file('oneimg');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['oneimg']=$info->getSaveName();
				}
			}
		
		$file = request()->file('twoimg');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['twoimg']=$info->getSaveName();
				}
			}
		
		$file = request()->file('threeimg');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['threeimg']=$info->getSaveName();
				}
			}
		
		$file = request()->file('fourimg');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['fourimg']=$info->getSaveName();
				}
			}			
		
		$file = request()->file('goodspic');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
				if($info){
					$data['goodspic']=$info->getSaveName();
				}
			}			
		
    	Db::table ( 'ycl_goods' )->where ( 'id', $id )->update($data);
		return $this->redirect(url('/admin/tail/tail'));
	}
	
		public function del(){
		 $id = input('param.id');
		 $row = Db::table('ycl_goods')->where('id',$id)->delete();
		 $this->assign('row',$row);
		 return $this->redirect(url('/admin/tail/tail'));
	}
}
