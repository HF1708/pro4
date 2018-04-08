$(".recent-news-grid").click(function (){
    window.open(storydetailUrl);
});
/**
 *  *  功能描述：写遊記（判断用户是否已登录）
 *  参数：无
 *  返回：无
 *  作者:min H
 *  时间：18-3-30
 **/
function publichNotes(){
    $.get($user_login_already,function(res){
        $code=JSON.parse(res).code;
        if($code==10000){
            window.location.href=publishnotesUrl;
        }else{
            alert("您好，请先登录");
        }
    })
}
var vue=new Vue({
    el:'#app',
    data:{
        user:[],
        notes:[]
    },
    methods:{
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
        getNotes:function () {
            this.notes=[];
            $.ajaxSetup({
                async: false
            });
            $.post(getNotesUrl,function (res) {
                this.notes=JSON.parse(res);

                console.log(this.notes);
            }.bind(this))
        }
    },
    mounted:function(){
        this.getNotes();
        console.log(88888888888888888888)
        console.log(this.notes)
    },
    beforeUpdate: function () {

    }
});

