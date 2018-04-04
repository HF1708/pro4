
$(function(){
    // 审核状态下拉框
    $("#putStateExamine").mouseover(function(){
        $(".layui-nav-child").css({
            display:"block" ,
            top:"37px"
        }) ;
    }).mouseout(function(){
        $(".layui-nav-child").css({
            display:"none" ,
            top:"0"
        }) ;
    }) ;
}) ;

// 新建一个vue
var vue = new Vue({
    el:"#advert" ,
    data:{
        all_advert:"全部广告" ,
        advert_name:"广告名" ,
        advert_store:"广告发布商" ,
        advert_link:"www.baidu.com" ,
        advert_pic_url:"https://i0.hdslb.com/bfs/face/184259d34cf7b25692ffa080f2c2a66505ebab08.jpg" ,
        advert_show:false ,
        seeLoading:false 
    } ,
    methods:{
        /**
         * 功能描述：打开广告详情并获取内容
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-28
         */
        seeAdvert:function(e)
        {
            var that = this ;
            // 打开广告详情
            that.seeLoading = true ;
            $setId = ($(e.target).attr("set_adv_id")) ;
            $data = {
                setId: $setId
            } ;
            $.ajax({
                url:replace_advert_url ,
                type:"post" ,
                data:$data ,
                dataType:"json" ,
                success:function(res)
                {
                    // 关闭等待提示
                    that.seeLoading = false ;
                    // 广告获取成功时
                    if( res.code == 10000 )
                    {
                        // 打开广告详情
                        that.advert_show = true ;
                        // 修改广告数据
                        that.advert_name = res.data["name"] ;
                        that.advert_link = res.data["link"] ;
                        that.advert_url = res.data["url"] ;
                        that.advert_store = res.data["advertiser"] ;
                    }
                    // 广告获取失败时
                    else
                    {
                        // 弹出提示
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            layer.msg('广告获取失败');
                        });
                    }

                }
            }) ;

        } ,
        /**
         * 功能描述：广告上架下架、审核
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        examineAdv:function(e){
            $setId = $(e.target).attr('set_adv_id') ;
            $setData = $(e.target).attr('setClass') ;
            $data = {
                setId: $setId ,
                setData: $setData
            } ;
            $.ajax({
                url:advertSetDataUrl ,
                type:'post' ,
                dataType:'json' ,
                data:$data ,
                success:function(res){
                    // layui 弹出框
                    layui.use('layer', function(){
                        var layer = layui.layer ;
                        layer.open({
                            title: '广告管理' ,
                            content: res.msg
                        }) ;
                    }) ;
                    // 操作成功时修改页面数据
                    if( res.code == 10000 )
                    {
                        $(e.target).parent().parent().parent().children("th").eq(4).text(res.data["success"]) ;
                    }
                    else
                    {
                        console.log("操作失败") ;
                    }
                }
            }) ;

        } ,
        /**
         * 功能描述：修改搜索条件
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        setSeartch:function(e)
        {
            var that = this ;
            var $search = $(e.target).attr('setState') ;
            // $search有内容才搜索
            if( $search )
            {
                $.ajax({
                    url:set_search_url ,
                    type:"post" ,
                    data:{search:$search} ,
                    dataType:"json" ,
                    success:function(res){
                        window.location.reload() ;
                    }
                }) ;
            }

        } ,
        /**
         * 功能描述：修改显示条件
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-4
         */
        setSeeSearct:function()
        {
            var that = this ;
            $.ajax({
                url:set_see_searct ,
                type:"post" ,
                data:"" ,
                dataType:"json" ,
                success:function(res)
                {
                    var $setSearch = res.data ;
                    switch( $setSearch )
                    {
                        case "A":
                            that.all_advert = "全部广告" ;
                            break ;
                        case "T":
                            that.all_advert = "上架广告" ;
                            break ;
                        case "F":
                            that.all_advert = "未审核广告" ;
                            break ;
                        case "S":
                            that.all_advert = "下架广告" ;
                            break ;
                        default :
                            that.all_advert = "全部广告" ;
                            break ;
                    }
                }
            }) ;
        }

    } ,
    mounted:function(){
        console.log("go to mounted") ;
        this.setSeeSearct() ;

    }
}) ;

