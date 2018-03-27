<?php
namespace app\user\controller;
use think\Controller;
use think\captcha ;
use \think\Session ;

class Login extends Controller
{
    public function index()
    {

        $res = $this->fetch() ;
        return $res ;
    }
    /**
     * 功能描述：用户登录
     * 参数：
     * QQUser：
     * 返回：登录结果信息
     * 作者：yonjin L
     * 时间：18-3-24
     */
    public function login()
    {
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['ACCOUNT_ERROR'] ,
            'data' => []
        ] ;
        $name = input("?post.name") ? input("post.name") : '' ;
        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;
        $code = input("?post.code") ? input("post.code") : '' ;

        // 验证码是否为空
        if( empty($code) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['CODE_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
        // 用户名获密码是否为空
        if( empty($name) || empty($pwd)  )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['ACCOUNT_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        $where = [
           "user_uid" => $name ,
            "user_password" => md5($pwd)
        ] ;
        // 验证码是否正确
        if( !captcha_check($code) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['CODE_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            return ;
        }
        // 是否存在用户
        $res = Db('user_user')->where($where)->find() ;
        if( !empty($res) )
        {
            $returnJson = [
                'code' => 10000 ,
                'msg' => config('loginMsg')['SUCCESS'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        echo json_encode($returnJson) ;

    }

    /**
     * 功能描述：手机登录
     * 参数：
     * QQUser：
     * 返回：登录结果信息
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function phoneLogin()
    {
        $that = new \user() ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('registerMsg')['PHONE_ERROR'] ,
            'data' => []
        ] ;
        $tel = input("?post.name") ? input("post.name") : '' ;
        $code = input("?post.code") ? input("post.code") : '' ;
        // 获取session中的验证码及对应的手机号码
        $sessionName = $tel."loginCode" ;
        $codeSet2 = Session::get($sessionName) ;
        $sessionPhone = Session::get($tel.'session') ;


        /*
         * 手机号码为空
         */
        $that->emptyData($tel,'loginMsg','PHONE_EMPTY') ;

        /*
        * 验证码为空
        */
        $that->emptyData($code,'loginMsg','CODE_EMPTY') ;

        /*
       * 验证码是否正确
       */
        $that->strcmpData($code,$codeSet2,'loginMsg','CODE_ERROR') ;

        /*
         * 手机号码是否一致
         */
        $that->strcmpData($tel,$sessionPhone,'registerMsg','PHONE_ALIKE') ;

        /*
         * 手机号码是否存在
         */
        $where = [
           "store_phone" => $tel
        ] ;
        $res = Db("store_info")->where($where)->find() ;
        if( !empty($res) )
        {
            // 登录成功 存储数据到redis
            $redis = new \Redis() ;
            $redis->connect('127.0.0.1',6379) ;
            $redis->hSet('userStore', $res['store_id'], serialize($res));
            $res = unserialize($redis->hGet('userStore', $res['store_id']));
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['SUCCESS'] ,
                'data' => $res
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        echo json_encode($returnJson) ;
    }

    /**
     * 功能描述：查看手机是否存在存在发送短信验证码
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function getPhoneMsgUser()
    {
        $that = new \user() ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['PHONE_EMPTY'] ,
            'data' => []
        ] ;
        $tel = input("?post.tel") ? input("post.tel") : '' ;
        // 手机号码是否为空
        $that->emptyData($tel,'loginMsg','PHONE_EMPTY') ;

        // 设置验证码
        $code = 'qwertyuioplkjhgfdsazxcvbnm1234567890';
        $codeSet = '' ;
        for( $i = 0;$i < 4;$i++ )
        {
            $codeSet .= $code[mt_rand(0,35)] ;
        }
        // 存储验证码到redis缓存
//        $redis = new \Redis();
//        $redis->connect('127.0.0.1',6379);
//        $redis->set('test',$codeSet);
        // 存储验证码到session缓存
        $sessionName = $tel."loginCode" ;
        Session::set($sessionName,$codeSet);
        Session::set($tel.'session',$tel);
        $codeSet2 = Session::get($sessionName);

        // 发送验证码到手机
//        $content = '您的验证码是：1234。请不要把验证码泄露给其他人。' ;
//        $url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit&account=C65381484&password=178725f8f9cdf5a284000fb5c8a16455&mobile='.$tel.'&content='.$content ;
//        $url = 'https://www.baifubao.com/callback?cmd=1059&callback=phone&phone=15850781443';
//        $res = ($this->curlHttp($url,"GET",""));

        $returnJson = [
            'code' => 10000 ,
            'msg' => config('loginMsg')['CODE_SEND'] ,
            'data' => $codeSet2
        ] ;
//        var_dump($res) ;
//        exit ;
        echo json_encode($returnJson) ;
    }

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




