<?php
namespace app\storemanage\controller;
use think\Controller;
use think\Session;
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

        //查询登录的用户
        $userName="汤臣";
        $user=Session::get("loginData");
        $this->assign("userName",$userName);
        return $this->fetch();
    }
    /**
     *  *  功能描述:显示商家管理后台主页
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/
    public function main()
    {
        return $this->fetch();
    }
    /**
     *  *  功能描述:显示商家信息
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/
    public function info(){
        return $this->fetch();
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
            if( strcmp($res['userType'],'store')==0 )
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
                    "name" =>  $res['store_name'] ,
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
    /**
     *  功能描述:获取商家信息
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-3
     **/
    public function getinfo(){

        // 如果单前页面不在登录页面，则为N 否则为Y
        $url =  strcmp(strstr($_SERVER['HTTP_REFERER'],"/login/index.html"),"/login/index.html")==0 ? "Y":"N";

        // 查询用户是否登录
        $msg = new \user() ;
        if( Session::has('loginData') )
        {
            $res = unserialize(Session::get('loginData')) ;
            if( strcmp($res['userType'],'store')==0 )
            {
                $data = [
                    "name" =>  $res['store_name'] ,
                    "store_phone" =>  $res['store_phone'] ,

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
