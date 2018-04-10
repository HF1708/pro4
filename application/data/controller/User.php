<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10
 * Time: 11:19
 */

namespace app\data\controller;
use think\Controller;


class User extends  Controller
{
    /**
     * 功能描述：小程序获取验证码
     * 参数：
     *
     * 返回：验证码
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function getCode(){
        $mobile=input("?post.mobile")?("post.mobile"):"";
        $code=$this->random(4,1);
        echo 4444;
        echo $mobile.$code;



    }
    private  function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }
}