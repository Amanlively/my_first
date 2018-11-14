<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\File;
class UserController extends Controller
{	

	public  function user(){//用户列表
	if($user_type = input('param.user_type') == null) {
		$rowset = Db::table('ycl_user')->paginate(1);
	$this->assign ( 'rowset', $rowset );
	} else {
		if($user_type = input('param.user_type') == 1) {
	$rowset = Db::table('ycl_user')->where('user_type',1)->paginate(1);
	$this->assign ( 'rowset', $rowset );
//	print_r($rowset);exit;
	}
	
	if($user_type = input('param.user_type') == 2){
	$rowset = Db::table('ycl_user')->where('user_type',2)->paginate(1);
	$this->assign ( 'rowset', $rowset );
	}
	
	if($user_type = input('param.user_type') == 3){
	$rowset = Db::table('ycl_user')->where('user_type',3)->paginate(1);
	$this->assign ( 'rowset', $rowset ); 
		}
	}
	
	return $this->fetch();
	}
	
    public function delete($id){//删除操作
		Db::table('ycl_user')->where('id',$id)->delete();
		return $this->redirect(url('/admin/user/user'));
	}
	
	public function edit($id){//编辑
	 	$row = Db::table ( 'ycl_user' )->find ( $id );
		$this->assign ( 'row', $row );
		return $this->fetch ();
	     }
	
	
//	<-------------------------更新数据------------------------->
     	public function update(Request $request, $id){
      	  $data['user_type']  = $request->post('user_type');
      	  $data['phone']  = $request->post('phone');
      	  $data['addres']  = $request->post('addres');
      	  $data['contract_name']  = $request->post('contract_name');
		 Db::table ( 'ycl_user' )->where ( 'id', $id )->update($data);
		return redirect ( url ('/admin/user/user'));
     		
    }
    
    public function bill(){//账单列表
    	$rowset = Db::table ( 'ycl_bill' )->select();
    	$this->assign ( 'rowset', $rowset );
    	return $this->fetch();
    	
    }
    
    public function delete1($id){//删除操作
		Db::table('ycl_bill')->where('id',$id)->delete();
		return $this->redirect(url('/admin/user/bill'));
	}      
	
	
	   public function collect(){//收藏列表
    	$rowset = Db::table ( 'ycl_collect' )->select();
    	$this->assign ( 'rowset', $rowset );
    	return $this->fetch();
    	
    }
    
    public function delete2($id){//删除收藏
		Db::table('ycl_collect')->where('id',$id)->delete();
		return $this->redirect(url('/admin/user/collect'));
	}      
	
	 public function slide(){//添加幻灯片
    	$rowset = Db::table ( 'ycl_slide' )->select();
    	$this->assign ( 'rowset', $rowset );
    	return $this->fetch();
    	
    }
    
    public function save(Request $request){//账单列表
    	if ($request->has ( 'slide_one', 'file' )) {//幻灯片1
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_one' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_one']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
    	
    	if ($request->has ( 'slide_two', 'file' )) {//幻灯片2
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_two' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_two']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
		        
    	if ($request->has ( 'slide_three', 'file' )) {//幻灯片3
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_three' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_three']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
		        
    	if ($request->has ( 'slide_four', 'file' )) {//幻灯片4
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_four' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_four']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
    	
    			Db::table ( 'ycl_slide' )->insert($data);
    	return $this->redirect(url('/admin/user/image'));
    }
    public function image(){//图像
    	$rowset = Db::table ( 'ycl_slide' )->select();
    	$this->assign ( 'rowset', $rowset );
    	return $this->fetch();
    	
    }
    public function delete5($id){//删除收藏
		Db::table('ycl_slide')->where('id',$id)->delete();
		return $this->redirect(url('/admin/user/image'));
	}    
	
	
	public function edit5($id){//幻灯片编辑
	 	$row = Db::table ( 'ycl_slide' )->where('id',$id)->find( );
		$this->assign ( 'row', $row ); 
		return $this->fetch ();
	     }
	      public function update5(Request $request, $id){
      	  if ($request->has ( 'slide_one', 'file' )) {//幻灯片1
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_one' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_one']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
    	
    	if ($request->has ( 'slide_two', 'file' )) {//幻灯片2
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_two' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_two']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
		        
    	if ($request->has ( 'slide_three', 'file' )) {//幻灯片3
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_three' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_three']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
		        
    	if ($request->has ( 'slide_four', 'file' )) {//幻灯片4
			     // think\File
			     // 上传文件的信息
			    $file = $request->file ( 'slide_four' );
			     // 成功上传的文件信息
			    $uploadFile = $file->move ( \ENV::get('root_path'). '/public/static/uploads/slide' );
			    $data ['slide_four']  = $uploadFile->getSaveName ();
		        } else {
			     echo $file->getError();
		        }
    	
    			Db::table ( 'ycl_slide' )->where('id',$id)->update($data);
    	return $this->redirect(url('/admin/user/image'));
     		
    }
}