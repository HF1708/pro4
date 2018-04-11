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
}
