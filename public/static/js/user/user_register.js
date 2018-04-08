$('.carousel').carousel({
    interval: 5000 // in milliseconds
}) ;
$(".modal-backdrop").remove() ;
//	$("#loginMsgModel").modal('show') ;
var app = new Vue({
    el:"#myApp" ,
    data: {
        shortMsg:"获取验证码" ,
        shortMsgUser:"获取验证码" ,
        shortMsgStore:"获取验证码" ,
        shortShowUser:true ,
        shortShowStore:true ,
        shortTimeMsgUser:'秒后重发' ,
        shortTimeMsgStore:'秒后重发' ,
        shortJudgeUser:'T' ,
        shortJudgeStore:'T' ,
        Msg_head:'登录' ,
        Msg_body:'登录成功' ,
        Msg_footer:'确认' ,
        Msg_footer_link:'#' ,
        msg_footer_button_exit:'loginMsgModel_exit' ,
        msg_login_success_show:false ,
        msg_login_user_name:"用户名不能为空" ,
        msg_login_user_name_show:false ,
        msg_login_user_pwd:"密码不能为空" ,
        msg_login_user_pwd_show:false ,
        msg_login_user_pwd2:"密码不能为空" ,
        msg_login_user_pwd2_show:false ,
        msg_login_user_phone:"手机号码不能为空" ,
        msg_login_user_phone_show:false ,
        msg_login_user_code:"验证码不能为空" ,
        msg_login_user_code_show:false ,
        msg_login_store_name:"店名名不能为空" ,
        msg_login_store_name_show:false ,
        msg_login_store_phone:"手机号码不能为空" ,
        msg_login_store_phone_show:false ,
        msg_login_store_code:"短信验证码不能为空" ,
        msg_login_store_code_show:false

    } ,
    methods: {

        /**
         * 功能描述：发送短信验证码给用户/店家
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-25
         */
        getPhoneMsg: function(type){
            var that = this ;
            if( type == 'user' )
            {
                var $names = $("#register_name_user").val() ;
                that.shortJudgeUser = 'T' ;
            }
            else
            {
                var $names = $("#register_name_stroe").val() ;
                that.shortJudgeStore = 'T' ;

            }
            $data = {name:$names,type:type} ;
            $.ajax({
                url:$code_user_url ,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    if( that.shortJudgeUser == 'T' ) {
                        if( res.code == 10000 ) that.setMsgTime(type) ;
                    }
                    else if( that.shortJudgeStore == 'T' )
                    {
                        if( res.code == 10000 ) that.setMsgTime(type) ;
                    }
                    else
                    {
                        console.log('届不到') ;
                    }
                    console.log(res) ;

                }
            }) ;

        } ,
        /**
         * 功能描述：设置验证码的倒计时
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-27
         */
        setMsgTime:function(type)
        {
            var that = this ;
            if( type == 'user' )
            {
                that.shortShowUser = false ;
                that.shortTimeMsgUser = 60 ;
                that.shortMsgUser = that.shortTimeMsgUser+"秒后重发" ;
            }
            else
            {
                that.shortShowStore = false ;
                that.shortTimeMsgStore = 60 ;
                that.shortMsgStore = that.shortTimeMsgStore+"秒后重发" ;
            }
            that.shortMsg = "60秒后重发" ;
            that.shortJudge = 'F' ;
            var setTimeInterval = setInterval(function () {
                if( type == 'user' )
                {
                    that.shortTimeMsgUser-- ;
                    that.shortMsgUser = that.shortTimeMsgUser+"秒后重发" ;
                    if(that.shortTimeMsgUser <= 0)
                    {
                        that.shortTimeMsg = '秒后重发' ;
                        that.shortMsgUser = "获取验证码" ;
                        that.shortJudge = 'T' ;
                        if( type == 'user' )
                        {
                            that.shortShowUser = true ;
                        }
                        else
                        {
                            that.shortShowStore = true ;
                        }
                        clearInterval(setTimeInterval) ;
                    }
                }
                else
                {
                    that.shortTimeMsgStore-- ;
                    that.shortMsgStore = that.shortTimeMsgStore+"秒后重发" ;
                    if(that.shortTimeMsgStore <= 0)
                    {
                        that.shortTimeMsg = '秒后重发' ;
                        that.shortMsgStore = "获取验证码" ;
                        that.shortJudge = 'T' ;
                        if( type == 'user' )
                        {
                            that.shortShowUser = true ;
                        }
                        else
                        {
                            that.shortShowStore = true ;
                        }
                        clearInterval(setTimeInterval) ;
                    }
                }

            }, 1000) ;
        } ,
        /**
         * 功能描述：用户注册
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-25
         */
        register:function(){
            var that = this ;

            that.msg_login_success_show = false ;

            var $name = $("#register_user").val() ;
            var $pwd = $("#register_pwd").val() ;
            var $pwd2 = $("#register_pwd2").val() ;
            var $code = $("#register_code_user").val() ;
            var $phone = $("#register_name_user").val() ;
            var $data = {
                name : $name ,
                pwd : $pwd ,
                pwd2 : $pwd2 ,
                code : $code ,
                phone : $phone
            } ;
            $.ajax({
                url:$user_register ,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    console.log(res) ;
                    // 初始化提示
                    that.msg_login_user_phone_show = false ;
                    that.msg_login_user_name_show = false ;
                    that.msg_login_user_pwd_show = false ;
                    that.msg_login_user_code_show = false ;
                    that.msg_login_user_pwd2_show = false ;
                    if( res.code == 10000 )
                    {
                        that.msg_login_success_show = true ;
                        that.Msg_footer_link = $user_person_url ;
                        that.Msg_head = '注册' ;
                        that.Msg_body = res['msg'] ;
                        that.Msg_footer = '确认' ;
                        $("#loginMsgModel").modal('show') ;
                    }
                        // 手机
                    else if( res.code == 10001 )
                    {
                        that.msg_login_user_phone_show = true ;
                        that.msg_login_user_phone = res.msg ;
                    }
                        // 用户名
                    else if( res.code == 10002 )
                    {
                        that.msg_login_user_name_show = true ;
                        that.msg_login_user_name = res.msg ;
                    }
                        // 密码1
                    else if( res.code == 10003 )
                    {
                        that.msg_login_user_pwd_show = true ;
                        that.msg_login_user_pwd = res.msg ;
                    }
                        // 验证码
                    else if( res.code == 10004 )
                    {
                        that.msg_login_user_code_show = true ;
                        that.msg_login_user_code = res.msg ;
                    }
                        // 密码1密码2是否相同
                    else if( res.code == 10005 )
                    {
                        that.msg_login_user_pwd2_show = true ;
                        that.msg_login_user_pwd2 = "密码不同" ;
                    }
                    //else
                    //{
                    //    that.Msg_footer_link = "" ;
                    //}

                }
            }) ;
        } ,
        /**
         * 功能描述：店家注册（只能手机号码注册）
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-25
         */
        phoneRegister:function(){
            var that = this ;
            that.msg_login_success_show = false ;
            var $tel = $("#register_name_stroe").val() ;
            var $code = $("#register_code_stroe").val() ;
            var $name = $("#register_nameStore").val() ;
            var $data = {
                tel : $tel ,
                name : $name ,
                code : $code
            } ;
            $.ajax({
                url:$store_register,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    // 隐藏提示
                    that.msg_login_store_phone_show = false ;
                    that.msg_login_store_name_show = false ;
                    that.msg_login_store_code_show = false ;
                    if( res.code == 10000 )
                    {
                        that.msg_login_success_show = true ;

                        that.Msg_footer_link = $store_jump ;

                        that.Msg_head = '注册' ;
                        that.Msg_body = res['msg'] ;
                        that.Msg_footer = '确认' ;
                        $("#loginMsgModel").modal('show') ;

                    }
                    //店名
                    else if( res.code == 10003 )
                    {
                        that.Msg_footer_link = "" ;
                        // 店名异常
                        that.msg_login_store_name_show = true ;
                        that.msg_login_store_name = res.msg ;
                    }

                    // 验证码
                    else if( res.code == 10002 )
                    {
                        that.Msg_footer_link = "" ;
                        // 验证码格式异常
                        that.msg_login_store_code = res.msg ;
                        that.msg_login_store_code_show = true ;
                    }
                    // 手机号码错误
                    else if( res.code == 10001 )
                    {
                        that.Msg_footer_link = "" ;
                        // 用户手机号码格式异常
                        that.msg_login_store_phone_show = true ;
                        that.msg_login_store_phone = res.msg ;
                    }
                    else
                    {
                        that.Msg_footer_link = "" ;
                    }
                }
            }) ;
        } ,
        /**
         * 功能描述：店家短信验证码失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_store_code:function(e){
            var that = this ;
            $code = ($(e.target).val()) ;
            if( $code.length < 4 && $code.length != 0 )
            {
                that.msg_login_store_code = "验证码太短" ;
                that.msg_login_store_code_show = true ;

            }
            else if( $code.length == 0 )
            {
                that.msg_login_store_code = "验证码不能为空" ;
                that.msg_login_store_code_show = true ;
            }
            else
            {
                that.msg_login_store_code_show = false ;
            }
        } ,
        /**
         * 功能描述：店家手机号码失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_store_phone:function(e)
        {
            var that = this ;
            $data = {
                phone:($(e.target).val()) ,
                type:"userPhone"
            } ;
            $.ajax({
                url:$blur_user_name_url ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res){
                    if( res.code == 10000 )
                    {
                        // 隐藏提示
                        that.msg_login_store_phone_show = false ;
                    }
                    else
                    {
                        // 用户手机号码格式异常
                        that.msg_login_store_phone_show = true ;
                        that.msg_login_store_phone = res.msg ;
                    }
                }
            }) ;
        } ,
        /**
         * 功能描述：店名失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_store_name:function(e)
        {
            var that = this ;
            $data = {
                name:($(e.target).val()) ,
                type:"storeName"
            } ;
            $.ajax({
                url:$blur_user_name_url ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res){
                    console.log(res) ;
                    if( res.code == 10000 )
                    {
                        // 隐藏提示
                        that.msg_login_store_name_show = false ;
                    }
                    else
                    {
                        // 店名格式异常
                        that.msg_login_store_name_show = true ;
                        that.msg_login_store_name = res.msg ;
                    }
                }
            }) ;
        } ,
        /**
         * 功能描述：用户短信验证码失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_user_code:function(e){
            var that = this ;
            $code = ($(e.target).val()) ;
            if( $code.length < 4 )
            {
                that.msg_login_user_code = "验证码长度不足" ;
                that.msg_login_user_code_show = true ;

            }
            else if( $code.length == 0 )
            {
                that.msg_login_user_code = "验证码不能为空" ;
                that.msg_login_user_code_show = true ;
            }
            else
            {
                that.msg_login_user_code_show = false ;
            }
        } ,
        /**
         * 功能描述：用户手机号码失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_user_phone:function(e)
        {
            var that = this ;
            $data = {
                phone:($(e.target).val()) ,
                type:"userPhone"
            } ;
            $.ajax({
                url:$blur_user_name_url ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res){
                    if( res.code == 10000 )
                    {
                        // 隐藏提示
                        that.msg_login_user_phone_show = false ;
                    }
                    else
                    {
                        // 用户名格式异常
                        that.msg_login_user_phone_show = true ;
                        that.msg_login_user_phone = res.msg ;
                    }
                }
            }) ;
        } ,
        /**
         * 功能描述：用户密码失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_user_pwd2:function(e)
        {
            var that = this ;
            $pwd = $("#register_pwd").val() ;
            $pwd2 = ($(e.target).val()) ;
            // 密码是否相同
            if( $pwd != $pwd2 )
            {
                // 不同
                that.msg_login_user_pwd2_show = true ;
                that.msg_login_user_pwd2 = "两次输入密码不同" ;
            }
            else
            {
                // 相同
                that.msg_login_user_pwd2_show = false ;
            }
        } ,
        /**
         * 功能描述：用户名失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        blur_user_name:function(e)
        {
            var that = this ;
            $data = {
                name:($(e.target).val()) ,
                type:"userName"
            } ;
            $.ajax({
                url:$blur_user_name_url ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res){
                    if( res.code == 10000 )
                    {
                        // 隐藏提示
                        that.msg_login_user_name_show = false ;
                    }
                    else if( res.code == 10002 )
                    {
                        // 用户名格式异常
                        that.msg_login_user_name_show = true ;
                        that.msg_login_user_name = "用户名格式错误" ;
                    }
                    else
                    {
                        // 用户名格式异常
                        that.msg_login_user_name_show = true ;
                        that.msg_login_user_name = res.msg ;
                    }
                }
            }) ;
        }
    }
}) ;