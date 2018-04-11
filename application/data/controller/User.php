<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10
 * Time: 11:19
 */

namespace app\data\controller;
use think\Controller;
use \think\Loader;
use \think\Db;

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
        $mobile=input("?post.mobile")?input("post.mobile"):"";
        $code=$this->random(4,1);
        //短信接口地址
        $arr=["code"=>"1000","mobileCode"=>$code];
        $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
        $post_data = "account=C04379329&password=2c0fb86fa2aa9edf8b7b9a9198d2f495&mobile=" . $mobile . "&content=" . rawurlencode("您的验证码是：" . $code . "。请不要把验证码泄露给其他人。");
//用户名是登录用户中心->验证码短信->产品总览->APIID
        $gets = $this->xml_to_array($this->Post($post_data, $target));
        if ($gets['SubmitResult']['code'] == 2) {
            $arr=["code"=>"1000","mobileCode"=>$code,"mobile"=>$mobile];
            echo json_encode($arr);
            exit();
        }
        $arr=["code"=>"1001","mobileCode"=>"","mobile"=>""];
        echo json_encode($arr);
        exit();
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
    //请求数据到短信接口，检查环境是否 开启 curl init。
    public function Post($curlPost, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }
//将 xml数据转换为数组格式。
    public function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = $this->xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }
    /**
     * 功能描述：小程序登录，用户手机未注册 自动注册
     * 参数：
     * 返回：验证码
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function login(){
        $mobile=input("?post.mobile")?input("post.mobile"):"";
        $where=["user_phone"=>$mobile];
        $re=\db("user_user")->where($where)->select();
        if(!empty($re)){
            echo json_encode($re);
        }else{
            $time=time();
            $data=["user_name"=>"手机用户".$mobile,"user_phone"=>$mobile,"user_time"=>$time,"user_state"=>1,"user_image"=>"http://p6gnb5g93.bkt.clouddn.com/184259d34cf7b25692ffa080f2c2a66505ebab08.jpg"];
//            $re=\db("user_user")->insert();
            $re=Db::table('user_user')->insert($data);
            if($re){
                $re=\db("user_user")->where($where)->select();
                if(!empty($re)) {
                    echo json_encode($re);
                }
            }
        }
    }
}