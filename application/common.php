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
//使用步骤
/*
 *  $that = new \user() ;
 *  $that->emptyData(参数，参数，参数) ;
 *
 */
// 用户模块公共方法
// 简单介绍
// 一：类user
// 1. 判断数据是否为空（为空直接退出，并返回错误消息,否则不进行任何操作）
// 2. 判断表中是否存在数据（不存在数据直接退出，并返回错误消息,否则不进行任何操作）
// 3. 判断两个数据是否相同（不相同直接退出，并返回错误消息,否则不进行任何操作）
//
// 二：类curl
// 1. 发送curl请求
//
//引用七牛CDN工具包
use qiniu\Auth ;
//引用七牛 上传类
use Qiniu\Storage\UploadManager ;




class user{

    /**
     * 功能描述：判断post数据是否存在,为空返回报错信息
     * 参数：待判断的数据,返回的信息类型、返回的信息内容、返回码
     * QQUser：
     * 返回：处理完的字符串
     * 作者：yonjin L
     * 时间：18-4-1
     */
    public function getData( $dataName ,$msgTitle ,$msgBody,$method="post",$code=10001 )
    {
        $getData = input("?".$method.".".$dataName) ? input($method.".".$dataName):"" ;

        // 为空返回报错消息
        $this->emptyData($getData,$msgTitle ,$msgBody,"",$code) ;

        return $getData ;

    }

    /**
     * 功能描述：删除\u 字符串（七牛云上传有中文的话，返回的外链用不了）
     * 参数：$name 预处理的字符串
     * QQUser：
     * 返回：处理完的字符串
     * 作者：yonjin L
     * 时间：18-4-1
     */
    function unicode_decode($name)
    {
        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches))
        {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++)
            {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0)
                {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $name .= $c;
                }
                else
                {
                    $name .= $str;
                }
            }
        }
        return $name;
    }

    /**
     * 功能描述：上传图片
     * 参数：$file 图片文件流  ( $_FILES["file"] )
     * QQUser：
     * 返回：返回cdn加速后的url
     * 作者：yonjin L
     * 时间：18-4-1
     */
    public function uploadImage($file)
    {

        $key = $file['name'] ;
        $filePath = $file['tmp_name'] ;

        // 如果$key 含有中文 则删除中文并添加随机数
        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $key)>0){
            // 设置图片的名字
            // 删除中文并暂不添加随机数
            $key = $this->unicode_decode($key) ;
        }

        // 需要填写你的 Access Key 和 Secret Key
        $accessKey ="3yKhvENwZChpq8Z-JeBP352ODYP7mUay1Eicyr9u";
        $secretKey = "Duh05-2QpbyKp7Bec0UFlE7XdHYZxdXnQqznJtdB" ;
        $bucket = "ling";

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return($err);
        } else {
            $url = $this->unicode_decode($ret['key']) ;
            $http_url = "http://p6gnb5g93.bkt.clouddn.com/".$key ;
            return $http_url ;
        }

    }

    /**
     * 功能描述：返回信息
     * 参数：返回的信息类型、返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-31
     */
    public function returnJson($msgTitle ,$msgBody,$content=[],$code=10001)
    {

        echo json_encode([
            'code' => $code ,
            'msg' => config($msgTitle)[$msgBody] ,
            'data' => $content
        ]) ;
        exit ;
    }

    /**
     * 功能描述：将数据库的结果打包成数组发送回去
     * 参数：返回的信息类型、返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-31
     */
    public function returnDbJson($res ,$data,$content=[],$code=10001)
    {

        if( is_array($data) )
        {
            $return = [

            ] ;
        }

    }

    /**
     * 功能描述：判断表中元素是否为空
     * 参数：内容、出错返回的信息类型、出错返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function emptyData( $data ,$msgTitle ,$msgBody,$content=[],$code=10001)
    {
        if( empty($data) )
        {
            echo json_encode([
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => $content
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
    public function issetData( $table ,$arr ,$msgTitle ,$msgBody,$content=[],$code=10001)
    {
        $resData = Db($table)->where($arr)->find() ;
        if( !empty($resData) )
        {
            echo json_encode([
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => $content
            ]) ;
            exit ;
        }

    }

    /**
     * 功能描述：判断两个数据是否相同是否存在
     * 参数：数据1，数据2、出错返回的信息类型、出错返回的信息内容、返回码
     * QQUser：
     * 返回：无(出错直接退出)
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function strcmpData($dataOne,$dataTwo,$msgTitle ,$msgBody ,$content=[] ,$code=10001)
    {
        if( strcmp($dataOne,$dataTwo)!=0 )
        {
            $returnJson = [
                'code' => $code ,
                'msg' => config($msgTitle)[$msgBody] ,
                'data' => $content
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
    }


    // 手机号验证
    function checkMobileValidity($mobilephone){
        $exp = "/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[012356789]{1}[0-9]{8}$|14[57]{1}[0-9]$/";
        if(preg_match($exp,$mobilephone)){
            return true;
        }else{
            return false;
        }
    }

    // 手机号码归属地(返回: 如 广东移动)
    function  checkMobilePlace($mobilephone){
        $url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$mobilephone."&t=".time() ;
        $curl = new curl() ;
        $content = $curl->curlHttp($url) ;
        $p = substr($content, 56, 4) ;
        $mo = substr($content, 81, 4) ;
        return $str = $this->conv2utf8($p).$this->conv2utf8($mo) ;
    }
// 转换字符串编码为 UTF8
    function conv2utf8($text){
        return mb_convert_encoding($text,'UTF-8','ASCII,GB2312,GB18030,GBK,UTF-8');
    }


}


// curl请求的公共方法
class curl{
    /**
     * 功能描述：发送curl请求
     * 参数：$url 路径，$type 请求类型, $data 发过去的数据
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
