<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 11:20
 */
namespace app\user\controller;
use think\Controller;
use think\Session;

class Changeperson extends Controller
{
    //显示修改页面
    public function index(){
        $res='';
        $result=unserialize(Session::get('loginData'));
        return $this->fetch('index',$result);
    }
}