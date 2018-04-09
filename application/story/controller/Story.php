<?php
namespace app\story\controller;
use think\Controller;
use think\Session;

class Story extends Controller
{
    /**
     *  *  功能描述：显示热门故事页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-27
     **/
    public function story()
    {
        return $this->fetch();
    }
    /**
     *  *  功能描述：获取游记
     *  参数：无
     *  返回：查询结果
     *  作者:min H
     *  时间：18-4-3
     **/
    public function getNotes(){
        $getnotes=db('user_story')->select();
        $notes=json_encode($getnotes);
        return $notes;
    }
    /**
     *  *  功能描述：当前点击的游记id存入session
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-4-09
     **/
    public function setStory(){
        $sid=input('?post.sid')?input('sid'):"";
        if(Session::has('sid')){
            Session::delete('sid');
        }else{
            Session::set('sid',$sid);
        }
    }
}
