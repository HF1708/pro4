<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/26
 * Time: 14:34
 */
namespace app\attractions\controller;
use think\Controller;

class Attractions extends Controller
{
    #显示景点页面
    public function attractions(){
        return $this->fetch();
    }
}