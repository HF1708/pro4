<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 14:15
 */

namespace app\user\controller;
use think\Controller;
use think\Session;
use think\Request;


class Person extends Controller
{
    public function person(){
        //显示个人中心页，判断是否登录
        $res='';
        $result=unserialize(Session::get('loginData'));
        if(empty($result)){
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('非法进入');
        }
        else{
            //用户有登录将登录用户信息传入
            $res=$this->fetch('person',$result);
        }
        return $res;
    }
    //修改个人简介
    public function changeIntro(){
        //获取登录用户ID
        $newUserMsg=input('?post.nweUserIntro')?input('post.nweUserIntro'):"";
        $result=unserialize(Session::get('loginData'));
        $user=$result['user_uid'];
        $res=db('user_user')->where('user_uid',$user)->update(['user_msg' => $newUserMsg]);
        $result=db('user_user')->where('user_uid',$user)->find();
        $result= json_encode($result);
    }

}