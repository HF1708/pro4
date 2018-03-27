console.log(province);
var vue=new Vue({
    el:'#myapp',
    data:{
        selectShowNone:true,
        cityShow:false,
        townShow:false,
        province:province,
        city:city,
        town:[]
    },
    methods:{
        selectShowNoneFun:function () {
            this.selectShowNone=false;

        },
        getCity:function (e) {
            $.post($getCityUrl,{"id":e.target.value},function (res) {
                var cityArr=JSON.parse(res);
                this.city=cityArr;
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
        }
    }
});