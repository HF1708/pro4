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
        imgUrlShow:'false'
    } ,
    methods:{
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
                    console.log(res) ;
                }
            }) ;
        }
    } ,
    mounted:function(){
        console.log("go to mounted") ;
        // 开始获取所有广告
    }
}) ;

