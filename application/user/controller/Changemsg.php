<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 15:00
 */

namespace app\user\controller;
use think\Controller;
use think\Session;
use think\Request;

class Changemsg extends Controller
{
    public function index(){

        $res='';
        $result=unserialize(Session::get('loginData'));
        if(empty($result)){
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('非法进入');
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
    /**
     * 功能描述：修改用户简介信息
     * 参数：
     * QQUser：
     * 返回：用户简介信息
     * 作者：Lin YiZhe
     * 时间：18-3-29
     */
    public function changeMsg(){
        $user_name=input('?post.uName')?input('post.uName'):"";
        $user_uid=input('?post.uid')?input('post.uid'):"";
        $user_sex=input('?post.sex')?input('post.sex'):"";
        $user_email=input('?post.uEmail')?input('post.uEmail'):"";
        $user_msg=input('?post.uIntro')?input('post.uIntro'):"";
        $user_phone=input('?post.uPhone')?input('post.uPhone'):"";
        $data=[
            'user_name'=>$user_name,
            'user_sex'=>$user_sex,
            'user_email'=>$user_email,
            'user_msg'=>$user_msg,
            'user_phone'=>$user_phone
        ];
        // 更新数据表中的数据
        $res=db('user_user')->where('user_uid',$user_uid)->update($data);
        var_dump($res);

    }
}