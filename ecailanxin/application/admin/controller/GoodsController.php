<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Goods;
use app\admin\model\Goodstype;
use think\Request;
use think\File;
use think\Db;


class GoodsController extends Controller
{
    public function goods(){

        $rowset = Db::table('ycl_goods')->paginate(2);
        $fenye= $rowset->all();
        foreach ($fenye as $k => $v){
            $yi=Db::table('ycl_category_one')->where('id',$v['catoneid'])->value('catonename');
            $er=Db::table('ycl_category_two')->where('id',$v['cattwoid'])->value('cattwoname');
            $san=Db::table('ycl_category_three')->where('id',$v['catthreeid'])->value('catthreename');
            $brand=Db::table('ycl_brand')->where('id',$v['brand_id'])->value('brand_name');
            $spec=Db::table('ycl_spec')->where('id',$v['goodsgg'])->value('name');
            $fenye[$k]['catoneid'] = $yi;
            $fenye[$k]['cattwoid'] = $er;
            $fenye[$k]['catthreeid'] = $san;
            $fenye[$k]['brand_id'] = $brand;
            $fenye[$k]['goodsgg'] = $spec;
        }


        $this->assign('fenye',$fenye);
        $this->assign('rowset',$rowset);
        return $this->fetch();
    }
	 public function addgoods(){
	 	$rowset7 = Db::table('ycl_shop_info')->select();
		$this->assign ( 'rowset7', $rowset7 );
	 	$rowset2 = Db::table('ycl_category_one')->select();
		$this->assign ( 'rowset2', $rowset2 );
		$rowset3 = Db::table('ycl_category_two')->select();
		$this->assign ( 'rowset3', $rowset3 );
		$rowset4 = Db::table('ycl_category_three')->select();
		$this->assign ( 'rowset4', $rowset4 );
		$rowset5 = Db::table('ycl_brand')->select();
		$this->assign ( 'rowset5', $rowset5 );
		$rowset6 = Db::table('ycl_spec')->select();
		$this->assign ( 'rowset6', $rowset6 );
		return $this->fetch();
    }
	
	public function save(Request $request){
		$data['goodsname']  = $request->post('goodsname');
		$data['shopid']  = $request->post('shop_name');
		$city = Db::table('ycl_shop_info')->where('id',$data['shopid'])->find();
		$data['city']   = $city['city'];
		$data['catoneid']   = $request->post('catonename');
		$data['cattwoid']   = $request->post('cattwoname');
		$data['discount']   = $request->post('discount');
		$data['catthreeid'] = $request ->post('catthreename');
		$data['goodsprice'] = $request->post('goodsprice');
		$data['is_up']      = $request->post('is_up');
		$data['alias'] = $request->post('alias');
		$data['introduce'] = $request->post('introduce');
		$data['goodsarea']  = $request->post('goodsarea');
		$data['goodsgg']    = $request->post('spce');
		$data['addtime']    = time('addtime');
		$data['brand_id']   = $request->post('brand_name');
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
		if ($request->has ( 'goodspic', 'file' )) {
		$file = $request->file('goodspic');
//		print_r($file);die;
		$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
		$data ['goodspic'] = $uploadFile->getSaveName ();
		} else {
		echo $file->getError();
		}
//		print_r($data);
//		exit;
		$model = Db::table('ycl_goods')->insert($data);
		return $this->redirect(url('/admin/goods/goods'));
	}
	
	public function del(){
		$id = input('param.id');
		$row = Db::table('ycl_goods')->where('id',$id)->delete();
		$this->assign('row',$row);
		return $this->redirect(url('/admin/goods/goods'));
	}
	
	public function edit(){
		$id = input('param.id');
    	$row = Db::table('ycl_goods')->where('id',$id)->find($id);
    	$this->assign('row',$row); 
		$rowset3 = Db::table('ycl_category_one')->select();
		$this->assign ( 'rowset3', $rowset3 );
		$rowset4 = Db::table('ycl_category_two')->select();
		$this->assign ( 'rowset4', $rowset4 );
		$rowset5 = Db::table('ycl_category_three')->select();
		$this->assign ( 'rowset5', $rowset5 );
		$rowset6 = Db::table('ycl_brand')->select();
		$this->assign ( 'rowset6', $rowset6 );
    	return $this->fetch();
    }
	
	public function update(Request $request,$id){
		$data['goodsname'] = $request->post('goodsname');
		$data['catoneid'] = $request->post('catonename');
		$data['cattwoid'] = $request->post('cattwoname');
		$data['catthreeid'] = $request->post('catthreename');
		$data['goodsprice'] = $request->post('goodsprice');
		$data['is_up'] = $request->post('is_up');
		$data['goodsarea'] = $request->post('goodsarea');
		$data['goodsgg'] = $request->post('goodsgg');
		$data['addtime'] = time('addtime');
		$data['brand_id'] = $request->post('brand_id');
		$data['alias'] = $request->post('alias');
		$data['introduce'] = $request->post('introduce');
		$file = request()->file('oneimg');
			if($file){
				$info=$file->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['oneimg']=$info->getSaveName();
				}
			}
		
		$file1 = request()->file('twoimg');
			if($file1){
				$info=$file1->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['twoimg']=$info->getSaveName();
				}
			}
		
		$file2 = request()->file('threeimg');
			if($file2){
				$info=$file2->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['threeimg']=$info->getSaveName();
				}
			}
		
		$file3 = request()->file('fourimg');
			if($file3){
				$info=$file3->move ( \ENV::get('root_path'). '/public/static/uploads/lbt' );
				if($info){
					$data['fourimg']=$info->getSaveName();
				}
			}			
		
			// think\File
			// 上传文件的信息
			$file4 = $request->file ( 'goodspic' );
			// 成功上传的文件信息
			if($file4){
			$uploadFile = $file4->move ( \ENV::get('root_path'). '/public/static/uploads/goodspic' );
			if($uploadFile){
			$data ['goodspic'] = $uploadFile->getSaveName ();
			}
		}
		
    	Db::table ( 'ycl_goods' )->where ( 'id', $id )->update($data);
    	return $this->redirect(url('/admin/goods/goods'));
    }
	
	public function recycle() {
		$id = input('param.news_checkbox/a');
		$zt = input('param.zt');
//		print_r($zt);die;
		$model = new Goods;
		$rowset = $model->whereIn('id',$id)->column('is_up');
//		print_r($rowset);exit;
		if($zt == 1) {
			$model->whereIn('id',$id)->update(['is_up'=>1]);
		}
		if($zt == 2) {
			$model->whereIn('id',$id)->update(['is_up'=>0]);
		}
		if($zt == 3) {
			$model->whereIn('id',$id)->delete();
		}
		return $this->redirect(url('/admin/goods/goods'));
	}
	
	
	
}
