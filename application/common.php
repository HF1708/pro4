<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 用户模块公共方法
class user{
    /**
     * 功能描述：判断表中元素是否为空
     * 参数：内容、出错返回的信息类型、出错返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function emptyData( $data ,$msgTitle ,$msgBody,$code=10001)
    {
        if( empty($data) )
        {

            echo json_encode([
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => []
            ]) ;
            exit ;
        }

    }

    /**
     * 功能描述：判断表中元素是否存在
     * 参数：表名、条件（数组）、出错返回的信息类型、出错返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function issetData( $table ,$arr ,$msgTitle ,$msgBody,$code=10001)
    {
        $resData = Db($table)->where($arr)->find() ;
        if( !empty($resData) )
        {
            echo json_encode([
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => []
            ]) ;
            exit ;
        }

    }

    /**
     * 功能描述：判断表中两个数据是否相同是否存在
     * 参数：数据1，数据2、出错返回的信息类型、出错返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function strcmpData($dataOne,$dataTwo,$msgTitle ,$msgBody ,$code=10001)
    {
        if( strcmp($dataOne,$dataTwo)!=0 )
        {
            $returnJson = [
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
    }



}

class curl{
    /**
     * 功能描述：发送curl请求
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-3-26
     */
    function curlHttp($url,$type='GET',$data=''){
        // 初始化一个curl
        $curl = curl_init() ;
        // 需要获取的URL地址
        curl_setopt($curl, CURLOPT_URL, $url) ;

        // HTTP请求类型
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,$type) ;

        // ssl加密 // 禁止从服务端验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false) ;

        // http轻轻的头信息中传递一些额外信息
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data) ;

        // 将curl_exec()获取的信息已文件流的形式返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;

        // 发送请求
        $return = curl_exec($curl) ;
        // 关闭请求
        curl_close($curl) ;
        return $return ;
    }
}
