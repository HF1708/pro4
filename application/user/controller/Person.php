<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 14:15
 */

namespace app\user\controller;
use think\Controller;


class Person extends Controller
{
    public function person(){
        return $this->fetch();
    }
}