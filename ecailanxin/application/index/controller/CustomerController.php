<?php
namespace app\index\controller;
use function PHPSTORM_META\type;
use think\Controller;
use think\Request;
use think\Db;
use think\File;

class CustomerController extends Controller
{
    public function save_message(){

        $message = $_POST['message'];

        $data = array(
            'fromid'   => $message['fromid'],
            'fromname' => $this->getName($message['fromid']),
            'toid'     => $message['toid'],
            'toname'   => $this->getName($message['toid']),
            'content'  => $message['content'],
            'addtime'  => $message['time'],
            'status'   => 1,
            'issee'    => $message['issee'],
        );
        Db::table('ycl_customer')->insert($data);
    }




    //根据用户ID获取用户名称
    public function getName($userid){

       $usernaem = Db::table('ycl_user')->where('id',$userid)->value('username');
        return $usernaem;
    }

    /*
     * 返回用户头像以及名称
     */
    public function chat_head(){
        $fromid = $_POST['fromid'];
        $toid = $_POST['toid'];

        $fromhead = Db::name('user')->where('id',$fromid)->value('image');
        $tohead = Db::name('user')->where('id',$toid)->value('image');
        return [
            'fromhead' => $fromhead,
            'tohead'   => $tohead,
            'fromname' => $this->getName($fromid),
            'toname' => $this->getName($toid),
        ];
    }

    /*
     * 返回聊天记录
     * */
    public function chat_record(){

        $fromid = $_POST['fromid'];
        $toid = $_POST['toid'];

        $count = Db::name('customer')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',['fromid' => $fromid , 'toid' => $toid , 'toid1' => $toid , 'fromid1' => $fromid])->order('addtime','asc')->count('id');

        if($count > 10){
            $chat = Db::name('customer')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',['fromid' => $fromid , 'toid' => $toid , 'toid1' => $toid , 'fromid1' => $fromid])->order('addtime','asc')->limit($count-10,10)->select();

        }else{
            $chat = Db::name('customer')->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',['fromid' => $fromid , 'toid' => $toid , 'toid1' => $toid , 'fromid1' => $fromid])->order('addtime','asc')->select();
        }
        return $chat;
    }

    /*
     * 聊天图片上传
     * */
    public function img_up(){
        $file = $_FILES['file'];
        $fromid = $_POST['fromid'];
        $toid = $_POST['toid'];
        $online = $_POST['online'];
        $suffix = strtolower(strrchr($file['name'],'.'));
        $type = ['.jpg','.jpeg','.gif','.png'];
        if(!in_array($suffix,$type)){
            return ['status' => '图片格式错误！'];
        }
        if($file['size']/1024 > 5120){
            return ['status' => '图片尺寸过大！'];
        }
        $filename = uniqid('chat_img',false);
        $uploadpath = \Env::get('root_path').'/public/static/uploads/chat_img/';

        $file_up = $uploadpath.$filename.$suffix;

        $rs = move_uploaded_file($file['tmp_name'],$file_up);
        
        if($rs){
            $name = $filename.$suffix;
            $data = [
                'content' => $name,
                'fromid' =>$fromid,
                'fromname' => $this->getName($fromid),
                'toid'    => $toid,
                'toname' => $this->getName($toid),
                'addtime' => time(),
                'status' => 2,
                'issee' => $online,
            ];

            $img_id = Db::name('customer')->insert($data);
            if($img_id){
                return ['status' => 'ok' , 'img_name' => $name];
            }else{
                return ['status' => false];
            }

//            return [];
        }

    }

    public function customer(){
		
		if(session('userid') == null || session('phone') == null){
			return $this->redirect('/index/login/login');
		}
		
		
        $fromid = input('fromid');
        $toid = input('toid');
        $this->assign('fromid',$fromid);
        $this->assign('toid',$toid);

        return $this->fetch();
    }

    /**
     * 查找聊天列表
     */
    public function Chat_list(){

        $fromid = $_POST['fromid'];
        $rs = Db::name('customer')->field(['fromid','toid','addtime','content','fromname'])->where('toid',$fromid)->group('fromid')->select();

        $rows = array_map(function ($res){
            return [
                'head_img' => $this->head_img($res['fromid']),
                'username' => $res['fromname'],
                'countNoread'=> $this->count_noread($res['fromid'],$res['toid']),
                'last_message' => $this->last_message($res['fromid'],$res['toid']),
                'chat_path'  => 'http://zq.zhangqi.com/index/customer/customer/fromid/'.$res['toid'].'/toid/'.$res['fromid'].'',

                ];
        },$rs);

        return $rows;

    }

    /**
     * 根据id返回头像
     */
    public function head_img($userid){

        $head = Db::name('user')->where('id',$userid)->value('image');
        return $head;
    }

    /**
     * 返回未读条数
     */
    public function count_noread($fromid,$toid){

        return Db::name('customer')->where(['fromid' => $fromid ,'toid' => $toid ,'issee' => 2])->count();
    }

    /**
     * 返回最后一条消息内容
     */
    public function last_message($fromid,$toid){

        $info = Db::name('customer')->where('(fromid=:fromid&&toid=:toid)||(fromid=:fromid2&&toid=:toid2)',['fromid'=>$fromid,'fromid2'=>$toid,'toid'=>$toid,'toid2'=>$fromid])->order('id DESC')->limit(1)->find();

        return $info;
    }

    /**
     * 修改未读状态
     */
    public function is_read(){

        $fromid = $_POST['fromid'];
        $toid = $_POST['toid'];
        $info = Db::name('customer')->where('(fromid=:fromid&&toid=:toid)||(fromid=:fromid2&&toid=:toid2)',['fromid'=>$fromid,'fromid2'=>$toid,'toid'=>$toid,'toid2'=>$fromid])->update(['issee' => 1]);

    }

    /**
     *
     * 总未读条数
     */
    public function sum_isread(){

        $fromid = session('userid');
        $info = Db::name('customer')->where('toid',$fromid)->where('issee',2)->count();
        return $info;
    }
}