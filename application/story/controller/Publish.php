<?php
namespace app\Publsh\controller;
use think\Controller;

class Publish extends Controller
{
    /**
     *  *  功能描述：显示故事发布页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-27
     **/
    public function publish()
    {
        return $this->fetch();
    }
}
