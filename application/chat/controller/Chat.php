<?php
namespace app\chat\controller;
use think\Controller;
use think\captcha ;
use \think\Session ;

class Chat extends Controller
{
    public function index()
    {
        $res = $this->fetch() ;
        return $res ;
    }
    /**
     * 功能描述：存储聊天对象
     * 参数：
     * QQUser：
     * 返回：聊天对象数据
     * 作者：yonjin L
     * 时间：18-3-28
     */
    public function setChatTwo()
    {

        // 获取用户
        $chatOne = unserialize(Session::get("loginData")) ;
        $chatOneType = $chatOne['userType'] ;

        // 获取聊天对象
        $chatTwo = input("?post.chatTwo") ? input("post.chatTwo"):"" ;
        $chatTwoType = input("?post.chatType") ? input("post.chatType"):"" ;

//        var_dump($chatOne) ;
//        exit ;

        // 用户未登录
        if( !$chatOne )
        {
            if( strcmp($chatTwoType,'user')==0 )
            {
                $chatTwoData = Db("user_user")->where(["user_uid"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['user_image'] ;
                $chat_two_name = $chatTwoData['user_name'] ;
            }
            else if( strcmp($chatTwoType,'store')==0 )
            {
                $chatTwoData = Db("store_info")->where(["store_phone"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['store_image'] ;
                $chat_two_name = $chatTwoData['store_name'] ;
            }
            else if( strcmp($chatTwoType,'server')==0 )
            {
                $chatTwoData = Db("backstage_user")->where(["user_uid"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['user_image'] ;
                $chat_two_name = $chatTwoData['user_name'] ;
            }
            else
            {
                $chatTwoData = Db("store_info")->where(["store_phone"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['user_image'] ;
                $chat_two_name = $chatTwoData['user_name'] ;
            }
            // 游客模式
            $data = [
                "chat_one" =>  '游客123' ,
                "chat_two" => $chatTwo ,
                "chat_two_type" => $chatTwoType ,
                "login" => 'user' ,
                'chat_one_img' =>  '' ,
                "chat_type" => 'asdf' ,
                'user' => '游客123' ,
                'chat_one_name' => '游客33' ,
                'chat_two_img' => $chat_two_image ,
                'chat_two_name' => $chat_two_name ,
            ] ;
            echo json_encode($data) ;
        }
        // 用户已登录
        else
        {

            // 将用户和聊天对象组合 存储数据到redis
            $redis = new \Redis() ;
            // 判断聊天类型(用户—》店家/客服)
            if( strcmp($chatOneType,'user')==0 )
            {
                $chatType = "user"."_".$chatOneType ;
                $user = $chatOne['user_uid'] ;
                $chat_one_image = $chatOne['user_image'] ;
                $chat_one_name = $chatOne['user_name'] ;
            }
            else if( strcmp($chatOneType,'store')==0 )
            {
                $chatType = 'store'."_".$chatOneType ;
                $user = $chatOne['store_phone'] ;
                $chat_one_image = $chatOne['store_image'] ;
                $chat_one_name = $chatOne['store_name'] ;
            }
            else
            {
                $chatType = 'server'."_".$chatOneType ;
                $user = $chatOne['user_uid'] ;
                $chat_one_image = $chatOne['user_image'] ;
                $chat_one_name = $chatOne['user_name'] ;
            }

            if( strcmp($chatTwoType,'user')==0 )
            {
                $chatTwoData = Db("user_user")->where(["user_uid"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['user_image'] ;
                $chat_two_name = $chatTwoData['user_name'] ;


            }
            else if( strcmp($chatTwoType,'store')==0 )
            {
                $chatTwoData = Db("store_info")->where(["store_phone"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['store_image'] ;
                $chat_two_name = $chatTwoData['store_name'] ;
            }
            else
            {
                $chatTwoData = Db("backstage_user")->where(["user_uid"=>$chatTwo])->find() ;
                $chat_two_image = $chatTwoData['user_image'] ;
                $chat_two_name = $chatTwoData['user_name'] ;
            }

//            redis 优化
            // 将聊天类型存入redis
//            $redis->connect('127.0.0.1',6379) ;
//            $chatTwoData = $redis->hGet('chat',$chatTwo) ;

//            // redis 中没数据
//            if( !$chatTwoData )
//            {
//                // 数据库搜索
//                $result = Db("") ;
//                // 存入redis
//
//            }
//            // redis 中有数据
//
//            $redis->hSet('chat',$chatTwo, 'hello') ;

            $data = [
                "chat_one" =>  '不是游客123' ,
                "login" => $chatOneType ,
                "chat_type" => $chatType ,
                'user' => $user ,
                'chat_two_img' => $chat_two_image ,
                'chat_two_name' => $chat_two_name ,
                'chat_one_img' => $chat_one_image ,
                'chat_one_name' => $chat_one_name
            ] ;
            echo json_encode($data) ;
        }
    }
    /**
     * 功能描述：显示 用户与商家聊天界面
     * 参数：
     * QQUser：
     * 返回：聊天对象数据
     * 作者：Qingtian Y
     * 时间：18-4-7
     */
    public function iframe_store()
    {
        $res = $this->fetch() ;
        return $res ;
    }
    /**
     * 功能描述：获取发起聊天的用户
     * 参数：
     * QQUser：
     * 返回：聊天对象数据
     * 作者：Qingtian Y
     * 时间：18-4-7
     */
    public function getUser(){
        $res = unserialize(Session::get('loginData')) ;
        $userNamw=$res['user_name'];
        $id=$res['user_id'];
        $image = $res['user_image'] ;
        echo '{
          "code": 0
          ,"msg": ""
          ,"data": {
            "mine": {
              "username": "'.$userNamw.'"
              ,"id": "user_'.$id.'"
              ,"status": "online"
              ,"sign": ""
              ,"avatar":"'.$image.'"
            }
           }
        }';
    }
}




