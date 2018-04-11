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
     * 参数：
     *
     * 返回：验证码
     * 作者：Qingtian Y
     * 时间：18-4-10
     */
    public function getNotes(){
        $notes=db('user_story')->select();
        echo 4444;
        echo $notes;
    }

}