<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 23:41
 */
namespace app\platformmanage\controller;
use think\Controller;

class Advert extends Controller
{
    /**
     *  *  功能描述:显示商家发布商品页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/
    public function index()
    {
        return $this->fetch();
    }
}