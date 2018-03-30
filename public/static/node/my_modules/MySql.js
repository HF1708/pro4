

var mysql=require("mysql");
var pool = mysql.createPool({
	host     : 'qdm181738524.my3w.com' ,
	user     : 'qdm181738524' ,
	password : 'yqt123123' ,
	database : 'qdm181738524_db'
});
/**
 * 执行查询完之后再释放连接
 */
var query=function(sql,options,callback ){

	pool.getConnection(function(err,conn){
		if(err){
			callback(err,null,null);
		}else{
			conn.query(sql,options,function(err,results,fields){
				//事件驱动回调
				callback(err,results,fields) ;
			}) ;
			//释放连接，需要注意的是连接释放需要在此处释放，而不是在查询回调里面释放
			conn.release() ;
		}
	}) ;
} ;



module.exports=query ;






















//
//function MySql()
//{
//
//	var mysql      = require('mysql') ;
//	this.connection = mysql.createConnection({
//		host     : 'qdm181738524.my3w.com' ,
//		user     : 'qdm181738524' ,
//		password : 'yqt123123' ,
//		database : 'qdm181738524_db'
//	}) ;
//
//	this.connection.connect() ;
//
//}
//
///*
//*	功能描述：重置修改数据库函数
//* 	参数：	无
//*  	返回：	无
//*  	作者：	HF170809-凌永锦
//*   时间：	2017/12/07
//*/
//MySql.prototype.run = function( sql ,params ,callback ){
//	this.connection.query(sql, params, function(error, result){
//		if(error)
//		{
//			console.log(error.message);
//		}else{
//			console.log('insert id: '+result.insertId) ;
//			callback( true ) ;
//		}
//	});
//} ;
//
///*
//*	功能描述：重置查找数据库函数
//* 	参数：	无
//*  	返回：	无
//*  	作者：	HF170809-凌永锦
//*   时间：	2017/12/07
//*/
//MySql.prototype.select = function( sql ,params ,callback )
//{
//	this.connection.all( sql ,params ,function( err ,rows ){
//		if( !err )
//		{
//			callback( true ,rows );
//		}
//		else
//		{
//			console.log( '执行sql语句失败' ,err );
//			callback( false ,err );
//		}
//	});
//} ;
//
//module.exports = new MySql();












