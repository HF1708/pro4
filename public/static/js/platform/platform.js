console.log("ok") ;

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
    el:"#myApp" ,
    data:{
        title:"tsadfdaslkfweka" ,
        imgUrlShow:'false' ,
        seeAdvert:false ,
        seeLoading:false ,
        fileUpload:'' ,
        advertDetails: {
            setId:"1" ,
            name: '广告',
            link: 'www.baidu.com' ,
            url : 'http://127.0.0.1/gitHub/pro4/public/static/images/face.jpg' ,
            advertiser:'广告商'
        } ,
        set_adv_id:"false"
    } ,
    methods:{
        /**
         * 功能描述：修改广告
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        setDataAdvert:function(e){
            var that = this ;
            console.log(that.advertDetails) ;
        } ,
        /**
         * 功能描述：修改广告内容
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        set_advert_data:function(e){
            return $(e.target).val() ;
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

            $.ajax({
                url:set_search_url ,
                type:"post" ,
                data:{search:$search} ,
                dataType:"json" ,
                success:function(res){
                    //window.location.reload() ;
                    console.log(res) ;
                }
            }) ;
        } ,
        /**
         * 功能描述：更换显示的广告
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        replaceAdvert:function($setId){
            var that = this ;
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
                    // 修改广告数据
                    that.advertDetails["name"] = res.data["name"] ;
                    that.advertDetails["link"] = res.data["link"] ;
                    that.advertDetails["url"] = res.data["url"] ;
                    that.advertDetails['advertiser'] = res.data["advertiser"] ;
                    that.advertDetails['setId'] = res.data["setId"] ;
                }
            }) ;
        } ,
        /**
         * 功能描述：打开广告详情
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-3-31
         */
        seeData:function(e){
            var that = this ;
            // 打开等待提示
            that.seeLoading = true ;
            // 打开广告详情
            if( that.set_adv_id == "false" )
            {
                that.seeAdvert = (that.seeAdvert)?false:true ;
                that.set_adv_id = $(e.target).attr('set_adv_id') ;
                that.replaceAdvert(that.set_adv_id) ;
            }
            else if( that.set_adv_id != "false" )
            {
                // 关闭广告详情
                if( that.set_adv_id == $(e.target).attr('set_adv_id') )
                {
                    that.seeAdvert = (that.seeAdvert)?false:true ;
                    that.set_adv_id = "false" ;
                }
                // 切换广告详情内容
                else if( that.set_adv_id != $(e.target).attr('set_adv_id') )
                {
                    that.set_adv_id = $(e.target).attr('set_adv_id') ;
                    that.replaceAdvert(that.set_adv_id) ;
                }
            }
            that.seeLoading = false ;
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
         * 功能描述：取消上传图片
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-1
         */
        cancelUpload:function(){
            $('#store_image').attr('src', this.advertDetails["url"]);
        }


    } ,
    mounted:function(){
        var that = this ;
        // 开始获取所有广告

        // 图片上传
        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload ;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: img_upload_url
                ,method:"post"
                ,bindAction:"#uploadImg"
                ,auto:false
                ,data:{
                    setId: that.advertDetails['setId']
                }
                // 文件上传前的回调
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#store_image').attr('src', result); //图片链接（base64）
                        that.fileUpload = file ;
                        console.log(that.fileUpload) ;
                    });
                }
                // 选择图片的回调
                ,choose:function(obj){
                    obj.preview(function(index, file, result){
                        $('#store_image').attr('src', result); //图片链接（base64）
                    }) ;

                }
                // 上传后的回调
                ,done: function(res){
                    console.log(res) ;
                    //如果上传失败
                    //上传成功
                    var item = this.item;
                    console.log(item);

                }
            });
        });
    }
}) ;

