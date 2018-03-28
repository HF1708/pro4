<?php
namespace app\storemanage\controller;
use think\Controller;

class Index extends Controller
{
    /**
     *  *  功能描述:显示商家管理后台框架
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/

    public function index()
    {
        //查询登录的用户
        $userName="汤臣";
        $this->assign("userName",$userName);
        return $this->fetch();
    }
    /**
     *  *  功能描述:显示商家管理后台主页
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/
    public function main()
    {
        return $this->fetch();
    }
}
