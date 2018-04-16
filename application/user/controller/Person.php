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
use think\Paginator;


class Person extends Controller

{
    public function index(){
        //显示个人中心页，判断是否登录
        $res='';
        $result=unserialize(Session::get('loginData'));
        if(empty($result)){
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('非法进入');
        }
        else{
            //获取用户信息
            $user_id=$result['user_id'];
            $where=['user_id'=>$user_id];
            $res = Db('user_user')->where($where)->find() ;


            //获取当前用户的游记
            $getnotes=db('user_story')->where('userId',$user_id)->paginate(3);
            // 获取分页显示
            $page = $getnotes->render();
            $this->assign('notes',$getnotes);
            $this->assign('page',$page);
            //用户有登录将登录用户信息传入
            $res=$this->fetch('index',$res);
        }
        return $res;
    }
    //获取个人简介
    /**
     * 功能描述：获取用户简介信息
     * 参数：
     * QQUser：
     * 返回：用户简介信息
     * 作者：Lin YiZhe
     * 时间：18-3-29
     */
    public function getIntro(){
        $user_uid=input('?post.user_uid')?input('post.user_uid'):"";
        $res=db('user_user')->where('user_uid',$user_uid)->find();
        echo json_encode($res);
    }
    /**
     * 功能描述：修改用户简介信息
     * 参数：
     * QQUser：
     * 返回：1或0
     * 作者：Lin YiZhe
     * 时间：18-3-29
     */
    public function changeIntro(){
        //获取登录用户ID
        $newUserMsg=input('?post.nweUserIntro')?input('post.nweUserIntro'):"";
        $result=unserialize(Session::get('loginData'));
        $user=$result['user_uid'];
        $res=db('user_user')->where('user_uid',$user)->update(['user_msg' => $newUserMsg]);
        echo $res;
    }

}