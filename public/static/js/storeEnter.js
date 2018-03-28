/**
 *  *  功能描述：获取COOKIE
 *  参数：cname
 *  返回：content
 *  作者:qingtian Y
 *  时间：18-3-27
 **/
function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}









var iTime = 59;
var Account;
function RemainTime(){
    document.getElementById('zphone').disabled = true;
    var iSecond,sSecond="",sTime="";
    if (iTime >= 0){
        iSecond = parseInt(iTime%60);
        iMinute = parseInt(iTime/60);
        if (iSecond >= 0){
            if(iMinute>0){
                sSecond = iMinute + "分" + iSecond + "秒";
            }else{
                sSecond = iSecond + "秒";
            }
        }
        sTime=sSecond;
        if(iTime==0){
            clearTimeout(Account);
            sTime='获取手机验证码';
            iTime = 59;
            document.getElementById('zphone').disabled = false;
        }else{
            Account = setTimeout("RemainTime()",1000);
            iTime=iTime-1;
        }
    }else{
        sTime='没有倒计时';
    }
    document.getElementById('zphone').value = sTime;
}





var vue=new Vue({
    el:'#myapp',
    data:{
        selectShowNone:true,
        cityShow:false,
        townShow:false,
        province:province,
        city:city,
        mobile:"",
        send_code:send_code,
        town:[],
        required:false,
        tip_content:""
    },

    methods:{
        selectShowNoneFun:function () {
            this.selectShowNone=false;
        },
        getCity:function (e) {
            $.post($getCityUrl,{"id":e.target.value},function (res) {
                var cityArr=JSON.parse(res);
                this.city=cityArr;
                this.required=true;
                if(cityArr.length!=1){
                    this.cityShow=true;
                }else {
                    this.cityShow=false;
                }
                var pid=cityArr[0].id;
                $.post($getCityUrl,{"id":pid},function (res) {
                    var townArr=JSON.parse(res);
                    this.town=townArr;
                    this.townShow=true;
                }.bind(this))
            }.bind(this))
        },
        getTown:function (e) {
            $.post($getCityUrl,{"id":e.target.value},function (res) {
                var townArr=JSON.parse(res);
                this.town=townArr;
                this.townShow=true;
            }.bind(this))
        },
        //获取短信验证码
        getCode:function () {
            $.post($getCodeUrl,{"mobile":this.mobile,"send_code":this.send_code},function (msg) {
                if(msg=='提交成功'){
                    RemainTime();
                }else {
                    this.tip_content=msg;
                    $('#myModal').modal('show') ;
                }
            }.bind(this))
        },
        /**
         *  *  功能描述：打开页面时先判断COOKIE中有没错误提示，做出对应显示
         *  参数：无
         *  返回：无
         *  作者:qingtian Y
         *  时间：18-3-27
         **/
        showCodeTips:function () {
            var travel_code_error=getCookie("travel_code_error");
            if(travel_code_error!=""){
                //模态框弹出警告
                this.tip_content=decodeURI(travel_code_error);
                $('#myModal').modal('show') ;
                // document.cookie = "travel_code_error=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        }

    },
    mounted: function () {
        this.showCodeTips();
    },
    beforeUpdate: function () {

    }
});
