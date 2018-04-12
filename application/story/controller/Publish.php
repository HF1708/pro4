<?php
namespace app\story\controller;
use think\Controller;
use \think\db;
use \think\Session;

class Publish extends Controller
{
    /**
     *  *  功能描述：显示故事发布页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-27
     **/
    public function publish()
    {
        return $this->fetch();
    }
    /**
     *  *  功能描述：上传图片
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-4-01
     **/
    public function uploadImg()
    {
        $file = $_FILES['file'] ;
        $obj=new \user();
        $re=$obj->uploadImage($file);
        $rejson=["link"=>$re];
        echo json_encode($rejson);

    }

    /**
     *  *  功能描述：发表故事
     *  参数：title,content
     *  返回：发表是否成功
     *  作者:min H
     *  时间：18-3-29
     **/
    public function publishStory(){
        //thinkphp内置了一个请求类，用于接收前端发送过来的数据，可以统一进行过滤
        $title=input('?post.title')?input('post.title'):"";
        $content=input('?post.content')?input('post.content'):"";

        //判断标题和内容是否为空，如果为空退出
        if(empty($title)||empty($content)){
            $returnJson=[
                'code'=>10004,
                'msg'=>config('publishMsg')['CONTENT_EMPTY'],
                'data'=>[]
            ];
            return $returnJson;
        }else{
            $user=unserialize(Session::get('loginData'));//序列化
            $userId=$user['user_id'];
            //连接数据库，查询,实例化模型层
            $where=[
                'userId'=>$userId,
                'title'=>$title,
                'content'=>$content,
                'state'=>0,
                'edittime'=>$time
            ];
            $result=db('user_story')->insert($where);
//            var_dump($result);
            if($result){
                $returnJson=[
                    'code'=>10000,
                    'msg'=>config('publishMsg')['SUCCESS'],
                    'data'=>[]
                ];
                return $returnJson;
            }
        }
    }
}
