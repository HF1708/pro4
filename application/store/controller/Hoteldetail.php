<?php
namespace app\store\controller;

use think\Controller;
use think\db;//数据库
use think\Session ;


class Hoteldetail extends Controller
{
    /**
     *  功能描述：显示酒店详情页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-03-26
     **/
    public function hoteldetail()
    {
        $hid=input('?get.hId')?input("hId"):"";
        //数据库查询到对应id的酒店信息
        $where=['hId'=>$hid];
        $getnowhotel=db('store_shotel')->where($where)->select();
        //导出当前酒店到页面
        $this->assign("nowHotel",$getnowhotel);
        $getcomment=db('store_hotelcomment')->where($where)->select();
        $this->assign('comment',$getcomment);
        return $this->fetch();
    }

    /**
     *  功能描述：添加评论
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-04-01
     **/
    public function addcommend(){
        $hid=input('?get.hId')?input("hId"):"";
        $comment=input('?post.commentdinput')?input('post.commentdinput'):"";
        //获取当前时间
        $time=date("Y/m/d H:i:s",time());
        $user=Session::get('loginData');
        echo $user;
        //数据库查询到对应id的酒店信息
        $data=['hcContent'=>$comment,'hId'=>$hid,'hcTime'=>$time,'userId'=>1001];
        $addcommend=db('store_hotelcomment')->insert($data);
    }
}
