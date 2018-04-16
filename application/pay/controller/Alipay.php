<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/11
 * Time: 11:22
 */
namespace app\pay\controller;
use think\Controller;
use \think\Loader;
use \think\Db;

class Alipay extends Controller
{
    /**
     * 功能描述：支付宝支付
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function index(){
//        Loader::import('alipaydemo.index', EXTEND_PATH);
       return $this->fetch();
    }
    public function notify_url(){
        Loader::import('alipaydemo.notify_url', EXTEND_PATH);
    }
    /**
     * 功能描述：付款成功后跳转至
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function return_url(){
        Loader::import('alipaydemo.return_url', EXTEND_PATH);
    }
    /**
     * 功能描述：链接至阿里付款
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function pagepay(){
        Loader::import('alipaydemo.pagepay.pagepay', EXTEND_PATH);
    }

    /**
     * 功能描述：获取订单信息
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function getOrderInfo(){
        $hid=input('?get.hId')?input("hId"):"";
        //数据库查询到对应id的酒店信息
        $where=['hId'=>$hid];
        $getnowhotel=db('store_shotel')->where($where)->select();
        echo json_encode($getnowhotel);
    }
    /**
     * 功能描述：获取订单是否支付
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function ispay(){
        $WIDout_trade_no=input('?get.WIDout_trade_no')?input("WIDout_trade_no"):"";
        $where=["hoId"=>$WIDout_trade_no];
        $re=db("store_hotelorder")->where($where)->select();
        if(!empty($re)){
            if($re[0]['orderstate']=="1"){
                $arr['code']=1000;
                $arr['msg']="支付成功";
                $arr['data']=[];
                echo json_encode($arr);
                exit();
            }else{
                $arr['code']=1001;
                $arr['msg']="支付失败 ";
                $arr['data']=[];
                echo json_encode($arr);
                exit();
            }
        }else{
            $arr['code']=1001;
            $arr['msg']="支付失败 ";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }
    }
    /**
     * 功能描述：退款
     * 参数：
     * 返回：
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function refund(){
        Loader::import('alipaydemo.pagepay.refund', EXTEND_PATH);
    }
}