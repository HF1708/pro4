<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/3/30
 * Time: 15:27
 */

namespace app\platformmanage\controller;
use think\Controller;
use think\Db;

class Userbg extends Controller
{
    /**
     *  *  功能描述:显示后台用户管理页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-3-30
     **/
    public function index()
    {
        $where=[];
        $getUser=DB::table('user_user')->where($where)->paginate(5);
        $page = $getUser->render();
        $this->assign('page', $page);
        $this->assign('alluser', $getUser);
        return $this->fetch();
    }

    /**
     *  *  功能描述:用户的锁定
     *  参数：$userid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-08
     **/
    public function userlock(){
        $userid=input('?post.nowuserid') ?input('post.nowuserid'):'';
        $lock=db('user_user')->where('user_id',$userid)->update(['user_state'=>0]);
        if($lock){
            echo 1;
        }

    }

    /**
     *  *  功能描述:用户的解锁
     *  参数：$userid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-08
     **/
    public function userunlock(){
        $userid=input('?post.nowuserid') ?input('post.nowuserid'):'';
        $unlock=db('user_user')->where('user_id',$userid)->update(['user_state'=>1]);
        if($unlock){
            echo 1;
        }

    }

    /**
     *  *  功能描述:添加用户
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-08
     **/
    public function add(){
        $id=input('?post.id') ?input('post.id'):'';
        $name=input('?post.name') ?input('post.name'):'';
        $pwd=input('?post.pwd') ?input('post.pwd'):'';
        $phone=input('?post.phone') ?input('post.phone'):'';
        $sex=input('?post.sex') ?input('post.sex'):'';
        $email=input('?post.email') ?input('post.email'):'';
        $image=input('?post.image') ?input('post.image'):'';
        $birthday=input('?post.birthday') ?input('post.birthday'):'';
        $data=['user_uid'=>$id,'user_name'=>$name,'user_password'=>$pwd,'user_email'=>$email,'user_phone'=>$phone,'user_sex'=>$sex,'user_image'=>$image];
        $adduser=db('user_user')->insert($data);
        if($adduser){
            echo 1;
        }

    }

    /**
     *  *  功能描述:删除用户
     *  参数：$userid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-08
     **/
    public function userdelect(){
        $userid=input('?post.delectid') ?input('post.delectid'):'';
        $delect=db('user_user')->where('user_id',$userid)->delete();
        if($delect){
            echo 1;
        }

    }

    /**
     *  *  功能描述:修改用户
     *  参数：$userid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-08
     **/
    public function change(){
        $userid=input('?post.changeid') ?input('post.changeid'):'';
        $name=input('?post.name') ?input('post.name'):'';
        $pwd=input('?post.pwd') ?input('post.pwd'):'';
        $phone=input('?post.phone') ?input('post.phone'):'';
        $data=['user_name'=>$name,'user_password'=>$pwd,'user_phone'=>$phone];
        $change=db('user_user')->where('user_uid',$userid)->update($data);
        var_dump($change);
        if($change){
            echo 1;
        }
    }

}

