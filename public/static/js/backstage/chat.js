$('.carousel').carousel({
    interval: 5000 // in milliseconds
}) ;
$(".modal-backdrop").remove() ;
//	$("#loginMsgModel").modal('show') ;
var app = new Vue({
    el:"#myApp" ,
    data: {

        chat_one:'游客123' ,
        chat_one_title:'' ,
        chat_one_image:'' ,
        chat_two:'15659978516' ,
        chat_two_title:'' ,
        chat_two_image:'' ,
        chat_type: 'store_user' ,
        chat_obj:[] ,
        chat_obj_user:"" ,
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
                chat_image:that.chat_one_image
            } ;
            $data_2 = [that.chat_obj_user,{
                chat_con:msg ,
                chat_title:that.chat_one ,
                chat_image:that.chat_one_image ,
                chat_login:that.login
            }] ;

            console.log(213) ;
            that.chat_data.push($data_2) ;
            console.log(that.chat_data) ;
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
            url:char_obj_url ,
            type:'post' ,
            dataType:'json' ,
            data:{chatTwo:'test',chatType:'user'} ,
            success:function(res){
                that.login = res.login ;
                that.chat_type = res.chat_type ;

                that.chat_one=res.user ;
                // 为游客123
                if( res.user == '游客123' )
                {
                    that.chat_one=res.user ;
                    that.chat_one_title = res.chat_one_title ;
                    that.chat_one_image = res.chat_one_image ;
                    that.chat_two_title = res.chat_two_title ;
                    that.chat_two_image = res.chat_two_image ;
                }
                else
                {
                    // 不是游客123 发消息给redis确认位置
                    that.chat_one_title = res.chat_one_title ;
                    that.chat_one_image = res.chat_one_img ;
                    that.chat_two_title = res.chat_two_title ;
                    that.chat_two_image = res.chat_two_img ;
                }


                that.ws.send( sendData( that.chat_one ,'server' ,'ss' ,'hello' ) ) ;
            }
        }) ;

        that.ws = new WebSocket( "ws://localhost:8888" ) ;
        that.ws.onopen = function()
        {
				that.ws.send( sendData( that.chat_one ,'server' ,'ss' ,'hello' ) ) ;
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
                    //console.log('客户端接收的消息啊',msgObj) ;


                    // 一开始添加的聊天对象
                    if( that.chat_obj.length==0 )
                    {

                        that.chat_obj = [{
                            chat_title:msgObj.rever ,
                            chat_image:msgObj.content['image']
                        }] ;
                    }
                    else
                    {
                        // 设置判断值(是否添加聊天对象)
                        var flag = true ;
                        // 遍历聊天对象
                        for(var i = 0;i < that.chat_obj.length ;i++)
                        {

                            // 发现未添加的对象添加
                            // 并退出遍历
                            if(that.chat_obj[i].chat_title == msgObj.rever)
                            {
                                flag = false ;
                                break ;
                            }

                        }
                        // 聊天对象不同则不添加对象
                        // 否则添加对象
                        if( flag )
                        {

                            $data = {
                                chat_title:msgObj.rever ,
                                chat_image:msgObj.content['image']
                            } ;
                            that.chat_obj.push($data) ;
                        }

                    }
                    // 聊天对象(前台设置聊天内容的数组下标)
                    that.chat_obj_user = msgObj.rever ;


                    $data = [that.chat_obj_user,{
                        chat_con:msgObj.content['content'] ,
                        chat_title:msgObj.rever ,
                        chat_image:msgObj.content['image'] ,
                        chat_login:msgObj.content['login']
                    }] ;
                    that.chat_data.push($data) ;

                    that.chat_two = msgObj.rever ;

                    console.log(that.chat_data[0][0]) ;
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
    //console.log( "客户端发送的消息" ,msg );
    return msg;
}