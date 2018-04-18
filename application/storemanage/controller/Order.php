<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 14:52
 */

namespace app\storemanage\controller;
use think\Controller;
use think\Db;
use \think\Loader;

class Order  extends Controller
{
    /**
     *  *  功能描述:显示订单页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function index(){
        return $this->fetch();
    }
    /**
     *  *  功能描述:获取酒店订单数据
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function hotelOrderData(){
        $storeID=0;

//        $a=new Model();
//        $a->query("SELECT *FROM store_shotel,store_hotelorder WHERE store_shotel.store_id=0 AND store_shotel.hId=store_hotelorder.huId");
        $join=[
            ["store_shotel a","b.huId=a.hId"]
        ];
        $where=["a.store_id"=>$storeID];
        $re=DB::table("store_hotelorder")->alias('b')->join($join)->where($where)->select();
        $count=count($re);
        $arr['code']=0;
        $arr['msg']="";
        $arr['count']=$count;
        $arr['data']=$re;
        echo json_encode($arr);
    }
    /**
     *  *  功能描述:取消酒店订单
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function cancel(){
        $hotelID=input("?post.hoId")?input("post.hoId"):"";
        $re=db('store_hotelorder')->where('hoId',$hotelID)->setField('orderstate', '2');
        if($re==1){
            $returnJson = [
                'code' => 10000 ,
                'msg' => "操作成功" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }else{
            $returnJson = [
                'code' => 10001,
                'msg' => "操作失败" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }
    }
    /**
     *  *  功能描述:手动使用订单
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function useOrder(){
        $hotelID=input("?post.hoId")?input("post.hoId"):"";
        $re=db('store_hotelorder')->where('hoId',$hotelID)->setField('orderstate', '2');
        if($re==1){
            $returnJson = [
                'code' => 10000 ,
                'msg' => "操作成功" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }else{
            $returnJson = [
                'code' => 10001,
                'msg' => "操作失败" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }
    }
    /**
     *  *  功能描述:退款
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function refund(){
//        $hotelID=input("?post.WIDTRout_trade_no")?input("post.WIDTRout_trade_no"):"";
//        $hotelID = trim(input("?post.WIDTRout_trade_no")?input("post.WIDTRout_trade_no"):"");
//        echo $hotelID;
        Loader::import('alipaydemo.pagepay.refund', EXTEND_PATH);


//        $re=db('store_hotelorder')->where('hoId',$hotelID)->setField('orderstate', '2');
//        if($re==1){
//            $returnJson = [
//                'code' => 10000 ,
//                'msg' => "操作成功" ,
//                'data' => []
//            ] ;
//            echo json_encode($returnJson);
//        }else{
//            $returnJson = [
//                'code' => 10001,
//                'msg' => "操作失败" ,
//                'data' => []
//            ] ;
//            echo json_encode($returnJson);
//        }
    }
}