<?php
namespace app\platformmanage\controller;
use think\Controller;
use think\Session ;

class Index extends Controller
{
    /**
     *  *  功能描述:显示商家管理后台框架
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/

    public function index()
    {

        return $this->fetch() ;

    }

    public function main()
    {

        return $this->fetch() ;

    }

    /**
     *  *  功能描述:登录
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function login()
    {
        $that = new \user() ;

        // 获取用户消息
        $user = $that->getData("user","loginMsg","ACCOUNT_ERROR") ;
        $password = $that->getData("password","loginMsg","ACCOUNT_ERROR") ;

        // 开始登录
        $where = [
           "user_uid" =>  $user ,
           "user_password" =>  md5($password)
        ] ;
        $res = Db("backstage_user")->where($where)->find() ;
        // 判断是否存在用户
        // 没有返回报错消息
        $that->emptyData($res,"loginMsg","ACCOUNT_ERROR") ;
        // 否则用户存在
        // 将信息存入SESSION
            // 1.设置type为server（后台人员专用）
        $res['userType'] = "server" ;
            // 2.存入SESSION
        Session::set('loginData',serialize($res)) ;

//        echo "asd" ;
        return $this->fetch("index") ;

    }

    /**
     *  功能描述:用户是否登录
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-2
     **/
    public function backstageLoginAlready()
    {

        // 如果单前页面不在登录页面，则为N 否则为Y
        $url =  strcmp(strstr($_SERVER['HTTP_REFERER'],"/login/index.html"),"/login/index.html")==0 ? "Y":"N";

        // 查询用户是否登录
        $msg = new \user() ;
        if( Session::has('loginData') )
        {
            $res = unserialize(Session::get('loginData')) ;
            if( strcmp($res['userType'],'server')==0 )
            {
                // 没头像用默认
                if( empty($res['user_image']) )
                {
                    $image = config("default")["IMAGE_USER"] ;
                }
                else
                {
                    $image = config("default")["IMAGE_USER"] ;
                }
                $data = [
                    "name" =>  $res['user_name'] ,
                    "image" =>  $image
                ] ;
                // 返回用户信息
                $msg->returnJson("loginMsg","SUCCESS",$data,10000) ;
            }
            else
            {

                // 返回未登录信息
                $msg->returnJson("loginMsg","UPDATA_ERROR") ;

            }
        }
        else
        {
            $data = [
                "setJump" => $url
            ] ;
            // 返回用户信息
            // 返回未登录信息
            $msg->returnJson("loginMsg","UPDATA_ERROR",$data) ;
        }



    }

}
