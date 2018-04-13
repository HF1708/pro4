<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13
 * Time: 14:28
 */

namespace app\data\controller;
use think\Controller;
use think\Request;
class changeUser extends Controller
{
    public function changeUser(){
        $nickName=input("?post.userName")?input("post.userName"):"";
        $myEmail=input("?post.myEmail")?input("post.myEmail"):"";
        $myPhone=input("?post.myPhone")?input("post.myPhone"):"";
        $data=[
            'user_name'=>$nickName,
            'user_email'=>$myEmail,
        ];
        // 更新数据表中的数据
        $res=db('user_user')->where('user_phone',$myPhone)->update($data);
        echo $res;

    }
}