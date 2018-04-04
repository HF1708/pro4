/*$(function () {
    $.post(getNotesUrl,function (res) {
        $notes=JSON.parse(res);
        // console.log($notes[0]['content']);
        $content=$notes[0]['content'];
        $content=escape2Html($content)
        console.log($content);
        $("#notes_con").html($content);

        /!**
         *  *  功能描述：标签转换
         *  参数：str
         *  返回：转换的标签
         *  作者:min H
         *  时间：18-4-3
         **!/
        function escape2Html(str) {
            var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
            return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];});
        }
    });
})*/

new Vue({
    el:"#userInfo",
    data:{
        userIntro:""
    },
    mounted:function () {
        this.getuserIntro();
    },
    methods:{
        /**
         * 功能描述：获取用户简介信息
         * 参数：
         * QQUser：
         * 返回：用户简介信息
         * 作者：Lin YiZhe
         * 时间：18-3-29
         */
        getuserIntro:function () {
            var user_uid=$("#userInfo").attr("uid");
            var that = this ;
            $.ajax({
                url:getIntroUrl,
                data:{"user_uid":user_uid},
                type:"post",
                dataType:"json",
                success:function (res) {
                    that.userIntro=res.user_msg;
                }
            });
        },
        /**
         * 功能描述：弹出修改个人简介框
         * 参数：
         * QQUser：
         * 返回：
         * 作者：Lin YiZhe
         * 时间：18-4-2
         */

        show:function () {
            //隐藏简介框
            $("#userIntro").hide();
            //隐藏按钮
            $("#introBtn").hide();
            //显示填写区
            $("#inputIntro").show();
        },
        /**
         * 功能描述：将修改的信息保存
         * 参数：
         * QQUser：
         * 返回：修改后的简介
         * 作者：Lin YiZhe
         * 时间：18-4-2
         */
        saveIntro:function () {
            var newUserIntro=$("#myIntro").val();
            var that = this ;
            $.ajax({
                url:changeUrl,
                data:{"nweUserIntro":newUserIntro},
                type:"post",
                dataType:"json",
                success:function (res) {
                    console.log(res);
                    if(res==1){
                        $("#inputIntro").hide();
                        that.getuserIntro();
                    }
                }
            });
        }
    }
});
