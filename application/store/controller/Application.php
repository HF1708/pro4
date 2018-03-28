<?php
namespace app\store\controller;
use \think\Controller;
use \think\db;
use \think\Session;
use \think\Loader;
use think\Cookie;
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
//        根据IP定位用户所在地区设置默认地址
        //消除手机号记录
        if(Session::has('mobile')){
            Session::delete('mobile');
        }

        Session::set('send_code',$this->random(6,1));
        $send_code=Session::get('send_code');
        $this->assign("send_code",$send_code);
//        查询省
        $where=["pid"=>0];
        $re=db("hy_area")->where($where)->select();
        $re=json_encode($re);
        $this->assign("province",$re);
        $where=["pid"=>1];
        $re=db("hy_area")->where($where)->select();
        $re=json_encode($re);
        $this->assign("city",$re);
        return $this->fetch("Application/storeEnter");
    }
    /**
     *  *  功能描述：查询城市
     *  参数：id
     *  返回：查询到的城市数组
     *  作者:qingtian Y
     *  时间：18-3-27
     **/
    public function getCity(){
        $id=input('?post.id')?input('id'):1;
        $where=["pid"=>$id];
        $re=db("hy_area")->where($where)->select();
        echo json_encode($re);
    }
    /**
     *  *  功能描述：点击获取短信获取登录验证码
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-27
     **/
    public function getCode(){
// 引入 extend/qrcode.php
        //获取手机号
        $mobile=input('?post.mobile')?input('mobile'):"";
        $send_code=input('?post.send_code')?input('send_code'):"";
        $where=["store_phone"=>$mobile];
        $re=db("store_info")->where($where)->select();
        Loader::import('storeSms', EXTEND_PATH);
//// 助手函数
        import('storeSms', EXTEND_PATH);
        new \StoreSms($re,$mobile,$send_code);
        //查询手机号是否已被注册

    }
    /**
     *  *  功能描述：商家申请入驻表单提交
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-27
     **/
    public function submitform(){
        if($_POST){
            //echo '<pre>';print_r($_POST);print_r($_SESSION);
            $mobile_code=input('?post.mobile_code')?input('mobile_code'):"";
            $settledType=input('?post.settledType')?input('settledType'):"";
            $corporation=input('?post.corporation')?input('corporation'):"";
            $corporation_province=input('?post.corporation_province')?input('corporation_province'):"";
            $corporation_city=input('?post.corporation_city')?input('corporation_city'):"";
            $corporation_town=input('?post.corporation_town')?input('corporation_town'):"";
            $corporation_detail=input('?post.corporation_detail')?input('corporation_detail'):"";
            $mobile=input('?post.mobile')?input('mobile'):"";
            $email=input('?post.email')?input('email'):"";
            $textarea=input('?post.textarea')?input('textarea'):"";
            //后台验证
            if(empty($mobile_code)){
                $this->error('验证码不能为空');
            }
            if($settledType!="景点入驻" && $settledType!="酒店入驻"){
                $this->error('非法请求');
            }
            if(empty($corporation)||count($corporation)>50){
                $this->error('非法请求');
            }
            if(empty($corporation_province)||!preg_match("/^\d*$/",$corporation_province)){
                $this->error('非法请求');
            }
            if(empty($corporation_city)||!preg_match("/^\d*$/",$corporation_city)){
                $this->error('非法请求');
            }
            if(empty($corporation_town)||!preg_match("/^\d*$/",$corporation_town)){
                $this->error('非法请求');
            }
            if(empty($corporation_detail)||count($corporation_detail)>50){
                $this->error('非法请求');
            }
            if(empty($email)||!preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/",$email)){
                $this->error('非法请求');
            }
            if(empty($mobile)||!preg_match("/^(0|86|17951)?1[0-9]{10}/",$mobile)){
                $this->error('非法请求');
            }
            $mobile=input('?post.mobile')?input('mobile'):"";
            $mobile_code=input('?post.mobile_code')?input('mobile_code'):"";
            //验证码是否能通过验证
           
            if($mobile!=Session::get('mobile') or $mobile_code!=Session::get('mobile_code') or empty($mobile) or empty($mobile_code)){
                // cookie初始化
                Cookie::init(['prefix'=>'travel_','expire'=>3600,'path'=>'/']);
                // 设置
                cookie('code_error', "验证码错误",50);

                //消除手机号记录
                if(Session::has('mobile')){
                    Session::delete('mobile');
                }
                    Session::set('send_code',$this->random(6,1));
                    $send_code=Session::get('send_code');
                    $this->assign("send_code",$send_code);
                //        查询省
                    $where=["pid"=>0];
                    $re=db("hy_area")->where($where)->select();
                    $re=json_encode($re);
                    $this->assign("province",$re);
                    $where=["pid"=>1];
                    $re=db("hy_area")->where($where)->select();
                    $re=json_encode($re);
                    $this->assign("city",$re);
//                    $this->redirect('Application/storeEnter');
            }else{
                $submitTime=@date("Y-m-d H:i:s",time()+60*60*8);
                $data=['store_name'=>$corporation,
                    'store_state'=>"F",
                    "store_phone"=>$mobile,
                    "store_apply_time"=>$submitTime,
                    "store_province_id"=>$corporation_province,
                    "store_city_id"=>$corporation_city,
                    "store_town_id"=>$corporation_town,
                    "store_address_detail"=>$corporation_detail,
                    "store_textarea"=>$textarea
                ];
                db('store_info')->insert($data);
                Session::set("mobile",'');
                Session::set("mobile_code",'');

                $this->success('提交成功！请保持手机畅通。');
            }
        }else{
            $this->error('非法请求！');
        }
    }
    private  function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }
}
