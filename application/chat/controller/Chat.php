<?php
namespace app\chat\controller;
use think\Controller;
use think\captcha ;
use \think\Session ;

class Chat extends Controller
{
    public function index()
    {

        $chat_one = input("?get.chat_one")? input("get.chat_one"):'' ;
        $this->assign('domain',$chat_one) ;
        $res = $this->fetch() ;
        return $res ;
    }


}




