<?php
namespace app\store\controller;

use think\Controller;
use think\db;

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
        //数据库查询到所有酒店
        $gethotel=db('store_shotel')->where([])->select();
        //导出酒店数组到页面
        $this->assign("hotel",$gethotel);
        return $this->fetch();
    }
    /**
     *  功能描述：动态显示酒店页面内容
     *  参数：输入框中城市名（cityChoice）和输入框中酒店名（hotelChoice）
     *  返回：数据库结果
     *  作者:邱萍
     *  时间：18-03-27
     **/
    public function getHotel()
    {
        //input获取参数在tp框架中可以自动过滤xss攻击和sql注入等
        $cityChoice=input('?post.cityChoice')?input('post.cityChoice'):'';
        $hotelChoice=input('?post.hotelChoice')?input('?post.hotelChoice'):'';
        //调接口获取数据
//        $gethotel=new \ curl();
//        $data=[];
//        $result=$gethotel->curlHttp("http://api.shujuzhihui.cn/api/hotel/search",'POST',["appKey"=>"2535ac5bbec441548fa9e57834a3fc49"]);
//       var_dump($result);


    }

}
