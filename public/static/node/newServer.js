var wsModule = require( "ws" );
var Server = wsModule.Server;
var server = new Server( {port:8888} );
var socketList = [] ;
var List = [] ;

// 引入redis模块
var redis = require("./my_modules/redisDao.js") ;
//引入聊天表操作刀
var chat = require("./my_modules/t_user_chat.js") ;

server.on( "connection" ,function( socket ){
    socketList.push( socket );
    socket.on( "message" ,function( data ){
        var msgObj = JSON.parse( data );
        console.log(msgObj)
        List[msgObj.mine.id] = socket ;
        if(msgObj.to!=undefined){

            sendMsg(List,msgObj)
        }

    });
    socket.on( "error" ,function( err ){

    });
    socket.on( "close" ,function(){

    });
});

console.log( "服务器成功连接" );
/*
*	功能描述：服务器转发消息给接收者
* 	参数：	List 接收对象的队列
*           MSG 消息
*  	返回：	无
*  	作者：	qingtian Y
*   时间：	2018/4/07
*/
function sendMsg(List,MSG) {

    for(key in List)
    {

        var otherSocket = List[key];
        if(otherSocket!=undefined && otherSocket.readyState == wsModule.OPEN  && otherSocket == List[MSG.to.id] )
        {

            otherSocket.send(JSON.stringify(MSG));
        }
    }
}