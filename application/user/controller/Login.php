<?php
namespace app\user\controller;
use think\Controller;
use think\captcha ;
class Login extends Controller
{
    public function index()
    {

        $res = $this->fetch() ;
        return $res ;
    }
    /**
     * 功能描述：用户登录
     * 参数：
     * QQUser：
     * 返回：登录结果信息
     * 作者：yonjin L
     * 时间：18-3-24
     */
    public function login()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['ACCOUNT_ERROR'] ,
            'data' => []
        ] ;
        $name = input("?post.name") ? input("post.name") : '' ;
        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;
        $code = input("?post.code") ? input("post.code") : '' ;

        // 验证码是否为空
        if( empty($code) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['CODE_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
        // 用户名获密码是否为空
        if( empty($name) || empty($pwd)  )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['ACCOUNT_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        $where = [
           "user_uid" => $name ,
            "user_password" => md5($pwd)
        ] ;
        // 验证码是否正确
        if( !captcha_check($code) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['CODE_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            return ;
        }
        // 是否存在用户
        $res = Db('user_user')->where($where)->find() ;
        if( !empty($res) )
        {
            $returnJson = [
                'code' => 10000 ,
                'msg' => config('loginMsg')['SUCCESS'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        echo json_encode($returnJson) ;

    }

    /**
     * 功能描述：手机登录
     * 参数：
     * QQUser：
     * 返回：登录结果信息
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function phoneLogin()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['PHONE_EMPTY'] ,
            'data' => []
        ] ;
//        $name = input("?post.name") ? input("post.name") : '' ;
//        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;

        echo json_encode($returnJson) ;
    }

    /**
     * 功能描述：查看手机是否存在存在发送短信验证码
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function phoneGetMsg()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['PHONE_EMPTY'] ,
            'data' => []
        ] ;
//        $name = input("?post.name") ? input("post.name") : '' ;
//        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;

        echo json_encode($returnJson) ;
    }



}




