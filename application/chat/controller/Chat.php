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


}




