<?php
namespace app\user\controller;
use think\Controller;
use \think\Session ;

class Register extends Controller
{
    public function index()
    {
        $res = $this->fetch() ;
        return $res ;
    }

    /**
     * 功能描述：用户注册
     * 参数：
     * QQUser：
     * 返回：注册是否成功
     * 作者：yonjin L
     * 时间：18-3-25
     */
    public function register()
    {
        $that = new \user();
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('loginMsg')['ACCOUNT_ERROR'] ,
            'data' => []
        ] ;
        $name = input("?post.name") ? input("post.name") : '' ;
        $pwd = input("?post.pwd") ? input("post.pwd") : '' ;
        $pwd2 = input("?post.pwd2") ? input("post.pwd2") : '' ;
        $code = input("?post.code") ? input("post.code") : '' ;
        $phone = input("?post.phone") ? input("post.phone") : '' ;
        $image = config("default")["IMAGE_USER"] ;
        $time = date( "Y-m-d H:i:s" ,time() );
        $data = [
            "user_uid" => $name ,
            "user_password" => md5($pwd) ,
            "user_phone" => $phone ,
            "user_time" => $time ,
            "user_image" => $image
        ] ;
        // 获取session缓存中的手机号码
        $sessionPhone = SESSION::get($phone) ;
        // 手机号码是否为空
        if( empty($phone) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['PHONE_EMPTY'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 是否为发送验证码的手机号
        if( strcmp($sessionPhone,$phone)!=0 )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['ACCOUNT_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 用户名或密码是否为空
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
        // 密码是否相同
        if( strcmp($pwd,$pwd2)!=0 )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('registerMsg')['PASSWORD_TWO_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
        $where = [
            "user_uid" => $name
        ] ;
        // 用户名是否已存在
        $userEmp = Db("user_user")->where($where)->find() ;
        // 用户名是否已存在
        if( !empty($userEmp) )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['ACCOUNT_REPEAT'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 插入数据
        $res = Db("user_user")->insert($data) ;
        $returnJson = [
            'code' => 10000 ,
            'msg' => config('registerMsg')['SUCCESS'] ,
            'data' => $res
        ] ;
        echo json_encode($returnJson) ;
    }
    /**
     * 功能描述：店家注册
     * 参数：
     * QQUser：
     * 返回：注册是否成功
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function phoneRegisterStore()
    {
        $that = new \user() ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('registerMsg')['LOSE'] ,
            'data' => []
        ] ;
        $tel = input("?post.tel") ? input("post.tel") : "" ;
        $code = input("?post.code") ? input("post.code") : "" ;
        $name = input("?post.name") ? input("post.name") : "" ;
        $image = config("default")["IMAGE_STORE"] ;

        $data = [
            "store_name" => $name ,
            "store_phone" => $tel ,
            "store_image" => $image ,
            "store_apply_time" => date('Y-m-d H:i:s',time())
        ] ;

        // 获取session缓存中的手机号码
        $sessionPhone = SESSION::get($tel) ;

        // 手机号码是否为空
        $that->emptyData($tel,'loginMsg','PHONE_EMPTY') ;

        // 验证码是否为空
        $that->emptyData($code,'loginMsg','CODE_EMPTY') ;

        // 店名是否为空
        $that->emptyData($name,'registerMsg','REGISTER_STORE_NAME_EMPTY') ;

        // 是否为发送验证码的手机号
        if( strcmp($sessionPhone,$tel)!=0 )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('registerMsg')['PHONE_ALIKE'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }

        // 店名是否相同
        $where = [
            "store_name" => $name
        ] ;
        $resStoreName = Db("store_info")->where($where)->find() ;
        $that->issetData( "store_info" ,$where ,"registerMsg" ,'STORE_EXISTS' ) ;

        // 绑定的手机是否存在
        $where = [
            "store_phone" => $tel
        ] ;
        $that->issetData( "store_info" ,$where ,"registerMsg" ,'PHONE_EXISTS' ) ;

        // 填入注册信息
        $res = Db("store_info")->insert($data) ;
        // 是否注册成功
        $that->emptyData($res,'registerMsg','REGISTER_DATA_EXISTS') ;

        echo json_encode($returnJson) ;

    }

    /**
     * 功能描述：发送验证码
     * 参数：
     * QQUser：
     * 返回：注册是否成功
     * 作者：yonjin L
     * 时间：18-3-27
     */
    public function getPhoneCode()
    {
        $that = new \user() ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('registerMsg')['PHONE_ERROR'] ,
            'data' => []
        ] ;
        $type = input("?post.type") ? input("post.type") : '' ;
        $phone = input("?post.name") ? input("post.name") : '' ;
        /*
         * 类型是否为空
         */
        $that->emptyData( $type ,'registerMsg' ,'LOSE' ) ;

        /*
         * 手机号码是否为空
         */
        $that->emptyData( $phone ,'registerMsg' ,'PHONE_EMPTY' ) ;

        /*
         * 发送验证码
         */
        // 设置验证码
        $code = 'qwertyuioplkjhgfdsazxcvbnm1234567890';
        $codeSet = '' ;
        for( $i = 0;$i < 4;$i++ )
        {
            $codeSet .= $code[mt_rand(0,35)] ;
        }
        // 存储验证码到session缓存
        $sessionName = $phone."loginCode" ;
        Session::set($sessionName,$codeSet) ;
        $codeSet2 = Session::get($sessionName) ;
        // 存储手机号码到session缓存
        $sessionPhoneName = $phone ;
        Session::set($sessionPhoneName,$phone) ;
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

        echo json_encode($returnJson) ;
    }


}