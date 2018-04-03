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
        msg_footer_button_exit:'loginMsgModel_exit'

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
            console.log((type)) ;
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
            $data = {name:$names,type:type};
            $.ajax({
                url:$code_user_url,
                type:'post' ,
                data:$data ,
                dataType:'json' ,
                success:function(res){
                    if( that.shortJudgeUser == 'T' ) {
                        that.setMsgTime(type);
                    }
                    else if( that.shortJudgeStore == 'T' )
                    {
                        that.setMsgTime(type);
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

            }, 10) ;
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
                    if( res['code'] == 10000 )
                    {
                        that.Msg_footer_link = $user_person_url ;
                        $("#loginMsgModel").modal('show') ;
                    }
                    else
                    {
                        that.Msg_head = '注册' ;
                        that.Msg_body = res['msg'] ;
                        that.Msg_footer = '确认' ;
                        that.Msg_footer_link = "#loginMsgModel" ;
                        $("#loginMsgModel").modal('show') ;
                    }
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
                    if( res['code'] == 10000 )
                    {
                        that.Msg_footer_link = $user_person_url ;
                        $("#loginMsgModel").modal('show') ;
                    }
                    else
                    {
                        that.Msg_head = '注册' ;
                        that.Msg_body = res['msg'] ;
                        that.Msg_footer = '确认' ;
                        that.Msg_footer_link = "#loginMsgModel" ;
                        $("#loginMsgModel").modal('show') ;
                    }
                }
            }) ;
        }
    }
}) ;