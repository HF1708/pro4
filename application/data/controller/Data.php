<?php
namespace app\data\controller;
use think\Controller;
use think\captcha ;
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
     * 功能描述：获取经纬度数据
     * 参数：
     * QQUser：
     * 返回：推荐数据
     * 作者：yonjin L
     * 时间：18-4-12
     */
    function getLL()
    {
        $that = new \user() ;
        $the = $this ;
//        $data= "旅游";
        $data = $that->getData('name',"loginMsg","DARA_TYPE_ERROR") ;
        switch($data)
        {
            case "旅游":
                $res = $the->getTravelsLL() ;
                break ;
            case "个人中心":

                break ;
        }
        echo json_encode($res) ;
    }


    /**
     * 功能描述：获取经纬度数据（游记）
     * 参数：
     * QQUser：
     * 返回：推荐数据
     * 作者：yonjin L
     * 时间：18-4-12
     */
    function getTravelsLL()
    {
        $field = [
            'user_local_id' => "id" ,
            'user_local_lat' => "latitude" ,
            'user_local_lng' => "longitude",
            'user_local_name'=>'name' ,
            "user_local_image" => "iconPath"
        ] ;
        $res = Db("user_locations")->field($field)->select() ;


        return $res ;
    }



}




