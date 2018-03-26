<?php
namespace app\store\controller;
use \think\Controller;
use \think\db;
class Application extends Controller
{
    /**
     *  *  功能描述：显示商家 入驻页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-26
     **/
    public function storeEnter()
    {
//        查询省
        $where=["pid"=>0];
        $re=db("hy_area")->where($where)->select();
        var_dump($re);
//        $this->assign("province",$re);
//        return $this->fetch();
    }
}
