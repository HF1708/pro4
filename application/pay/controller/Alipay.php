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
class Alipay extends Controller
{
    /**
     * 功能描述：支付宝支付
     * 参数：
     * 返回：验证码
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
    public function return_url(){
        Loader::import('alipaydemo.return_url', EXTEND_PATH);
    }
    public function pagepay(){
        Loader::import('alipaydemo.pagepay.pagepay', EXTEND_PATH);
    }
    public function getOrderInfo(){
        $hid=input('?get.hId')?input("hId"):"";
        //数据库查询到对应id的酒店信息
        $where=['hId'=>$hid];
        $getnowhotel=db('store_shotel')->where($where)->select();
        echo json_encode($getnowhotel);
    }
}