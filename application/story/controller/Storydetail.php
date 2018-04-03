<?php
namespace app\story\controller;
use think\Controller;

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
     *  *  功能描述：显示遊記的用户信息
     *  参数：id
     *  返回：遊記
     *  作者:min H
     *  时间：18-3-30
     **/
    public function getNotes(){
        $id=input('?post.id')?input('id'):"";
        $where=['userId'=>$id];
        $getnotes=db('user_story')->where($where)->select();
        $count=count($getnotes);
        $arr['code']=0;
        $arr['msg']="";
        $arr['count']=$count;
        $arr['data']=$getnotes;
        echo json_encode($arr);
    }
}
