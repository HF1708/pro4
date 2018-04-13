$(function(){
    $('#edit').editable({inlineMode: false, alwaysBlank: true})
});
$("#upload").change(function () {
    var fil = this.files;
    for (var i = 0; i < fil.length; i++) {
        reads(fil[i]);
    }
});
function reads(fil){
    var reader = new FileReader();
    reader.readAsDataURL(fil);
    reader.onload = function()
    {
        document.getElementById("photo").innerHTML += "<img src='"+reader.result+"'>";
    };
}
/**********写游记***********/
$("#publish").click(function() {
    var title = $("#title").val();
    var content = $('#edit')[0].childNodes[1].innerHTML;
    var time = nowDdate();
    console.log(time);
    $.ajax({
        url: publishUrl,
        data: {
            title: title,
            content: content,
            time:time
        },
        dataType: 'json',
        type: 'post',
        success: function (res) {
            if(res.code==10000){
                alert(res.msg);
            }else{
                alert(res.msg);
            }
        }
    })
});
/**
 *  *  功能描述：标签转换
 *  参数：str
 *  返回：转换的标签
 *  作者:min H
 *  时间：18-4-3
 **/
function escape2Html(str) {
    var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
    return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];});
}
/**
 *  *  功能描述：获取当前时间
 *  参数：无
 *  返回：当前时间
 *  作者:min H
 *  时间：18-4-3
 **/
function nowDdate()
{
    var myDate = new Date();
    //获取当前年
    var year=myDate.getFullYear();
    //获取当前月
    var month=myDate.getMonth()+1;
    //获取当前日
    var date=myDate.getDate();
    var h=myDate.getHours();       //获取当前小时数(0-23)
    var m=myDate.getMinutes();     //获取当前分钟数(0-59)
    var s=myDate.getSeconds();
    var now=year+'-'+p(month)+"-"+p(date)+" "+p(h)+':'+p(m)+":"+p(s);
    return now ;
}
/**
 *  *  功能描述：小于10的时分秒前加零
 *  参数：无
 *  返回：当前时间
 *  作者:min H
 *  时间：18-4-3
 **/
function p(s) {
    return s < 10 ? '0' + s: s;
}
