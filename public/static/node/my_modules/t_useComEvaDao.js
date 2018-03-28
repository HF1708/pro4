
function t_useComEvaDao( ada )
{
	this.adapter = ada;
	if( ada == undefined )
	{
		this.adapter = require( './MySqlite3Adapter.js' );
	}
}

/*
*	功能描述：获取秒杀成交记录
* 	参数：	comid	 用户id
* 			callback 回调
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/13
*/
t_useComEvaDao.prototype.getComRecord = function( comid ,callback)
{
	if( !comid )
	{
		console.log( '商品id出错' );
		callback( false );
		return ;
	}
	var sql = "select a.* ,b.* from t_useComOrder a left join t_useList b on a.useid = b.useid where a.cid = ? and a.comtype = '1'";
	this.adapter.select( sql ,[ comid ] ,function( err ,rows ){
		if( err )
		{
			if( rows.length > 0 )
			{
				callback( true ,rows );
			}
			else
			{
				callback( false );
			}
		}
		else
		{
			callback( false );
		}
	});
}


/*
*	功能描述：获取商品评论
* 	参数：	callback 回调
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/13
*/
t_useComEvaDao.prototype.getComEva = function( callback )
{
	var sql = ' select  a.* ,b.* from t_useComEva a left join t_useList b on b.useid = a.useid ';
	this.adapter.select( sql ,[] ,function( err ,rows ){
		if( err )
		{
			if( rows.length > 0 )
			{
				callback( true ,rows );
			}
			else
			{
				callback( false );
			}
		}
		else
		{
			callback( false );
		}
	});
}

/*
*	功能描述：添加商品评论
* 	参数：	comid	 商品id
* 			useid 	 用户id
* 			callback 回调
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/13
*/
t_useComEvaDao.prototype.addComEva = function( comid ,useid ,content ,callback )
{
	if( !comid )
	{
		console.log( '商品id出错' );
		callback( false );
		return ;
	}
	if( !useid )
	{
		console.log( '用户id出错' );
		callback( false );
		return ;
	}
	if( !content )
	{
		console.log( '用户评论出错' );
		callback( false );
		return ;
	}
	this.getTime( function( flag ,time ){
		if( flag )
		{
			var sql = "insert into t_useComEva( useid ,cid ,content ,contenttime )"+
			  		  "values( ? ,? ,? ,'"+time+"' )";
			this.adapter.run( sql ,[ useid ,comid ,content ] ,function( err ){
				if( err )
				{
					callback( true );
				}
				else
				{
					callback( false );
				}
			});
		}
		else
		{
			callback( false );
		}
	}.bind( this ));
}


/*
*	功能描述：获取数据库当前时间
* 	参数：	callback 回调
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/13
*/
t_useComEvaDao.prototype.getTime = function( callback )
{
	var sql = "select strftime('%Y年%m月%d日 %H:%M:%S', 'now', 'localtime') time";
	this.adapter.select( sql ,[] ,function( err ,rows ){
		if( err )
		{
			if( rows.length > 0)
			{
				var time = '';
				for( var key in rows )
				{
					time = rows[ key ].time;
				}
				callback( true ,time );
			}
			else
			{
				callback( false );
			}
		}
		else
		{
			callback( false );
		}
	});
}

module.exports = new t_useComEvaDao();





















