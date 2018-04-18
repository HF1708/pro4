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
        if(empty($result)){
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('非法进入','user/login/index');
        }
        else{
            //获取用户信息
            $user_uid=$result['user_uid'];
            $where=['user_uid'=>$user_uid];
            $res = Db('user_user')->where($where)->find() ;

            //用户有登录将登录用户信息传入
            $res=$this->fetch('index',$res);
        }
        return $res;
    }
}