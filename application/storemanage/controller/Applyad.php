<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/3
 * Time: 0:22
 */

namespace app\storemanage\controller;
use think\Controller;

class Applyad extends Controller
{
    /**
     *  *  功能描述:显示广告申请页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-3
     **/
    public function index(){
        return $this->fetch();
    }
    /**
     *  *  功能描述:广告申请提交事件
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-4-3
     **/
    public function applyad(){

        $file = $_FILES['file'] ;
        $obj=new \user();
        $re=$obj->uploadImage($file);
        $store_adv_name=input("?post.advName")?input("?advName"):"";
        $store_adv_link=input("?post.link")?input("?link"):"";
        $advert_textarea=input("?post.advert_textarea")?input("?advert_textarea"):"";
        $store_adv_url=$re;
        $store_id=1;
        $data=["store_adv_name"=>$store_adv_name,"store_adv_link"=>$store_adv_link,"store_adv_url"=>$store_adv_url,"store_id"=>$store_id,"advert_textarea"=>$advert_textarea];
        $re=db('store_advert')->insert($data);
        if($re==1){
            $this->success('提交成功！请等待审核');
        }else{
            $this->error('提交失败请重试！');
        }
    }
}