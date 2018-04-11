<?php
namespace app\data\controller;
use think\Controller;
use think\captcha ;
use think\Db;
use \think\Session ;

class Data extends Controller
{

    /**
     * 功能描述：获取推荐
     * 参数：
     * QQUser：
     * 返回：推荐数据
     * 作者：yonjin L
     * 时间：18-4-10
     */
    function getRecommend()
    {
        $res = Db("user_story")->select() ;
        echo json_encode($res) ;
    }

    /**
     * 功能描述：获取
     * 参数：
     * QQUser：
     * 返回：推荐数据
     * 作者：yonjin L
     * 时间：18-4-10
     */

}




