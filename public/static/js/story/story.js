$(".recent-news-grid").click(function (){
    window.open(storydetailUrl);
});

var story=new Vue({
    el:'#app',
    data:{
        user:[],
        notes:[],
        not_logged_in:'继续操作前请先登录',
        msg_login_success_show:true,
        Msg_head:'登录' ,
        Msg_footer:'确认' ,
        Msg_footer_link:$login_jump
    },
    methods:{
        /**
         *  *  功能描述：写遊記（判断用户是否已登录）
         *  参数：无
         *  返回：无
         *  作者:min H
         *  时间：18-3-30
         **/
        publichNotes:function(){
            $.get($user_login_already,function(res){
                $code=JSON.parse(res).code;
                if($code==10000){
                    window.location.href=publishnotesUrl;
                }else{
                    this.msg_login_success_show = false ;
                    $("#loginMsgModel").modal('show') ;
                }
            })
        }
        // getUser:function () {
        //     this.user=[];
        //     $.ajaxSetup({
        //         async: false
        //     });
        //     $.post(getUserUrl,function (res) {
        //         var userArr=JSON.parse(res);
        //         this.city=userArr;
        //     }.bind(this))
        // },
        // getNotes:function () {
        //     this.notes=[];
        //     $.ajaxSetup({
        //         async: false
        //     });
        //     $.post(getNotesUrl,function (res) {
        //         this.notes=JSON.parse(res);
        //
        //         console.log(this.notes);
        //     }.bind(this))
        // }
    },
    mounted:function(){
        console.log(88888888888888888888)
        console.log(this.notes)
    },
    beforeUpdate: function () {

    }
});

