<?php
namespace app\store\controller;

use think\Controller;
use think\db;//数据库
use think\Session ;
use think\paginator;//分页


class Hoteldetail extends Controller
{
    /**
     *  功能描述：显示酒店详情页面
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-03-26
     **/
    public function hoteldetail()
    {
        $hid=input('?get.hId')?input("hId"):"";
        //数据库查询到对应id的酒店信息
        $where=['hId'=>$hid];
        $getnowhotel=db('store_shotel')->where($where)->select();
        //导出当前酒店到页面
        $this->assign("nowHotel",$getnowhotel);
        $getcomment=db('store_hotelcomment')->where($where)->paginate(5,true,['query'=>$hid]);
        $page = $getcomment->render();
        $this->assign('comment',$getcomment);
        $this->assign('page', $page);
        //$this->assign('query', );
        return $this->fetch();
    }

    /**
     *  功能描述：添加评论
     *  参数：hId，commentdinput
     *  返回：$arr
     *  作者:邱萍
     *  时间：18-04-01
     **/
    public function addcommend(){
        $hid=input('?get.hId')?input("hId"):"";
        $comment=input('?post.commentdinput')?input('post.commentdinput'):"";
        //获取当前时间
        $time=date("Y/m/d H:i:s",time());
        //$user=Session::get('loginData');
        $user=1001;
        //echo $user;
        //数据库查询到对应id的酒店信息
        $data=['hcContent'=>$comment,'hId'=>$hid,'hcTime'=>$time,'userId'=>$user];
        $addcommend=db('store_hotelcomment')->insert($data);
        if($addcommend==1){
            $dataArr=['hcContent'=>$comment,'hId'=>$hid,'hcTime'=>$time,'userId'=>1001];
            $arr['code']=10000;
            $arr['msg']="添加成功";
            $arr['data']=$dataArr;
            echo json_encode($arr);
        }else{
            $dataArr=['hcContent'=>$comment,'hId'=>$hid,'hcTime'=>$time,'userId'=>1001];
            $arr['code']=10001;
            $arr['msg']="添加失败";
            $arr['data']=[];
            echo json_encode($arr);
        }
    }

    /**
     *  功能描述：酒店下单
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-04-03
     **/
    public function add_order(){
        $hid=input('?get.hId')?input('get.hId'):"";
        $time=date('Y/m/d H:i:s', time());
        $state=0;
        $user=session::get('loginData');
        if(empty($user)){
            $arr['code']=1008;
            $arr['msg']="未登录，请先登录";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }
        $data=['huId'=>$hid,'hoTime'=>$time,'user_id'=>$user,'orderstate'=>$state];
        $add_order=db('store_hotelorder')->insert($data);
        if($add_order){
            $arr['code']=1000;
            $arr['msg']="预定成功";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }
    }

    /**
     *  功能描述：酒店收藏
     *  参数：无
     *  返回：无
     *  作者:邱萍
     *  时间：18-04-09
     **/
    public function collect(){
        $hid=input('?get.hId')?input('get.hId'):"";
        $time=date('Y/m/d H:i:s', time());
        $state=1;

        $user=session::get('loginData');
        if(empty($user)){
            $arr['code']=1008;
            $arr['msg']="未登录";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }

        $data=['huId'=>$hid,'hoTime'=>$time,'user_id'=>$user,'orderstate'=>$state];
        $add_order=db('store_hotelorder')->insert($data);

    }




}
