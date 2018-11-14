<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class ArticleController extends Controller
{	
    public function article()//显示页面
    {
		return $this->fetch();
    }
    
     public function save(Request $request)//保存数据
    {
		$data['title'] = $request->post('title');
		$data['content'] = $request->post('content');
		$data['add_time'] = time();
//		print_r($data);exit;
		$query = Db::table ('ycl_article');
		// 2.操作数据(插入)
		$query->insert($data);
		return redirect ( url ( '/admin/article/table' ) );
				
    }
    public function table ()//显示列表
    {
    	$rowset= Db::table('ycl_article')->select();
    	$this->assign('rowset',$rowset);
		return $this->fetch();
    }
    
    public function delete($id){//删除操作
		Db::table('ycl_article')->where('id',$id)->delete();
		return $this->redirect(url('/admin/article/table'));
	}
	
	public function edit($id){//编辑
	 	$row = Db::table ( 'ycl_article' )->find ( $id );
		$this->assign ( 'row', $row );
		return $this->fetch ();
	     }
	
	
//	<-------------------------更新数据------------------------->
     	 public function update(Request $request, $id){
      	        $data['title']  = $request->post('title');
      	        $data['content']  = $request->post('content');
		 Db::table ( 'ycl_article' )->where ( 'id', $id )->update($data);
		return redirect ( url ('/admin/article/table'));
     		
     		 }      

    
    
    
    
    
    
}
