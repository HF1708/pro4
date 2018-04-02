<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 23:41
 */
namespace app\platformmanage\controller;
use think\Controller;
use think\Paginator ;
use think\Session ;
use \think\Request ;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

class Login extends Controller
{
    /**
     *  *  功能描述:显示广告管理页面/可以模糊查询加分页
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-4-2
     **/
    public function index()
    {



        return $this->fetch() ;

    }





}

