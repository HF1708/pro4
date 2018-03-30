<?php
namespace app\store\controller;

use think\Controller;
use think\db;//数据库


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
        return $this->fetch();
    }
}
