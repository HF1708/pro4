<?php
namespace app\user\controller;
use think\Controller;


class Register extends Controller
{
    public function index()
    {
        $res = $this->fetch() ;
        return $res ;
    }

    /**
     * 功能描述：用户注册
     * 参数：
     * QQUser：
     * 返回：注册是否成功
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function register()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['ACCOUNT_ERROR'] ,
            'data' => []
        ] ;
        $name = input("?post.name") ? input("post.name") : '' ;
        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;
        $pwd2 = input("?post.pwd2") ? input("post.pwd2") : '' ;
        $code = input("?post.code") ? input("post.code") : '' ;
        $phone = input("?post.phone") ? input("post.phone") : '' ;
        $data = [
            "user_uid" => $name ,
            "user_password" => md5($pwd) ,
            "user_phone" => $phone
        ] ;
        // 手机号码是否为空
        if( empty($phone) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['PHONE_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 验证码是否为空
        if( !empty($code) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['CODE_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
        // 验证码是否正确
        if(1){

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
            "user_uid" => $name
        ] ;
        // 用户名是否已存在
        $userEmp = Db("user_user")->where($where)->find() ;
        // 用户名是否已存在
        if( !empty($userEmp) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['ACCOUNT_REPEAT'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 插入数据
        $res = Db("user_user")->insert($data) ;
        $returnJson = [
            'code' => 10000 ,
            'msg' => config('loginMsg')['REGISTER_SUCCESS'] ,
            'data' => []
        ] ;
        echo json_encode($returnJson) ;
    }
    /**
     * 功能描述：店家注册
     * 参数：
     * QQUser：
     * 返回：注册是否成功
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function phoneRegister()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['PHONE_EMPTY'] ,
            'data' => []
        ] ;

        echo json_encode($returnJson) ;
    }

}