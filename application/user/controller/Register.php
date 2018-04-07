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
        $data = [
            "user_uid" => $name ,
            "user_password" => md5($pwd) ,
            "user_phone" => $phone ,
            "user_time" => time()
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
        else
        {
            // 插入数据
            $res = Db("user_user")->insert($data) ;
            $id = Db("user_user")->getLastInsID() ;
            $getData = Db("user_user")->where("user_id",$id)->find() ;

            $getData['userType'] = "user" ;
            Session::set('loginData',serialize($getData));
            $returnJson = [
                'code' => 10000 ,
                'msg' => config('registerMsg')['SUCCESS'] ,
                'data' => $res
            ] ;
            echo json_encode($returnJson) ;
        }


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
        $tel = input("?post.tel") ? input("post.tel") : "" ;
        $code = input("?post.code") ? input("post.code") : "" ;
        $name = input("?post.name") ? input("post.name") : "" ;
        $that = new \user() ;
        // 获取session缓存中的手机号码
        $sessionPhone = SESSION::get($tel) ;
        $returnJson = [
            'code' => 10001 ,
            'msg' => config('registerMsg')['LOSE'] ,
            'data' => []
        ] ;


        $data = [
            "store_name" => $name ,
            "store_phone" => $sessionPhone ,
            "store_apply_time" => date('Y-m-d H:i:s',time())
        ] ;

        // 店名是否为空
        $that->emptyData($name,'registerMsg','REGISTER_STORE_NAME_EMPTY',"",10003) ;
        // 店名是否相同
        $where = [
            "store_name" => $name
        ] ;
        $resStoreName = Db("store_info")->where($where)->find() ;
        $that->issetData( "store_info" ,$where ,"registerMsg" ,'STORE_EXISTS',"",10003 ) ;

        // 手机号码是否为空
        $that->emptyData($tel,'loginMsg','PHONE_EMPTY') ;
        // 是否为发送验证码的手机号
        if( strcmp($sessionPhone,$tel)!=0 )
        {
            $returnJson = [
                'code' => 10001 ,
                'msg' => config('loginMsg')['PHONE_NUMBER_ERROR'] ,
                'data' => []
            ] ;
            echo json_encode($returnJson) ;
            exit ;
        }
        // 绑定的手机是否存在
        $where = [
            "store_phone" => $sessionPhone
        ] ;
        $that->issetData( "store_info" ,$where ,"registerMsg" ,'PHONE_EXISTS' ) ;

        // 验证码是否为空
        $that->emptyData($code,'loginMsg','CODE_EMPTY',"",10002) ;
        // 验证码是否错误
        $sessionName = $tel."loginCode" ;
        $codeSet2 = Session::get($sessionName) ;
        $that->strcmpData($code,$codeSet2,"loginMsg","CODE_ERROR","",10002) ;

        // 填入注册信息
        $res = Db("store_info")->insert($data) ;
        $id = Db("store_info")->getLastInsID() ;
        $getData = Db("store_info")->where("store_id",$id)->find() ;

        $getData['userType'] = "store" ;
        Session::set('loginData',serialize($getData));
        // 是否注册成功
//        $that->emptyData($res,'registerMsg','REGISTER_DATA_EXISTS') ;
        // 存入session信息

        $returnJson = [
            'code' => 10000 ,
            'msg' => config('registerMsg')['SUCCESS'] ,
            'data' => $res
        ] ;
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
         * 手机号码是否合法
         */
        // 不合法返回信息
        if( !$that->checkMobileValidity($phone) )
        {
            $that->returnJson("loginMsg","PHONE_ERROR") ;
        }


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

    /**
     * 失焦验证
     */
    public function blurUser()
    {

        $that = new \user() ;
        $type = $that->getData("type","loginMsg","DARA_TYPE_ERROR") ;
        // 失焦验证
        switch($type)
        {
            // 用户名
            case "userName":
                // 用户名
                $name = $that->getData("name","loginMsg","ACCOUNT_NAME_EMPTY") ;
                $res = $that->ifData1($name,$type) ;
                if( strcmp($res,'f1')==0 )
                {
                    $where = [
                        "user_uid" => $name
                    ] ;
                    // 用户名是否已存在
                    $userEmp = Db("user_user")->where($where)->find() ;
                    // 用户名是否已存在
                    if( !empty($userEmp) )
                    {
                        // 用户名已存在
                        $returnJson = [
                            'code' => 10003 ,
                            'msg' => config('loginMsg')['ACCOUNT_REPEAT'] ,
                            'data' => []
                        ] ;
                        echo json_encode($returnJson) ;
                        exit ;
                    }

                    $that->returnJson("loginMsg","DATA_SUCCESS","",10000) ;
                }
                else
                {
                    // 数据异常
                    $that->returnJson("loginMsg","DATA_SUCCESS","",10002) ;
                }
                break ;
            // 手机号码
            case "userPhone":
                // 手机号码
                $phone = $that->getData("phone","loginMsg","PHONE_EMPTY") ;
                /*
                 * 手机号码是否合法
                 */
                // 不合法返回信息
                if( !$that->checkMobileValidity($phone) )
                {
                    $that->returnJson("loginMsg","PHONE_ERROR") ;
                }
                $that->returnJson("loginMsg","DATA_SUCCESS","",10000) ;
                break ;
            // 店名
            case "storeName":
                // 获取店名，并判断是否为空
                $name = $that->getData("name","registerMsg","REGISTER_STORE_NAME_EMPTY") ;
                // 店名是否相同
                $where = [
                    "store_name" => $name
                ] ;
                $that->issetData( "store_info" ,$where ,"registerMsg" ,'STORE_EXISTS' ) ;
                // 返回正确信息
                $that->returnJson("loginMsg","DATA_SUCCESS","",10000) ;
                break ;
        }

    }


}