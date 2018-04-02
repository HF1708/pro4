<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 9:49
 */
namespace app\storemanage\controller;
use think\Controller;

class Commodity extends Controller
{
    /**
     *  *  功能描述:显示商家管理后台商品管理
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-1
     **/
    public function index(){
//        //查询所有酒店
//        $where=['store_id'=>0];
//        $gethotel=db('store_shotel')->where($where)->select();
//        $count=count($gethotel);
//        $arr['code']=0;
//        $arr['msg']="";
//        $arr['count']=1000;
//        $arr['data']=$gethotel;
//
//
//        echo json_encode($arr);
        // 获取分页显示
//        $page = $gethotel->render();
        //导出酒店数组到页面
//        $this->assign("hotel",$gethotel);
//        $this->assign('count', $count);
         return $this->fetch();
    }
    /**
     *  *  功能描述:获取酒店数据
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-1
     **/
    public function shotelData(){
        //查询所有酒店
        $where=['store_id'=>0];
        $gethotel=db('store_shotel')->where($where)->select();
        $count=count($gethotel);
        $arr['code']=0;
        $arr['msg']="";
        $arr['count']=$count;
        $arr['data']=$gethotel;
        echo json_encode($arr);
    }
}





















































