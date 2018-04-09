<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 9:21
 */

namespace app\platformmanage\controller;
use think\Controller;
use think\Db;

class Staff extends Controller
{
    /**
     *  *  功能描述:显示员工管理界面
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function index(){


        $re=db('backstage_role')->where("id","NEQ","1")->select();
        $this->assign("role",$re);
        return $this->fetch();
    }
    /**
     *  *  功能描述:添加员工
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function addStaff(){
        $user_uid=input("post.user_uid")?input("post.user_uid"):"";
        $user_name=input("post.user_name")?input("post.user_name"):"";
        $roleID=input("post.roleID")?input("post.roleID"):"";
        $pwd=md5("123456");
        $data=["user_uid"=>$user_uid,
            "user_name"=>$user_name,
            "roleID"=>$roleID,
            "userState"=>"T",
            "user_password"=>$pwd
            ];
        $re=db('backstage_user')->insert($data);
        if($re==1){
            $this->success('添加员工成功');
        }else{
            $this->error('提交失败请重试！');
        }
    }
    /**
     *  功能描述:添加员工
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function staffData(){
        $join=[
            ["backstage_user a","a.roleID=b.id"]
        ];
        $where=[];
        $re=DB::table("backstage_role")->alias('b')->join($join)->where($where)->select();
        $count=count($re);
        $arr['code']=0;
        $arr['msg']="";
        $arr['count']=$count;
        $arr['data']=$re;
        echo json_encode($arr);

    }
    /**
     *  功能描述:锁定员工
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function lock(){
        $id=input("?post.id")?input("post.id"):"";
        $userState=input("?post.userState")?input("post.userState"):"";
//        $re=db('backstage_user')->where('user_id',$id)->setField(['userState' => $userState]);

        $re=Db::table('backstage_user')->where('user_id',$id)->setField('userState', $userState);

        if($re===1){
            $returnJson = [
                'code' => 10000 ,
                'msg' => "操作成功" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }else{
            $returnJson = [
                'code' => 10001,
                'msg' => "操作失败" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }
    }
    /**
     *  功能描述:删除员工
     *  参数：无
     *  返回：无
     *  作者:Qingtian Y
     *  时间：18-4-8
     **/
    public function delStaff(){
        $id=input("?post.id")?input("post.id"):"";
        $re=Db::table('backstage_user')->delete($id);
        if($re===1){
            $returnJson = [
                'code' => 10000 ,
                'msg' => "操作成功" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }else{
            $returnJson = [
                'code' => 10001,
                'msg' => "操作失败" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }

    }
}