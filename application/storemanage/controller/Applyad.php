<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/3
 * Time: 0:22
 */

namespace app\storemanage\controller;
use think\Controller;

class Applyad extends Controller
{
    /**
     *  *  功能描述:显示广告申请页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-3
     **/
    public function index(){
        return $this->fetch();
    }
    /**
     *  *  功能描述:广告申请提交事件
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-3
     **/
    public function applyad(){

        $file = $_FILES['file'] ;
        $obj=new \user();
        $re=$obj->uploadImage($file);
        echo $re;


    }
}