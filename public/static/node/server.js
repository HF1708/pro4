
var wsModule = require( "ws" );

var Server = wsModule.Server;
var server = new Server( {port:8888} );

var socketList = [];
var useList = [];
// 连接数据库
var adapter = require( './my_modules/MySqlite3Adapter' );



server.on( "connection" ,function( socket ){
	socketList.push( socket );
	socket.on( "message" ,function( data ){
		var msgObj = JSON.parse( data );
		useList[ msgObj.sender ] = socket ;
		switch( msgObj.type )
		{
			case 'ss':
				console.log( "服务器发送的消息");
				socket.send( sendData(
					msgObj.rever ,
					msgObj.sender ,
					'ss' ,
					{msg:'没有内容'}
				)) ;
			break;
		}
	});
	socket.on( "error" ,function( err ){

	});
	socket.on( "close" ,function(){

	});
});

console.log( "服务器成功连接" );

/*
*	功能描述：发消息的内容格式(通用)
* 	参数：	sender     发送者
* 			rever      接受者
* 			type       消息类型
* 			content    消息内容
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/05
*/
function sendData( sender ,rever ,type ,content )
{
	if( !sender )
	{
		console.log( "服务器错误的发送者" ,sender );
	}
	if( !rever )
	{
		console.log( "服务器错误的接受者" ,rever );
	}
	if( !type && type != false)
	{
		console.log( "服务器错误的消息类型" ,type );
	}
	if( !content )
	{
		console.log( "服务器错误的消息内容" ,content );
	}
	var msg = JSON.stringify( {
		sender:sender,
		rever:rever,
		type:type,
		content:content,
		msgtime:( new Date() ).getTime()
	});
	console.log( "服务器发送的消息" ,msg );
	return msg;
}




