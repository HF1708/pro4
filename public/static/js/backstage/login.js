
/**
 * 登录注册导航跳转组件
 * lingyon L
 * 2018/3/31
 */




var login = new Vue({
    el: "#login-backstage" ,
    data:{
        defaultImage:defaultImage ,
        user_name:"登录" ,
        out_login_show : false ,
        set_out_time:5 ,
        set_out_msg:""
    } ,
    mounted:function(){
        // 判断是否已登录
        this.userLoginAlready() ;

    } ,
    methods:{
        /**
         * 功能描述：用户是否已登录 是则修改信息(实现未登录页面跳转到登录页面)
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-1
         */
        userLoginAlready:function(){
            var that = this ;
            $.ajax({
                url:backstage_login_already ,
                data:"" ,
                type:"post" ,
                dataType:"json" ,
                success:function(res){
                    console.log(res) ;
                    if( res.code == 10000 )
                    {
                        that.out_login_show = true ;
                        that.user_name = res.data['name'] ;
                        that.defaultImage =  res.data['image'] ;
                    }
                    else
                    {
                        that.out_login_show = false ;
                        that.user_name = "登录" ;
                        that.defaultImage =  defaultImage ;
                    }
                    if( res.data['setJump'] == "N" )
                    {
                        window.location.href=login_page ;
                    }

                }
            }) ;
        } ,
        /**
         * 功能描述：退出登录
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-2
         */
        outLogin:function(){
            var that = this ;
            that.set_out_msg = "·" ;
            layui.use('layer', function(){
                layer.msg("用户正在退出···") ;
            });

            $.ajax({
                url:out_login_url ,
                data:"" ,
                type:"post" ,
                dataType:"json" ,
                success:function(res){

                    // 退出成功
                    if( res.code == 10000 )
                    {
                        setInterval(function(){
                            layui.use('layer', function(){
                                if( that.set_out_time == 0 )
                                {
                                    window.location.href = login_page ;
                                }
                                var layer = layui.layer ;
                                layer.msg("用户已成功退出,"+that.set_out_time+"秒后前往登录页面") ;
                                that.set_out_time--;
                            });
                        },1000) ;

                    }
                    // 退出失败，提示
                    else if( res.code == 10001 )
                    {
                        setTimeout(function(){
                            layui.use('layer', function(){
                                layer.msg(res.msg) ;
                            }) ;
                        },1000) ;
                    }
                    // 退出失败，内置提示
                    else
                    {
                        setTimeout(function(){
                            layui.use('layer', function(){
                                layer.msg("服务器繁忙，请重新退出") ;
                            }) ;
                        },1000) ;
                    }
                }
            }) ;
        } ,
        outLoginStore:function(){
            var that = this ;
            $.ajax({
                url:out_login_url ,
                data:"" ,
                type:"post" ,
                dataType:"json" ,
                success:function(res){
                    that.out_login_show = false ;
                    that.user_name = "登录" ;
                    that.defaultImage =  defaultImage ;
                    window.location.href=login_page ;
                }
            }) ;
        } ,
        /**
         * 功能描述：几秒后刷新页面
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-2
         */
        setTimeTwo:function(){
            setTimeout(top.location.reload(),2000) ;
        }

    }
}) ;












