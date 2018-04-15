$('.carousel').carousel({
    interval: 5000 // in milliseconds
}) ;
$(".modal-backdrop").remove() ;
//	$("#loginMsgModel").modal('show') ;
var app = new Vue({
    el:"#myApp" ,
    data: {
        shortMsg:"获取验证码" ,
        shortShow:true ,
        shortTimeMsg:'秒后重发' ,
        shortJudge:'T' ,
        Msg_head:'登录' ,
        Msg_body:'登录成功' ,
        Msg_footer:'确认' ,
        Msg_footer_link:$user_person_url ,
        msg_footer_button_exit:'loginMsgModel_exit' ,
        msg_login_success_show:false ,
        code_msg_user:"请正确输入验证码" ,
        code_msg_user_show:false ,
        code_msg_phone:"请正确输入验证码" ,
        code_msg_phone_show:false ,
        code_msg_phone_number:"" ,
        code_msg_phone_number_show:false

    } ,
    methods: {
        /**
         * 功能描述：修改验证码
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-25
         */
        setCaptcha:function(event)
        {
            $(event.target).attr('src',$code_url_1) ;
        } ,
        /**
         * 功能描述：发送短信验证码给用户
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-24
         */
        getPhoneMsg: function(){
            var that = this ;
            var $name = $("#register_name").val() ;
            $dataTel = {
                tel : $name
            } ;
            if( that.shortJudge == 'T' )
            {
                $.ajax({
                    url:$code_user_url_1 ,
                    type:'post' ,
                    data:$dataTel ,
                    dataType:'json' ,
                    success:function(res){
                        // 验证码成功发送，则提示
                        if( res.code == 10000 )
                        {
                            that.code_msg_phone_number_show = false ;
                            that.shortTimeMsg = 60 ;
                            that.shortMsg = "60秒后重发" ;
                            that.shortJudge = 'F' ;
                            that.shortShow = false ;
                            var setTimeInterval = setInterval(function () {
                                that.shortTimeMsg-- ;
                                that.shortMsg = that.shortTimeMsg+"秒后重发" ;
                                if(that.shortTimeMsg <= 0)
                                {
                                    that.shortTimeMsg = '秒后重发' ;
                                    that.shortMsg = "获取验证码" ;
                                    that.shortJudge = 'T' ;
                                    that.shortShow = true ;
                                    clearInterval(setTimeInterval) ;
                                }
                            }, 1000) ;
                        }
                        else
                        {
                            if( res.code == 10002 )
                            {
                                that.code_msg_phone_number_show = true ;
                                that.code_msg_phone_number = res.msg ;
                            }
                        }
                    }
                })
            }

        } ,
        /**
         * 功能描述：用户登录
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-24
         */
        login:function(){
            var that = this ;
            // 防止店家登录后有点用登录
            // 先关闭链接按钮
            that.msg_login_success_show = false ;
            that.code_msg_user_show = false ;
            var $name = $("#login_user").val() ;
            var $pwd = $("#login_pwd").val() ;
            var $code = $("#login_code").val() ;
            var $data = {
                name : $name ,
                pwd : $pwd ,
                code : $code
            } ;
            $.ajax({
                url:$user_login_url_1 ,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    console.log(res) ;
                    if( res.code == 10000 )
                    {
                        that.Msg_body='登录成功';
                        that.msg_login_success_show=true ;
                        $("#loginMsgModel").modal('show') ;

                    }
                    else if( res.code == 10002 )
                    {
                        that.code_msg_user_show = true;
                        that.code_msg_user = res.msg;
                    }
                    else if( res.code == 10003 )
                    {
                        that.Msg_body=res.msg;
                        that.msg_login_success_show=false ;
                        $("#loginMsgModel").modal('show') ;
                    }
                    else
                    {

                        that.Msg_footer_link = "" ;
                    }
                    //$("#loginMsgModel").modal('show') ;
                }
            }) ;
        } ,
        /**
         * 功能描述：店家登录（用手机号码登录）
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-25
         */
        phoneLogin:function(){
            var that = this ;
            // 防止用户登录后有点用登录
            // 先关闭链接按钮
            that.msg_login_success_show = false ;
            var $name = $("#register_name").val() ;
            var $code = $("#register_code").val() ;
            var $data = {
                name : $name ,
                code : $code
            } ;
            $.ajax({
                url:$user_login_phone_url_1 ,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    that.code_msg_phone_show = false ;
                    if( res.code == 10000 )
                    {
                        // 商家登录成功跳转
                        that.Msg_footer_link = $store_jump ;
                        that.msg_login_success_show = true ;
                    }
                    else if( res.code == 10002 )
                    {
                        that.code_msg_phone_show = true ;
                        that.code_msg_phone = res.msg ;
                        return ;
                    }
                    else
                    {
                        that.Msg_footer_link = "" ;
                    }
                    that.Msg_head = '登录' ;
                    that.Msg_body = res['msg'] ;
                    that.Msg_footer = '确认' ;
                    $("#loginMsgModel").modal('show') ;
                }
            }) ;
        } ,
        /**
         * 功能描述：短信验证码输入是否合法
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-5
         */
        code_verification:function(e)
        {
            var that = this ;
            $data = ($(e.target).val()) ;
            if( $data.length < 4 )
            {
                that.code_msg_user = "请正确输入验证码" ;
                that.code_msg_user_show = true ;
            }
            else
            {
                that.code_msg_user_show = false ;
            }
        } ,
        /**
         * 功能描述：手机格式的失焦验证
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-7
         */
        phone_number:function(e)
        {
            var that = this ;
            //$phone_number_blur
            $data = {
                phone:$(e.target).val()
            } ;
            $.ajax({
                url:$phone_number_blur ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res)
                {
                    that.code_msg_phone_show = false ;
                    if( res.code == 10002 )
                    {
                        that.code_msg_phone_number_show = true ;
                        that.code_msg_phone_number = res.msg ;
                    }
                }
            }) ;
        }

    }
}) ;
