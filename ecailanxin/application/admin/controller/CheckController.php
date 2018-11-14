<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;

class CheckController extends Controller{
	public function check(){//审核列表
		$rowset = Db::table('ycl_check')->select();
		$this->assign('rowset',$rowset);
		return $this->fetch();
	}
	public function addcheck(){
		return $this->fetch();
	}
	public function save(Request $request)//保存数据
    {
    	$data['uid'] = session('userid');
//  	print_r($data);exit;
		$data['user_type'] = $request->post('user_type');
		$data['add_time'] = time();
		$data['is_pass'] = $request->post('is_pass');
		$data['true_name'] = $request->post('true_name');
		$data['phone'] = $request->post('phone');
		$data['addres'] = $request->post('addres');
		
		
		if ($request->has ( 'sfz_zm', 'file' )) {
			// think\File
			// 上传文件的信息8
			$file = $request->file ( 'sfz_zm' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/sfzzm' );
			$data ['sfz_zm'] = $uploadFile->getSaveName ();
		
		} else {
			echo $file->getError();
		}
//		print_r($data);
//		exit;
		if ($request->has ( 'sfz_fm', 'file' )) {
			// think\File
			// 上传文件的信息
			$file = $request->file ( 'sfz_fm' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/sfzfm' );
			$data ['sfz_fm'] = $uploadFile->getSaveName ();
		
		} else {
			echo $file->getError();
		}
//		print_r($data);exit;
		$query = Db::table ('ycl_check');
		// 2.操作数据(插入)
		$query->insert($data);
		return redirect ( url ( '/admin/check/check' ) );
				
    }
    
    public function delete($id){//删除操作
		$rowset = Db::table('ycl_check')->where('id',$id)->delete();
		$this->assign ( 'rowset', $rowset );
		return $this->redirect(url('/admin/check/check'));
	}
	
	public function edit($id){//编辑
	 	$row = Db::table ( 'ycl_check' )->find ( $id );
		$this->assign ( 'row', $row );
		return $this->fetch ();
	     }
 	
 	public function update(Request $request, $id){
 		
 		$data['uid'] = session('userid');
		$data['user_type'] = $request->post('user_type');
		$data['add_time'] = time();
		$data['is_pass'] = $request->post('is_pass');
		$data['true_name'] = $request->post('true_name');
		$data['phone'] = $request->post('phone');
		$data['addres'] = $request->post('addres');
 		
      	 if ($request->has ( 'sfz_zm', 'file' )) {
			// think\File
			// 上传文件的信息8
			$file = $request->file ( 'sfz_zm' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/sfzzm' );
			$data ['sfz_zm'] = $uploadFile->getSaveName ();
		} else {
			echo $file->getError();
		}
//		print_r($data);
//		exit;
		if ($request->has ( 'sfz_fm', 'file' )) {
			// think\File
			// 上传文件的信息
			$file = $request->file ( 'sfz_fm' );
			// 成功上传的文件信息
			$uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/sfzfm' );
			$data ['sfz_fm'] = $uploadFile->getSaveName ();
		
		} else {
			echo $file->getError();
		}
		 Db::table ( 'ycl_check' )->where ( 'id', $id )->update($data);
		return redirect ( url ('/admin/check/check'));
     		
     		}      
 	   
}
