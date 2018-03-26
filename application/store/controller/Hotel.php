<?php
namespace app\store\controller;

use think\Controller;

class Hotel extends Controller
{
    /**
     *  功能描述：显示酒店页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-03-26
     **/
    public function hotel()
    {

        return $this->fetch();
    }
}
