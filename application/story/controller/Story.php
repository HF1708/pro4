<?php
namespace app\story\controller;
use think\Controller;
use think\Session;
use think\paginator;//分页
class Story extends Controller
{
    /**
     *  *  功能描述：显示热门故事页面
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-3-27
     **/
    public function story()
    {
        $getnotes=db('user_story')->paginate(3);
        // 获取分页显示
        $page = $getnotes->render();
        // 获取富文本第一张图为缩略图
//        $content = $getnotes[0]['content'];//接收编辑器name的参数
//        if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
//            $str=$matches[3][0];
//            preg_match('/\/Uploads\/images/', $str);
//            $str1=substr($str,7);//第一张图路径
//            echo "<img src='$str1' alt=''>";return;
//        }else{
//            echo "<img src='1.jpg' alt=''>";return;//编辑器中没有图片时用默认图片
//        }

        $this->assign('notes',$getnotes);
        $this->assign('page',$page);
        return $this->fetch();
    }
    /**
     *  *  功能描述：获取游记
     *  参数：无
     *  返回：查询结果
     *  作者:min H
     *  时间：18-4-3
     **/
    public function getNotes(){
        $getnotes=db('user_story')->select();
        $notes=json_encode($getnotes);
        return $notes;
    }
    /**
     *  *  功能描述：当前点击的游记id存入session
     *  参数：无
     *  返回：无
     *  作者:min H
     *  时间：18-4-09
     **/
    public function setStory(){
        $sid=input('?post.sid')?input('sid'):"";
        if(Session::has('sid')){
            Session::delete('sid');
        }else{
            Session::set('sid',$sid);
        }
    }
}
