<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4
 * Time: 14:44
 */

namespace app\user\controller;
use think\Controller;
use think\Session;

class Updatahead extends Controller
{
    //显示上传头像页
    public function showHead(){
        //获取用户头像

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
            $res=$this->fetch('showHead',$res);
        }
        return $res;
    }
    //上传头像进行cdn加速
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = $_FILES["file"];
        $that = new \user() ;
        $res=$that->uploadImage($file);
        $re=$this->saveHead($res);
        echo $re;

    }
    //将加速后的头像路径存入数据库
    public function saveHead($res){
        //获取当前用户
        $result=unserialize(Session::get('loginData'));
        $user_uid=$result['user_uid'];
        $where=['user_uid'=>$user_uid];
        $data=['user_image'=>$res];
        $re=db('user_user')->where('user_uid',$user_uid)->update($data);
        return $re;
    }
}