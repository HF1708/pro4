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

class Advert extends Controller
{
    /**
     *  *  功能描述:显示广告管理页面/可以模糊查询加分页
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-3-30
     **/
    public function index()
    {
//        $request = Request::instance();
//        echo "当前模块名称是" . $request->module();
//        echo "当前控制器名称是" . $request->controller();
//        echo "当前操作名称是" . $request->action();
        // 获取session中的搜索条件
        $seatch_2 =  cookie('search') ;

        if( Session::has('search_advert') || input("?post.seartch_advert") )
        {
            $seatch = input("?post.seartch_advert")? input("post.seartch_advert"):(Session::has('search_advert')?Session::get('search_advert'):"") ;


            if(!empty($seatch_2))
            {
                $where = [
                    "a.user_state" =>  $seatch_2
                ] ;
                $list = Db("store_advert")->alias('a')->join('store_info w', 'a.store_id = w.store_phone')->where('store_adv_name','like','%'.$seatch.'%')->where($where)->paginate(5);

            }
            else
            {
                $list = Db("store_advert")->alias('a')->join('store_info w', 'a.store_id = w.store_phone')->where('store_adv_name','like','%'.$seatch.'%')->paginate(5);

            }


        }
        else
        {
            // 获取5条广告
            $list = Db("store_advert")->alias('a')->join('store_info w', 'a.store_id = w.store_phone')->paginate(5);

        }

        // 获取分页显示
        $this->assign('list', $list) ;
//        var_dump($list[0]) ;

        return $this->fetch() ;
    }

    /**
     *    功能描述:操作广告   未审核 审核通过 被锁定
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-3-30
     **/
    public function setExamine()
    {
        $that = new \user() ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('advert')['ERROR'] ,
            'data' => []
        ] ;
        // 审核通过
        $pass = config("advert_state")['PASS'] ;
        // 未审核
        $locking = config("advert_state")['LOCKING'] ;
        // 被锁定
        $unlock = config("advert_state")['UNLOCK'] ;

        $set_id = input("?post.setId") ? input("post.setId"):"" ;
        $set_data = input("?post.setData") ? input("post.setData"):"" ;
        // 接收的数据是否为空
        $that->emptyData($set_data,'advert','EMPTY',$set_data) ;

        $that->emptyData($set_id,'advert','EMPTY',$set_id) ;

        $setClass = (strcmp($set_data,$pass)==0)?$pass:((strcmp($set_data,$locking)==0)?$locking:((strcmp($set_data,$unlock)==0)?$unlock:"")) ;

        // 操作是否有误
        $that->emptyData($setClass,'advert','OPERATION') ;
        // 开始操作
        switch($setClass)
        {
            // F 未审核； T审核通过； S 被锁定
            // 审核通过
            case "pass":
                $where = [
                    "user_state"=>"F" ,
                    "store_adv_id"=>$set_id
                ] ;
                $upData = ['user_state' => 'T'] ;

                break ;
            // 锁定
            case "locking":
                $where = [
                    "user_state"=>"T" ,
                    "store_adv_id"=>$set_id
                ] ;
                $upData = ['user_state' => 'S'] ;
                break ;
            // 解锁
            case "unlock":
                $where = [
                    "user_state"=>"S" ,
                    "store_adv_id"=>$set_id
                ] ;
                $upData = ['user_state' => 'T'] ;
                break ;
            default:
                $returnJson = [
                    'code' => 10001 ,
                    'msg' => config('advert')['OPERATION'] ,
                    'data' => []
                ] ;
                echo json_encode($returnJson) ;
                exit ;
        }

        // 修改广告状态
        $res = Db("store_advert")->where($where)->update($upData) ;
        // 成功返回的消息
        $success = "" ;
        // 修改是否成功或者没报错
        if( empty($res) || strcmp($res,1)==0 )
        {

            // 审核操作判断
            switch($setClass)
            {
                // F 未审核； T审核通过； S 被锁定
                // 审核
                case "pass":
                    // 审核已通过时
                    $that->emptyData($res,'advert','PASS_ALREADY') ;
                    // 审核已通过返回的消息
                    $success = "T" ;
                    break ;
                // 锁定
                case "locking":
                    // 用户未通过审核时
                    $that->emptyData($res,'advert','PASS_ALREADY') ;
                    // 审核锁定返回的消息
                    $success = "S" ;
                    break ;
                // 解锁
                case "unlock":
                    // 用户未被锁定时
                    $that->emptyData($res,'advert','UNLOCK_ALREADY') ;
                    // 审核已通过返回的消息
                    $success = "S" ;
                    break ;
                default:
                    exit ;
            }
        }
        // 修改成功
        $returnJson = [
            'code' => 10000 ,
            'msg' => config('advert')['SUCCESS'] ,
            'data' => ["success"=>$success]
        ] ;
        // 返回消息
        echo json_encode($returnJson) ;

    }
    /**
     *    功能描述:更换广告
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-3-31
     **/
    public function replaceAdvert()
    {
        $advert_id = input("?post.setId")? input("post.setId") : "" ;
        $that = new \user() ;

        // 广告id是否存在
        $that->emptyData($advert_id,"advert","REPLACE_ADVERT_ERROR") ;

        // 获取广告
        $where = [
            "a.store_adv_id" => $advert_id
        ] ;
        $res = Db("store_advert")->alias('a')->join('store_info w', 'a.user_uid = w.store_phone')->where($where)->find();
        // 广告是否获取失败
        $that->emptyData($advert_id,"advert","REPLACE_ADVERT_ERROR") ;

        // 打包数据
        $returnData = [
            "name" => $res["store_adv_name"] ,
            "link" => $res["store_adv_link"] ,
            "url" => $res["store_adv_url"] ,
            "advertiser" => $res["store_name"] ,
            "setId" => $res["store_adv_id"]
        ] ;




        // 广告获取成功
        $that->returnJson("advert","SUCCESS",$returnData) ;

    }

    /**
     *    功能描述:修改广告查询条件
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-3-31
     **/
    public function searchCondition()
    {
        $that = new \user() ;

        // 获取设置的条件
        $condition = input("?post.search") ? input("post.search"):"" ;



        // 搜索条件是否存在
        $that->emptyData($condition,"advert","ERROR") ;

        switch($condition)
        {
            // 上架
            case "up":
                $condition = "T" ;
                break ;
            // 未审核
            case "none":
                $condition = "F" ;
                break ;
            // 下架
            case "down":
                $condition = "S" ;
                break ;
            case "all":
                $condition = null ;
                // 将条件存入3600秒cookie缓存
                cookie('search', $condition, 3600);
                $res =  cookie('search') ;
                $that->returnJson("advert","SUCCESS",$res,10000) ;
                break ;
            default :
                $condition = null ;
                // 将条件存入3600秒cookie缓存
                cookie('search', $condition, 3600);
                $res =  cookie('search') ;
                $that->returnJson("advert","SUCCESS",$res,10000) ;
        }

        // 将条件存入3600秒cookie缓存
        cookie('search', $condition, 3600);

        $res =  cookie('search') ;

        $that->emptyData($res,"advert","ERROR") ;

        // 返回成功提示
        $that->returnJson("advert","SUCCESS",$res,10000) ;
    }

    /**
     *    功能描述:上传图片
     *  参数：无
     *  返回：无
     *  作者:yonjin L
     *  时间：18-3-31
     **/
    public function imgUpload()
    {
        $that = new \user() ;
        $imageId = input("?post.setId") ? input("post.setId"):"" ;
        // 操作图片的id为空 不上传图片
        // 否则上传图片
        if( !empty($imageId) )
        {
            // 获取文件流
            $file = $_FILES["file"] ;
            // 上传图片
            // 成功返回可访问的url路径
            $url = $that->uploadImage($file) ;

            // 保存url路径
            $where = [
                "store_adv_id" => $imageId
            ] ;
            $update = [
                "store_adv_url" => $url
            ] ;
            $res = Db("store_advert")->where($where)->update($update) ;

            // 保存是否成功
            // 失败返回消息
            $that->emptyData($res,"advert","ERROR") ;

            echo json_encode([
                'code' => 10000 ,
                'data' => $url
            ]) ;
        }

    }

}

