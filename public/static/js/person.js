
$(function () {
    var userIntro=$("#userIntro");
    var introBtn=$("#introBtn");
    var inputIntro=$("#inputIntro");
    var saveIntro =$("#saveIntro");
    if(userIntro.text()!=""){
        userIntro.show();
        introBtn.hide();
        inputIntro.hide();
    }
    else{
        userIntro.hide();
        introBtn.show();
        inputIntro.hide();
    }
    //填写用户简介弹出填写框
    introBtn.click(function () {
        introBtn.hide();
        inputIntro.show();
    });
    //修改简介
    saveIntro.click(function () {
        var newUserIntro=$("#myIntro").val();
        $.ajax({
            url:changeUrl,
            data:{"nweUserIntro":newUserIntro},
            type:"post",
            dataType:"json",
            success:function (res) {
                console.log(res)
            }
        });
    });
});