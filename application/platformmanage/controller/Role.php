<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 9:32
 */

namespace app\platformmanage\controller;
use think\Controller;

class Role extends  Controller
{
    /**
     *  *  功能描述:显示角色管理界面
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function index(){
        return $this->fetch();
    }
}