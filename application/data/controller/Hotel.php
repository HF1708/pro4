<?php
namespace app\data\controller;
use think\Controller;
use think\captcha ;
use think\Db;
use \think\Session ;

class Hotel extends  Controller
{
    /**
     * 功能描述：小程序获取酒店信息
     * 参数：
     * 返回：酒店
     * 作者：邱萍
     * 时间：18-4-11
     */
    public function gethotel(){
        $allHotel=db('store_shotel')->select();
        echo json_encode($allHotel) ;
    }
    /**
     * 功能描述：酒店详情页
     * 参数：
     * 返回：当前点击的酒店
     * 作者：邱萍
     * 时间：18-4-12
     */
    public function hoteldeteil(){
        $hid=input('?get.hid')?input('get.hid'):'';
        $Hoteldeteil=db('store_shotel')->where(['hId'=>$hid])->select();
        echo json_encode($Hoteldeteil) ;
    }
    /**
     * 功能描述：酒店评论显示
     * 参数：
     * 返回：评论表
     * 作者：邱萍
     * 时间：18-4-12
     */
    public function hotelcomment()
    {
        $hid = input('?get.hid') ? input('get.hid') : '';
        $allcomment = db('store_shotel a')->join('store_hotelcomment b','a.hId=b.hId')->where(['hId' => $hid])->select();
       var_dump($allcomment);
        // echo json_encode($allcomment);
    }


}
