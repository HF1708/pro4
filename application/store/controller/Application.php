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
        $re=json_encode($re);
        $this->assign("province",$re);
        $where=["pid"=>1];
        $re=db("hy_area")->where($where)->select();
        $re=json_encode($re);
        $this->assign("city",$re);
        return $this->fetch();
    }
    public function getCity(){
        $id=input('?post.id')?input('id'):1;
        $where=["pid"=>$id];
        $re=db("hy_area")->where($where)->select();
        echo json_encode($re);
    }
}
