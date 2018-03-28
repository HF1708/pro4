
function MySqlite3Adapter( mydbname )
{
	var dbname = mydbname;
	if( mydbname == undefined )
	{
		dbname = "./旅游电商数据库1.0.sql";
	}
	var sqlite3 = require( 'sqlite3' ) ;
	this.db = new sqlite3.Database( dbname ,function( err ){
		if( !err )
		{
			console.log( '数据库连接成功' );
		}
		else
		{
			console.log( '数据库连接失败' ,err );
		}
	});
}

/*
*	功能描述：重置修改数据库函数
* 	参数：	无
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/07
*/
MySqlite3Adapter.prototype.run = function( sql ,params ,callback ){
	this.db.run( sql ,params ,function( err ){
		if( !err )
		{
			callback( true ,this );
		}
		else
		{
			console.log( '执行sql语句失败' ,err );
			callback( false ,err );
		}
	});
}

/*
*	功能描述：重置查找数据库函数
* 	参数：	无
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/07
*/
MySqlite3Adapter.prototype.select = function( sql ,params ,callback )
{
	this.db.all( sql ,params ,function( err ,rows ){
		if( !err )
		{
			callback( true ,rows );
		}
		else
		{
			console.log( '执行sql语句失败' ,err );
			callback( false ,err );
		}
	});
}

module.exports = new MySqlite3Adapter();












