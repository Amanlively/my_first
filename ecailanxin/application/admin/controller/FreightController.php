<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:37
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;

class FreightController extends  Controller{

        public  function  freight(){ //添加运费
            $city = Db::table('ycl_city')->field('id,city_name')->select();
//            print_r($city);die;
            $this->assign('city',$city);
            return $this->fetch();
        }

        public function save(){ // 保存运费
            $data['freight_money'] = input('post.money');//起步价
            $data['priceofkm'] = input('post.priceofkm');//公里价
            $data['city']      = input('post.city');//公里价

            Db::table('ycl_freight')->insert($data);
//            print_r($city);
        return redirect('/admin/freight/yunlist');
        }

        public function yunlist(){ //显示列表
            $freight = Db::table('ycl_freight')->field('id,freight_money,priceofkm,city')->select();
            $this->assign('freight',$freight);
            return $this->fetch();
        }

    public function del($id){ //显示列表
        $freight = Db::table('ycl_freight')->where('id',$id)->delete();
        //$this->assign('freight',$freight);
        return redirect('/admin/freight/yunlist');

    }

    public function edit($id){ //显示列表
        $freight = Db::table('ycl_freight')->where('id',$id)->find();
        $this->assign('freight',$freight);
        return $this->fetch();

    }


    public function update($id){ // 更新运费
        $data['freight_money'] = input('post.money');//起步价
        $data['priceofkm'] = input('post.priceofkm');//公里价
        $data['city']      = input('post.city');//公里价

        Db::table('ycl_freight')->where('id',$id)->update($data);
//            print_r($city);
        return redirect('/admin/freight/yunlist');
    }


    public function widthdrawday(){ // 添加配送员体检天数
        return $this->fetch();
    }

    public function saveday(){ // 保存配送员体检天数
        $data['withdraw_day'] = input('post.day');//起步价
        Db::table('ycl_withdrawday')->insert($data);
        return redirect('/admin/freight/daylist');
    }

    public function daylist(){ // 配送员体检天数
        $rowset = Db::table('ycl_withdrawday')->select();
        $this->assign('rowset',$rowset);
        return $this->fetch();
    }

    public function dayedit(){ // 是否应用修改标志
        $id      = input('param.id');
        $data['status'] = 1;
        $rowset = Db::table('ycl_withdrawday')->where('id !=0')->update(['status'=>0]);
        if($rowset){
            $rowset = Db::table('ycl_withdrawday')->where('id',$id)->update($data);
        }
        $this->assign('rowset',$rowset);
        return redirect('/admin/freight/daylist');
    }

    public function daydel(){//删除
        $id      = input('param.id');
        Db::table('ycl_withdrawday')->where('id',$id)->delete();
        return redirect('/admin/freight/daylist');
    }
}
