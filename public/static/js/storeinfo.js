var store=new Vue({
    el: "#myapp" ,
    data:{
        user_name:"" ,
        store_phone:""
    } ,
    mounted:function(){
        this.getInfo();

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
        getInfo:function(){
            var that = this ;
            $.ajax({
                url:getinfoUrl ,
                data:"" ,
                type:"post" ,
                dataType:"json" ,
                success:function(res){
                    if( res.code == 10000 )
                    {
                        that.user_name = res.data['name'] ;
                        that.store_phone = res.data['store_phone'] ;
                    }
                    if( res.data['setJump'] == "N" )
                    {
                        window.location.href=login_page ;
                    }
                }.bind(this)
            }) ;
        }
    }
}) ;
