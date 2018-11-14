<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Goods;
use app\admin\model\Goodstype;
use think\Request;
use think\File;
use think\Db;


class BrandController extends Controller
{
    public function brand(){
		$rowset1 = Db::table('ycl_brand')->select();
		$this->assign('rowset1',$rowset1); 
		return $this->fetch();
    }
	
	 public function addbrand(){
		return $this->fetch();
    }
	
	public function save(Request $request){
		$data['brand_name'] = $request->post('brand_name');
		$model = Db::table('ycl_brand')->insert($data);
//		$model->save($data);
		return $this->redirect(url('/admin/brand/brand'));
	}
	
	public function del(){
		$id = input('param.id');
		$row = Db::table('ycl_brand')->where('id',$id)->delete();
		$this->assign('row',$row);
		return $this->redirect(url('/admin/brand/brand'));
	}
	
	public function edit(){
		$id = input('param.id');
    	$row = Db::table('ycl_brand')->find($id);
    	$this->assign('row',$row); 
    	return $this->fetch();
    }
	
	public function update(Request $request,$id){
		$data['brand_name'] = $request->post('brand_name');
    	Db::table ( 'ycl_brand' )->where ( 'id', $id )->update($data);
    	return $this->redirect(url('/admin/brand/brand'));
    }
	
	
	
	
}
