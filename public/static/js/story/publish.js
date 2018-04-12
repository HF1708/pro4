$(function(){
    $('#edit').editable({inlineMode: false, alwaysBlank: true})
});

/**********写游记***********/
$("#publish").click(function() {
    var title = $("#title").val();
    var content = $('#edit')[0].childNodes[1].innerHTML;
    // content=escape2Html(content);
    console.log(content);
    $.ajax({
        url: publishUrl,
        data: {
            title: title,
            content: content
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
