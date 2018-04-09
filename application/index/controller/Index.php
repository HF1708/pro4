<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    /**
     *  *  功能描述：显示首页
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-26
     **/
    public function index()
    {
        $allHotel=db('store_shotel')->where([])->select();
        //导出酒店数组到页面
        $this->assign("allhotel",$allHotel);
        return $this->fetch();
    }

}
