<?php
namespace app\user\controller;
use think\Controller;
use think\captcha ;
use think\Session ;
use think\Cookie ;

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

        $that = new \user() ;

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
                'code' => 10002 ,
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
                'code' => 10002 ,
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
                'code' => 10002 ,
                'msg' => config('loginMsg')['CODE_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            return ;
        }
        // 是否存在用户
        $res = Db('user_user')->where($where)->find() ;

        // 用户是否被锁了
        if( !($res['user_state']) )
        {
            // 被锁了
            $that->returnJson("loginMsg","USER_LOCKING","",10003) ;
            exit ;
        }

        if( !empty($res) )
        {
            $res['userType'] = "user" ;

            // 登录成功 存储数据到redis
            /*$redis = new \Redis() ;
            $redis->connect('127.0.0.1',6379) ;

            $redis->hSet('userStore', $res['store_id'], serialize($res)) ;
            $res = unserialize($redis->hGet('userStore', $res['store_id'])) ;*/

//            $redis->hSet('userStore', $res['store_id'], serialize($res)) ;
//            $res = unserialize($redis->hGet('userStore', $res['store_id'])) ;
//            $redis->hSet('userStore', $res['store_id'], serialize($res)) ;





            // 用户数据存到session
            Session::set('loginData',serialize($res)) ;
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
        $that->emptyData($code,'loginMsg','CODE_EMPTY',"",10002) ;

        /*
       * 验证码是否正确
       */
        $that->strcmpData($code,$codeSet2,'loginMsg','CODE_ERROR',"",10002) ;

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
            $res['userType'] = "store" ;
            // 登录成功 存储数据到redis
            $redis = new \Redis() ;
            $redis->connect('127.0.0.1',6379) ;
//            $redis->hSet('userStore', $res['store_id'], serialize($res)) ;
//            $res = unserialize($redis->hGet('userStore', $res['store_id'])) ;
            // 商家数据存到session
            Session::set('loginData',serialize($res));
            $returnJson = [
                'code' => 10000 ,
                'msg' => config('loginMsg')['SUCCESS'] ,
                'data' => $res
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        $that->returnJson("loginMsg","PHONE_CODE_ERROR") ;
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
        $that->emptyData($tel,'loginMsg','PHONE_EMPTY',"",10002) ;
        /*
         * 手机号码是否合法
         */
        // 不合法返回信息
        if( !$that->checkMobileValidity($tel) )
        {
            $that->returnJson("loginMsg","PHONE_ERROR",'',10002) ;
        }

        // 设置验证码
        $code = 'qwertyuioplkjhgfdsazxcvbnm1234567890' ;
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
        Session::set($sessionName,$codeSet) ;
        Session::set($tel.'session',$tel) ;
        $codeSet2 = Session::get($sessionName) ;

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

    /**
     * 功能描述：用户是否已登录
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-4-1
     */
    function userLoginAlready(){
        $msg = new \user() ;
        if( Session::has('loginData') )
        {
            $res = unserialize(Session::get('loginData')) ;

            if( strcmp($res['userType'],'user')==0 )
            {
                // 被锁定了
                if(  !($res['user_state'])  )
                {
                    // 被锁了
                    $msg->returnJson("loginMsg","USER_LOCKING") ;
                    exit ;
                }
                // 没头像用默认
                if( empty($res['user_image']) )
                {
                    $image = config("default")["IMAGE_USER"] ;
                }
                else
                {
                    $image = $res['user_image'] ;
                }
                $data = [
                    "name" =>  $res['user_name'] ,
                    "image" =>  $image ,
                    "state" => 'user'
                ] ;
            }
            else if( strcmp($res['userType'],'store')==0 )
            {
                // 没头像用默认
                if( empty($res['store_image']) )
                {
                    $image = config("default")["IMAGE_STORE"] ;
                }
                else
                {
                    $image = $res['store_image'] ;
                }
                $data = [
                    "name" =>  $res['store_name'] ,
                    "image" =>  $image,
                    "state" => 'store'
                ] ;
            }
            else if( strcmp($res['userType'],'server')==0 )
            {
                // 前台不能用后台管理员信息
                // 返回未登录信息
                $msg->returnJson("loginMsg","ERROR_USER_DATA") ;
                // 并直接退出
                exit ;
            }
            else
            {
                // 返回未登录信息
                $msg->returnJson("loginMsg","ERROR_USER_DATA") ;
                exit ;
            }

            // 返回用户信息
            $msg->returnJson("loginMsg","SUCCESS_USER_DATA",$data,10000) ;


        }
        else
        {
            // 返回未登录信息
            $msg->returnJson("loginMsg","ERROR_USER_DATA") ;
        }
    }

    /**
     * 功能描述：用户退出登录
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-4-1
     */
    function outLogin(){
        $msg = new \user() ;
        if( Session::has('loginData') )
        {
            $res = Session::delete('loginData');
            // 返回用户信息
            $msg->returnJson("loginMsg","SUCCESS_USER_DATA",Session::get('loginData'),10000) ;
        }
        else
        {
            // 返回未登录信息
            $msg->returnJson("loginMsg","SUCCESS_USER_OUT") ;
        }
    }
    /**
     * 功能描述：手机号码格式验证
     * 参数：
     * QQUser：
     * 返回：
     * 作者：yonjin L
     * 时间：18-4-7
     */
    public function phoneNumber()
    {
        $that = new \user() ;

        $phone = $that->getData("phone",'loginMsg','PHONE_EMPTY',"post",10002) ;


        /*
         * 手机号码是否合法
         */
        // 不合法返回信息
        if( !$that->checkMobileValidity($phone) )
        {
            $that->returnJson("loginMsg","PHONE_ERROR",'',10002) ;
        }


        // 返回正确信息
        $that->returnJson("loginMsg","DATA_SUCCESS","",10000) ;

    }
    /**
     * 功能描述：判断是否登录
     * 参数：
     * QQUser：
     * 返回：
     * 作者：qingtian Y
     * 时间：18-4-13
     */
    function islogin(){
        $user=session::get('loginData');
        if(empty($user)){
            $arr['code']=1008;
            $arr['msg']="未登录";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }else{
            $arr['code']=1000;
            $arr['msg']="已登陆";
            $arr['data']=[];
            echo json_encode($arr);
            exit();
        }
    }
}




