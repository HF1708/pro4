<?php
namespace app\store\controller;
use \think\Controller;
class Application extends Controller
{
    /**
     *  *  功能描述：显示商家 入驻页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-26
     **/
    public function storeEnter()
    {
        return $this->fetch();
    }
}
