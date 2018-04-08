$('.carousel').carousel({
    interval: 5000 // in milliseconds
}) ;
$(".modal-backdrop").remove() ;
//	$("#loginMsgModel").modal('show') ;
var app = new Vue({
    el:"#myApp" ,
    data: {
        Msg_head:'登录' ,
        Msg_body:'登录成功' ,
        Msg_footer:'确认' ,
        Msg_footer_link:'#' ,
        msg_footer_button_exit:'loginMsgModel_exit' ,
        chat_one:'游客123' ,
        chat_one_title:'' ,
        chat_one_image:'' ,
        chat_two:'hf170809' ,
        chat_two_title:'' ,
        chat_two_image:'' ,
        chat_type: 'store_user' ,
        chat_obj:'' ,
        chat_data:[] ,
        login:'' ,
        ws: ''

    } ,
    methods: {
        /**
         * 功能描述：发送聊天内容
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-28
         */
        sendMsg: function()
        {
            var that = this ;
            var msg = $("#message").text() ;

            $data = {
                message : msg ,
                time : nowDdate() ,
                type : that.chat_type ,
                setPut:that.chat_one ,
                chat_login:that.login ,
                chat_image: that.chat_one_image
            } ;
            $data_2 = {
                chat_con:msg ,
                chat_title:that.chat_one ,
                chat_image:that.chat_one_image ,
                chat_login:that.login
            } ;
            that.chat_data.push($data_2) ;
            that.ws.send( sendData( that.chat_one ,that.chat_two ,'message' ,$data ) ) ;
            var div = document.getElementById('chat') ;
            div.scrollTop = div.scrollHeight ;
            setTimeout(function(){div.scrollTop = div.scrollHeight} , 50) ;
        }
    } ,
    mounted:function(){
        var that = this ;
        /*
         获取聊天记录
         */
        // 获取聊天对象
        $.ajax({
            url:$chat_obj_url ,
            type:'post' ,
            dataType:'json' ,
            data:{chatTwo:'hf170809',chatType:'server'} ,
            success:function(res){
                that.login = res.login ;
                that.chat_type = res.chat_type ;

                that.chat_one=res.user ;
                console.log(res) ;

                // 为游客123
                if( res.user == '游客123' )
                {
                    that.chat_one=res.user ;
                    that.chat_one_title = res.chat_one_title ;
                    that.chat_one_image = res.chat_one_img ;
                    that.chat_two_title = res.chat_two_title ;
                    that.chat_two_image = res.chat_two_img ;
                }
                else
                {
                    // 不是游客123 发消息给redis确认位置
                    that.chat_one_title = res.chat_one_title ;
                    that.chat_one_image = res.chat_one_img+"" ;
                    that.chat_two_title = res.chat_two_title ;
                    that.chat_two_image = res.chat_two_img+"" ;
                }

            }
        }) ;
        /*
         获取聊天对象
         */

        //that.ws = new WebSocket( "ws://47.93.193.212:8888" ) ;
        that.ws = new WebSocket( "ws://127.0.0.1:8888" ) ;
        that.ws.onopen = function()
        {
            that.ws.send( sendData( that.chat_one, that.chat_two ,'ss' ,'hello' ) ) ;
        } ;
        that.ws.onmessage = function( result )
        {
            var msgObj = JSON.parse( result.data ) ;
            switch( msgObj.type )
            {
                case "ss" :
                    console.log('客户端接收的消息',msgObj) ;
                    break ;
                case "message" :
                    console.log('客户端接收的消息啊',msgObj) ;
                    // 拼接消息内容
                    $data = {
                        chat_con:msgObj.content['content'] ,
                        chat_title:msgObj.rever ,
                        chat_image:msgObj.content['image'] ,
                        chat_login:msgObj.content['login']
                    } ;
                    if( that.chat_obj.length==0 )
                    {
                        that.chat_obj = [{
                            chat_title:msgObj.rever ,
                            chat_image:msgObj.content['image']
                        }] ;
                    }

                    for( var i = 0 ;i < that.chat_obj.length;i++ )
                    {
                        if( that.chat_obj[i].chat_title != msgObj.rever )
                        {
                            that.chat_obj = [{
                                chat_title:msgObj.rever ,
                                chat_image:msgObj.content['image']
                            }] ;
                        }
                    }

                    that.chat_two = msgObj.rever ;
                    that.chat_data.push($data) ;
                    var div = document.getElementById('chat') ;
                    div.scrollTop = div.scrollHeight ;
                    setTimeout(function(){div.scrollTop = div.scrollHeight} , 50) ;
                    break ;
            }
        } ;

    }
}) ;

/**
 * 功能描述：小于10的时分秒前加零
 * 参数：
 * QQUser：
 * 返回：当前时间
 * 作者：yonjin L
 * 时间：18-3-28
 */
function p(s) {
    return s < 10 ? '0' + s: s;
}
/**
 * 功能描述：获取当前时间
 * 参数：
 * QQUser：
 * 返回：当前时间
 * 作者：yonjin L
 * 时间：18-3-28
 */
function nowDdate()
{
    var myDate = new Date();
    //获取当前年
    var year=myDate.getFullYear();
    //获取当前月
    var month=myDate.getMonth()+1;
    //获取当前日
    var date=myDate.getDate();
    var h=myDate.getHours();       //获取当前小时数(0-23)
    var m=myDate.getMinutes();     //获取当前分钟数(0-59)
    var s=myDate.getSeconds();
    var now=year+'-'+p(month)+"-"+p(date)+" "+p(h)+':'+p(m)+":"+p(s);
    return now ;
}
function sendData( sender ,rever ,type ,content )
{
    if( !sender )
    {
        console.log( "客户端错误的发送者" ,sender ) ;
    }
    if( !rever )
    {
        console.log( "客户端错误的发送者" ,rever ) ;
    }
    if( !type )
    {
        console.log( "客户端错误的发送者" ,type ) ;
    }
    if( !content )
    {
        console.log( "客户端错误的发送者" ,content ) ;
    }
    var msg = JSON.stringify( {
        sender:sender,
        rever:rever,
        type:type,
        content:content,
        msgtime:( new Date() ).getTime()
    });
    console.log( "客户端发送的消息" ,msg );
    return msg;
}


