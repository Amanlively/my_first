<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;

class BazaarController extends Controller
{	
	 public function bazaar()//显示页面
    {
    	$rowset = Db::table('ycl_bazaar')->paginate(2);
    	$wxlist = $rowset->all();
    	foreach ($wxlist as $k=>$v){
//  		$city = Db::table('ycl_city')->where('id',$v['city'])->find();
    		$guimo = Db::table('ycl_spec')->where('id',$v['scalesize'])->find();
    		$juli = Db::table('ycl_spec')->where('id',$v['parasang'])->find();
//  		$wxlist[$k]['city'] = $city['city_name'];
    		$wxlist[$k]['scalesize'] = $guimo['name'];
    		$wxlist[$k]['parasang'] = $juli['name'];
    	}
    	
    	$this->assign('rowset',$rowset);
    	$this->assign('wxlist',$wxlist);
		return $this->fetch();
    }
    public function addbazaar()//显示页面
    {
    	$city = Db::table('ycl_city')->select();
    	$this->assign('city',$city);
    	$rowset1 = Db::table('ycl_spec')->select();
    	$this->assign('rowset1',$rowset1);
		return $this->fetch();
    }
    
    public function save(Request $request){
		$data['baname'] = $request->post('baname');
		$data['place'] = $request->post('place');
		$data['distance'] = $request->post('distance');
		$data['parasang'] = $request->post('parasang');
		$data['scale'] = $request ->post('scale');
		$data['scalesize'] = $request->post('scalesize');
		$data['content'] = $request->post('content');
		$data['city'] = $request->post('city');
//		print_r($data);die;
		if ($request->has ( 'bazaar_img', 'file' )) {
			// think\File
			// 上传文件的信息
			$file = $request->file ( 'bazaar_img' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/shic' );
			$data ['bazaar_img'] = $uploadFile->getSaveName ();
		
		} else {
			echo $file->getError();
		}
//		print_r($data);
//		exit;
		$model = Db::table('ycl_bazaar')->insert($data);
//		$model->save($data);
		return $this->redirect(url('/admin/bazaar/bazaar'));
	}
	
	
  
    
    public function delete($id){//删除操作
		Db::table('ycl_bazaar')->where('id',$id)->delete();
		return $this->redirect(url('/admin/bazaar/bazaar'));
	}
	
	 public function first($id){//推荐
	 	$city = input('param.city');
	 	Db::table('ycl_bazaar')->where('city',$city)->setField('first',0);
		$shou = Db::table('ycl_bazaar')->where('id',$id)->setField('first',1);
		return $this->redirect(url('/admin/bazaar/first1'));
			
		
	}
	
		 public function first1(){//推荐首页
		$rowset = Db::table('ycl_bazaar')->where('first',1)->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
			
		
	}
	public function first2($id){//取消推荐首页
		$shou = Db::table('ycl_bazaar')->where('id',$id)->setField('first',0);
		return $this->redirect(url('/admin/bazaar/first1'));
			
		
	}
	public function edit($id){//编辑
	 	$row = Db::table ( 'ycl_bazaar' )->find ( $id );
		$this->assign ( 'row', $row );
		return $this->fetch ();
	     }
	
	
//	<-------------------------更新数据------------------------->
     	 public function update(Request $request, $id){
      	 $data['baname'] = $request->post('baname');
		$data['place'] = $request->post('place');
		$data['distance'] = $request->post('distance');
		$data['scale'] = $request ->post('scale');
		$data['content'] = $request->post('content');
		
		if ($request->has ( 'bazaar_img', 'file' )) {
			// think\File
			// 上传文件的信息
			$file = $request->file ( 'bazaar_img' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/shic' );
			$data ['bazaar_img'] = $uploadFile->getSaveName ();
		
		} else {
			echo $file->getError();
		}
		 Db::table ( 'ycl_bazaar' )->where ( 'id', $id )->update($data);
			return $this->redirect(url('/admin/bazaar/bazaar'));
     	}
     	
     	
     	public function addcity(){ //添加市场所属城市
     		return $this->fetch();
     	}
     	
     	public function citysave(){ //市场所属城市  保存
     		
     		$city = input('param.cityname');
     		 Db::table ( 'ycl_city' )->insert(['city_name' => $city]);
				return $this->redirect(url('/admin/bazaar/citylist'));
     	}
     	
     	public function citylist(){ //市场所属城市列表
     		$rowset = Db::table('ycl_city')->paginate(2);
    		$this->assign('rowset',$rowset);
     		return $this->fetch();
     	}
     	
     	  public function deletecity($id){//删除操作
		Db::table('ycl_city')->where('id',$id)->delete();
		return $this->redirect(url('/admin/bazaar/citylist'));
	}
}
