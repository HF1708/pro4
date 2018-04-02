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

        // 获取session中的搜索条件

        if( Session::has('search_advert') || input("?post.seartch_advert") )
        {
            $seatch = input("?post.seartch_advert")? input("post.seartch_advert"):(Session::has('search_advert')?Session::get('search_advert'):"") ;
            $list = Db("store_advert")->alias('a')->join('store_info w', 'a.user_uid = w.store_phone')->where('store_adv_name','like','%'.$seatch.'%')->paginate(5);
        }
        else
        {
            // 获取5条广告
//        $list = Db("store_advert")->alias('a')->join('store_info w', 'a.user_uid = w.store_phone')->where('a.user_state','F')->paginate(5);
            $list = Db("store_advert")->alias('a')->join('store_info w', 'a.user_uid = w.store_phone')->paginate(5);

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
                    $that->emptyData($res,'advert','PASS_ALREADY',$res) ;
                    break ;
                // 锁定
                case "locking":
                    // 用户已被锁定时
                    $that->emptyData($res,'advert','PASS_ALREADY',$res) ;
                    break ;
                // 解锁
                case "unlock":
                    // 用户未被锁定时
                    $that->emptyData($res,'advert','UNLOCK_ALREADY',$res) ;
                    break ;
                default:
                    exit ;
            }
            // 修改成功
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('advert')['SUCCESS'] ,
                'data' => []
            ] ;
        }

        // 返回消息
        echo json_encode($returnJson) ;

    }

}