
$(function () {
    $.post(getNotesUrl,function (res) {
        $notes=JSON.parse(res);
        console.log($notes[0]);
        $con=$notes[0]['content'];
        $content=escape2Html($con);
        console.log($content);
        $("#notes_con").html($content);
        
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
    });
})
