
function t_useChat( ada )
{
	//this.adapter = ada;
	//if( ada == undefined )
	//{
	//	this.adapter = require( './MySql.js' );
	//}
	this.adapter = require( './MySql.js' );

}

/*
*	功能描述：存储聊天记录
* 	参数：	user_uid_1 , 聊天对象1
* 			user_uid_2 , 聊天对象2
* 			content	     聊天内容
* 			callback     回调
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2018/3/28
*/
t_useChat.prototype.setChatStoreUserData = function( user_uid_1 ,user_uid_2,content ,callback)
{
	// 判断是否为游客
	// 游客不存
	if( content['setPut'] == '游客123' )
	{
		callback( true ) ;
		return ;
	}
	var type = '' ;
	var obj = '' ;
	this.setChatType(content['type'],function(types,object){
		type = types ;
		obj = object ;
	}) ;
	var sql = "insert into user_chat( user_uid ,user_chat_char_two_id ,user_chat_type ,user_chat_obj ,user_chat_content ,user_chat_time )VALUES"+
	"(? ,? ,? ,? ,? ,now()) ;" ;
	this.adapter( sql ,[ user_uid_1,parseInt(user_uid_2),type,obj,content['message'] ] ,function( err ){
		if( err )
		{
			callback( true ) ;
		}
		else
		{
			callback( false ) ;
		}
	}) ;
} ;

/*
 *	功能描述：判断聊天类型
 *	（店家/用户）A/（店家/客服）B/（客服/用户）C/（店家/店家）D/（用户/用户）E/（客服/客服）F 聊天记录
 * 	F(店家->用户) T (用户->店家) L (用户->用户)
 * 	参数：	聊天对象1，聊天对象2,callback回调函数
*  	返回：	无
*  	作者：	HF170809-凌永锦
 *   时间：	2018/3/29
 */
t_useChat.prototype.setChatType = function( type ,callback)
{
	switch( type )
	{
		//（店家/用户）
		case "user_store":
			callback("A","F") ;
			break ;
		//（用户/店家）
		case "store_user":
			callback("A","T") ;
			break ;
		//（店家/客服）
		case "store_server":
			callback("B","T") ;
			break ;
		//（客服/店家）
		case "server_store":
			callback("B","T") ;
			break ;
		//（客服/用户）
		case "server_user":
			callback("C","T") ;
			break ;
		//（用户/客服）
		case "user_server":
			callback("C","T") ;
			break ;
		//（店家/店家）
		case "store_store":
			callback("D","L") ;
			break ;
		//（用户/用户）
		case "user_user":
			callback("E","L") ;
			break ;
		//（客服/客服）
		case "server_server":
			callback("F","L") ;
			break ;
	}

} ;

module.exports = new t_useChat();





















