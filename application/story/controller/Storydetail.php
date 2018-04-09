<?php
namespace app\story\controller;
use think\Controller;
use think\Session;

class Storydetail extends Controller
{
    /**
     *  *  功能描述：显示遊記详情页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-29
     **/
    public function storyDetail()
    {
        $sid=Session::get('sid');
        $where=['sid'=>$sid];
        $getnotes=db('user_story')->where($where)->select();
        $title=$getnotes[0]['title'];
        $userId=$getnotes[0]['userId'];
        $author=db('user')->where($userId)->select();
        $this->assign('title',$title);
        return $this->fetch();
    }
    /**
     *  *  功能描述：显示遊記的用户信息
     *  参数：id
     *  返回：用户信息
     *  作者:min H
     *  时间：18-3-30
     **/
    public function getUser(){
        $id=input('?post.id')?input('id'):"";
        $where=['userName'=>$id];
        $getuser=db('user')->where($where)->select();
        echo json_encode($getuser);
    }
    /**
     *  *  功能描述：获取遊記详情
     *  参数：id
     *  返回：遊記
     *  作者:min H
     *  时间：18-3-30
     **/
    public function getNotes(){
//        $id=input('?post.id')?input('id'):"";
//        $where=['userId'=>$id];
        $where=['sid'=>1];
        $getnotes=db('user_story')->where($where)->select();
//        $this->assign('getnotes',$getnotes);
        echo json_encode($getnotes);
    }

}
