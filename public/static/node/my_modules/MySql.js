
function MySql()
{

	var mysql      = require('mysql') ;
	this.connection = mysql.createConnection({
		host     : 'qdm181738524.my3w.com' ,
		user     : 'qdm181738524' ,
		password : 'yqt123123' ,
		database : 'qdm181738524_db'
	});

	this.connection.connect() ;

}

/*
*	功能描述：重置修改数据库函数
* 	参数：	无
*  	返回：	无
*  	作者：	HF170809-凌永锦
*   时间：	2017/12/07
*/
MySql.prototype.run = function( sql ,params ,callback ){
	this.connection.run( sql ,params ,function( err ){
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
MySql.prototype.select = function( sql ,params ,callback )
{
	this.connection.all( sql ,params ,function( err ,rows ){
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

module.exports = new MySql();












