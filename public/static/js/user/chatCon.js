/**
 * 登录注册导航跳转组件
 * lingyon L
 * 2018/3/31
 */

var Chat_con = {
    template: '<div class="chatCon">' +
        '<div class="chatCon_img">' +
        '<img src="http://p6gnb5g93.bkt.clouddn.com/chat.png" class="" />' +
        '</div>' +
        '<div class="chatCon_img">' +
        '<a href="'+$chat_url+'" class="btn btn-link " >联系商家</a>' +
        '</div>' +
    '</div>'
} ;

new Vue({
    el: "#chat_con" ,
    data:{
    } ,
    components: {
        // 将只在父组件模板中可用
        'chat_con': Chat_con
    } ,
    methods:{

    } ,
    mounted:function(){
        $(".chatCon").css({
            position:"fixed" ,
            top:"30%" ,
            right:"1%" ,
            width:"100px" ,
            height:"70px" ,
            border:"1px solid grey" ,
            backgroundColor:"#FFF"
        }) ;
        $(".chatCon_img").css({
            display:"flex" ,
            justifyContent:"center"
        }) ;

    }
}) ;
