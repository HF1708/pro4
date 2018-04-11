<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/11
 * Time: 11:22
 */
use think\Controller;
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
        $AlipayClient alipayClient = new DefaultAlipayClient(URL,APP_ID,APP_PRIVATE_KEY,FORMAT,CHARSET,ALIPAY_PUBLIC_KEY,SIGN_TYPE);

    }
}