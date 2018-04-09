<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 10:41
 */

namespace app\storemanage\controller;
use think\Controller;
use think\db;
use think\Session;

class Chat extends Controller
{
    /**
     *  *  功能描述:显示客服聊天界面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-4
     **/
    public function index(){
        return $this->fetch();
    }
    public function getList(){
        $res = unserialize(Session::get('loginData')) ;
//        var_dump($res);
        $userNamw=$res['store_name'] ;
        $id=$res['store_id'] ;
        echo '{
              "code": 0
              ,"msg": ""
              ,"data": {
                "mine": {
                  "username": "'.$userNamw.'"
                  ,"id":"store_'.$id.'"
                  ,"status": "online"
                  ,"sign": ""
                  ,"avatar": "http://cdn.firstlinkapp.com/upload/2016_6/1465575923433_33812.jpg"
                }
               }
            }';
    }
    /**
     *  *  功能描述:显示平台客服聊天界面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-7
     **/
    public function pingtai(){
        return $this->fetch();
    }
}