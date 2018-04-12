<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10
 * Time: 11:19
 */

namespace app\data\controller;
use think\Controller;


class Notes extends  Controller
{
    /**
     * 功能描述：小程序获取游记
     * 参数：无
     * 返回：游记数组
     * 作者：min H
     * 时间：18-4-10
     */
    public function getNotes(){
        //获取游记列表
        $getnotes=db('user_story a')->join('user_user b','a.userId=b.user_id')->select();
        $notes=json_encode($getnotes);
        echo $notes;
    }
    public function getItem(){
        $sid=input('?get.sid')?input('get.sid'):"";
        $where=[
            'sid'=>$sid
        ];
        $getitem=db('user_story a')->join('user_user b','a.userId=b.user_id')->where($where)->select();
        $item=json_encode($getitem);
        echo $item;
    }

}