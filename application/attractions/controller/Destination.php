<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 10:54
 */

namespace app\attractions\controller;
use think\Controller;


class Destination extends Controller
{
    public function destination(){
        return $this->fetch();
    }
}