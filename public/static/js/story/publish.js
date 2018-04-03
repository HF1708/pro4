$(function(){
    $('#edit').editable({inlineMode: false, alwaysBlank: true})
});

/**********图片上传***********/
$("#publish").click(function() {
    var title = $("#title").val();
    var content = $('#edit')[0].childNodes[1].innerHTML;;
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
            }
        }
    })
});
