<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 9:32
 */

namespace app\platformmanage\controller;
use think\Controller;
use think\Db;

class Role extends  Controller
{
    /**
     *  *  功能描述:显示角色管理界面
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function index(){
        return $this->fetch();
    }
    /**
     *  *  功能描述:获取角色
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function roleData(){
//        Db::listen(function($sql, $time, $explain){
//// 记录SQL
//            echo $sql. ' ['.$time.'s]';
//// 查看性能分析结果
//            dump($explain);
//        });



//        $re=Db::table('backstage_role')
//            ->alias('a')
//            ->join('backstage_rolejurisdiction b','a.id = b.roleID')
//            ->join('backstage_jurisdiction c','b.jurisdictionID = c.id')
//            ->select();

        $re=Db::table('backstage_role')->select();
        $count=count($re);
        $arr['code']=0;
        $arr['msg']="";
        $arr['count']=$count;
        $arr['data']=$re;

        echo json_encode($arr);
    }
}