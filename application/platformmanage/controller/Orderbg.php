<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/4/3
 * Time: 15:27
 */

namespace app\platformmanage\controller;
use think\Controller;
use think\Paginator ;
use think\Db;

class Orderbg extends Controller
{
    /**
     *  *  功能描述:显示后台用户管理页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-3-30
     **/
    public function orderbg()
    {
        $search=input('?post.input_search')?input('post.input_search'):'';
        $join=[
            ['store_hotelorder a','a.huId=b.hId']
        ];
        $where=[];
        $where['hName']=['like',"%".$search."%"];
        $getorder=DB::table('store_shotel')->alias('b')->join($join)->where($where)->paginate(4);
        // 获取分页显示
        $page = $getorder->render();
        $this->assign('order',$getorder);
        $this->assign('page', $page);
        return $this->fetch();

    }
}