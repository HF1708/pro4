

function Redis()
{
    //引入redis
    var redis = require("redis");
    //创建redis客户端
    this.client = redis.createClient("6379", "127.0.0.1") ;

    this.setData('redis','link','redis连接成功') ;
    this.getData('redis','link',function(rows){
        console.log(rows) ;
    }) ;

    // 引入mysql模块
    this.adapter = require("./MySql.js") ;

}



/**
 * 功能描述：发送聊天内容
 * 参数：( 'h'/存到哪一行, 'key1'/存在哪一列, 'data'/存储的数据 )
 * QQUser：
 * 返回：
 * 作者：yonjin L
 * 时间：18-3-28
 */
Redis.prototype.setData = function( h ,key ,data )
{
    // 存数据用zadd
    // 先获取下标score 使其加1
        // 1.获取score
    this.client.hget('score','chat',function(err){
        if( !err )
        {
            console.log('存储成功') ;
        }
        else
        {
            console.log('存储失败',err) ;
        }
    }) ;
    // 再更加score以zadd存入redis
    this.client.hset( h, key,data, function(err) {
        if( !err )
        {
            console.log('存储成功') ;
        }
        else
        {
            console.log('存储失败',err) ;
        }
    }) ;
} ;

/**
 * 功能描述：读取聊天内容
 * 参数：( 'h'/存到哪一行, 'key1'/存在哪一列 ) callback回调
 * QQUser：
 * 返回：
 * 作者：yonjin L
 * 时间：18-3-28
 */
Redis.prototype.getData = function( h ,key ,callback )
{
    // 读取数据
    this.client.hget(h, key, function(err, rows) {
        if( !err )
        {
            console.log('读取成功') ;
            callback(rows) ;
        }
        else
        {
            console.log('读取失败',err) ;
        }
    }) ;
} ;




module.exports = new Redis() ;


