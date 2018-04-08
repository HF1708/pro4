<?php
namespace app\story\controller;
use think\Controller;

class Story extends Controller
{
    /**
     *  *  功能描述：显示热门故事页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-27
     **/
    public function story()
    {
        return $this->fetch();
    }
    /**
     *  *  功能描述：获取游记
     *  参数：无
     *  返回：查询结果
     *  作者:min H
     *  时间：18-4-3
     **/
    public function getNotes(){
        
    }
}
