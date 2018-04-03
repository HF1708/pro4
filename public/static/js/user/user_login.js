/**
 * 登录注册导航跳转组件
 * lingyon L
 * 2018/3/31
 */

var Child_login = {
    template: '<div id="user_login_url"><a>登录</a></div>'
} ;
var Child_register = {
    template: '' +
    '<div id="user_register_url">' +
    '<a>注册</a>' +
    '</div>' +
    ''
} ;

new Vue({
    el: "#login-register" ,
    data:{
       user_login_jump:$login_jump ,
       user_register_jump:$register_jump ,
       out_login_show : true
    } ,
    components: {
        // 将只在父组件模板中可用
        'user-login': Child_login ,
        'user-register': Child_register
    } ,
    mounted:function(){
        // 添加跳转路径
        $("#user_login_url").children("a").eq(0).prop("href",this.user_login_jump) ;
        $("#user_register_url").children("a").eq(0).prop("href",this.user_register_jump) ;

        // 判断是否已登录
        this.userLoginAlready() ;

    } ,
    methods:{
        /**
         * 功能描述：用户是否已登录
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-1
         */
        userLoginAlready:function(){
            var that = this ;
            $.ajax({
                url:$user_login_already ,
                data:"" ,
                type:"post" ,
                dataType:"json" ,
                success:function(res){
                    if( res.code == 10000 )
                    {
                        $("#user_login_url").empty().append("<a href="+$user_person_url+" ><img style='width:30px ;height:30px ;' src="+res.data['image']+" /><span>"+res.data['name']+"</span></a>") ;
                        $("#user_register_url").empty().append("<a href='#' >退出</a>").children("a").eq(0).click(function(){
                            $.ajax({
                                url:$user_login_out ,
                                data:"" ,
                                type:"post" ,
                                dataType:"json" ,
                                success:function(res){
                                    if( res.code == 10000 )
                                    {
                                        window.location.reload() ;
                                    }
                                }
                            }) ;
                        }) ;
                    }
                }
            }) ;
        }
    }
}) ;
