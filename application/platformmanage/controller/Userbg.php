<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/3/30
 * Time: 15:27
 */

namespace app\platformmanage\controller;
use think\Controller;

class Userbg extends Controller
{
    /**
     *  *  功能描述:显示后台用户管理页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-3-30
     **/
    public function index()
    {
        return $this->fetch();
    }
}