<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/4/3
 * Time: 15:27
 */

namespace app\platformmanage\controller;
use think\Controller;
use think\Db;
use think\paginator;

class Hotelbg extends Controller
{
    /**
     *  *  功能描述:显示后台酒店管理页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-3-30
     **/
    public function hotelbg()
    {
        $where=[];
        $get_hotelbg=db('store_shotel')->where($where)->paginate(5);
        $page = $get_hotelbg->render();
        $this->assign('page', $page);
        $this->assign('hotelbg', $get_hotelbg);
        return $this->fetch();
    }
    /**
     *  *  功能描述:酒店管理的上架
     *  参数：$hotelid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-07
     **/
    public function upstate(){
        $hotelid=input("?post.nowhotelid")?input("post.nowhotelid"):"";
        $where=['hId'=>$hotelid];
        $updatestate=db('store_shotel')->where($where)->update(['putaway'=>'上架']);
        echo '上架成功！';
    }
    /**
     *  *  功能描述:酒店管理的下架
     *  参数：$hotelid
     *  返回：无
     *  作者:邱萍
     *  时间：18-4-07
     **/
    public function downstate(){
        $hotelid=input("?post.nowhotelid")?input("post.nowhotelid"):"";
        $where=['hId'=>$hotelid];
        $updatestate=db('store_shotel')->where($where)->update(['putaway'=>'下架']);

    }


}