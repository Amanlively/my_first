<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class AddController extends Controller
{	
    public function add()//显示页面
    {
		return $this->fetch();
    }
    
     public function save(Request $request)//保存数据
    {
		$data['name'] = $request->post('spec');
		$query = Db::table ('ycl_spec');
		// 2.操作数据(插入)
		$query->insert($data);
		return redirect ( url ( '/admin/add/add' ) );
				
    }
    public function table()//显示列表
    {
    	$rowset= Db::table('ycl_spec')->select();
    
    	$this->assign('rowset',$rowset);
		return $this->fetch();
    }
    
    public function delete($id){//删除操作
		Db::table('ycl_spec')->where('id',$id)->delete();
		return $this->redirect(url('/admin/add/table'));
	}
	
	public function edit($id){//编辑
	 	$row = Db::table ( 'ycl_spec' )->find ( $id );
		$this->assign ( 'row', $row );
		return $this->fetch ();
	     }
	
	
//	<-------------------------更新数据------------------------->
     	 public function update(Request $request, $id){
      	 $data['name']  = $request->post('spec');
		 Db::table ( 'ycl_spec' )->where ( 'id', $id )->update($data);
		return redirect ( url ('/admin/add/table'));
     	}      
}
