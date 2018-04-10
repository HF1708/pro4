<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 23:41
 */
namespace app\platformmanage\controller;
use think\Controller;
use think\db;


class Notesbg extends Controller
{
    /**
     *  *  功能描述:显示遊記管理页面/可以模糊查询加分页
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-4-4
     **/
    public function notesbg()
    {
        $search=input('?post.input_search')?input('post.input_search'):'';
//        $join=[
//            ['store_hotel_order a','a.huId=b.hId']
//        ];
        $where=[];
        $where['title']=['like',"%".$search."%"];
        $getnotes=db('user_story')->where($where)->paginate(4);
        // 获取分页显示
        $page = $getnotes->render();
        $this->assign('notes',$getnotes);
        $this->assign('page', $page);
        return $this->fetch() ;

    }
    /**
     *  *  功能描述:审核游记内容
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-4-9
     **/
    public function notesAudit(){
        $hotelid=input('?post.nowhotelid') ?input('post.nowhotelid'):'';
        $updateaudit=db('store_shotel')->where('hId',$hotelid)->update(['audit'=>1]);
        if($updateaudit) {
            echo 1;
        }
    }

}

