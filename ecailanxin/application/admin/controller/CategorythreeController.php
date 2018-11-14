<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\File;
use think\Db;

Class CategorythreeController extends Controller{
	
	public function categorythree(){
        $fenye = Db::table('ycl_category_three')->paginate(10);
		$rowset = $fenye->all();
//		print_r($fenye);die;
			foreach($rowset as $k=>$v){
    		$two = Db::table('ycl_category_two')->where('id',$v['up_catid'])->find();
    		$rowset[$k]['up_catid'] = $two['cattwoname'];
    	}
        $this->assign('rowset',$rowset);
		$this->assign('fenye',$fenye);
		return $this->fetch();
	}
	
	public function addthreetype(){
		$rowset = Db::table('ycl_category_two')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	
	public function save(Request $request){
		$data['up_catid'] = $request->post('erji');
		$data['catthreename'] = $request->post('catthreename');
				if ($request->has ( 'img', 'file' )) {
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'img' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/cai' );
			    $data ['img']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
//		        print_r($data);die;
		$model = Db::table('ycl_category_three')->insert($data);
		return $this->redirect(url('admin/categorythree/addthreetype'));
	}
	
	public function del($id){
		$row = Db::table('ycl_category_three')->where('id',$id)->delete();
		$this->assign('row',$row);
		return $this->redirect(url('/admin/categorythree/categorythree'));
	}
	
	public function edit($id){
		$row = Db::table('ycl_category_three')->where('id',$id)->find();
		$rowset = Db::table('ycl_category_two')->select();
		$this->assign('rowset',$rowset);
		$this->assign('row',$row);
		return $this->fetch();
	}
	
	public function update(Request $request,$id){
		$data['up_catid']     = $request->post('erji');
		$data['catthreename'] = $request->post('catthreename');
		if ($request->has ( 'img', 'file' )) {
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'img' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/cai' );
			    $data ['img']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
    	Db::table ( 'ycl_category_three' )->where ( 'id', $id )->update($data);
    	return $this->redirect(url('/admin/categorythree/categorythree'));
    }
	
}
