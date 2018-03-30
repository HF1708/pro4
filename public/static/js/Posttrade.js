var vue=new Vue({
    el:'#app',
    data:{
        selectShowNone:true,
        cityShow:false,
        townShow:false,
        province:province,
        city:[],
        town:[]
    },

    methods:{
        selectShowNoneFun:function () {
            this.selectShowNone=false;
        },
        getCity:function (id) {
            this.city=[];
            $.ajaxSetup({
                async: false
            });
            $.post($getCityUrl,{"id":id},function (res) {
                var form = layui.form();
                var cityArr=JSON.parse(res);
                this.city=cityArr;
                setTimeout(function () {
                    form.render('select');
                    form.on('select(city)', function (data) {
                        id = data.value;
                        var pid=id;
                        $.post($getCityUrl,{"id":pid},function (res) {
                            var townArr=JSON.parse(res);
                            this.town=townArr;
                            setTimeout(function () {
                                form.render('select');
                            },10)
                        }.bind(this))
                    }.bind(this));
                }.bind(this),10)
                this.town=[];


                // if(cityArr.length!=1){
                //     this.cityShow=true;
                // }else {
                //     this.cityShow=false;
                // }





            }.bind(this))
        },
        getTown:function (id) {
            this.town=[];
            $.ajaxSetup({
                async: false
            });
            var form = layui.form();
            $.post($getCityUrl,{"id":id},function (res) {
                var townArr=JSON.parse(res);
                this.town=townArr;
                setTimeout(function () {
                    form.render('select');
                },10)
            }.bind(this))
        }
    },
    mounted: function () {
        layui.use('element', function(){
            var element = layui.element;

            //…
        });
        layui.use('form', function(){
            var form = layui.form();

            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
            form.on('select(province)', function(data){

                // console.log(data.elem); //得到select原始DOM对象
                // console.log(data.value); //得到被选中的值
                // console.log(data.othis); //得到美化后的DOM对象
                this.getCity(data.value);
            }.bind(this));
            form.on('select(city)', function(data){

                // console.log(data.elem); //得到select原始DOM对象
                // console.log(data.value); //得到被选中的值
                // console.log(data.othis); //得到美化后的DOM对象
                this.getTown(data.value);
            }.bind(this));

        }.bind(this));
        //上传图片

    },
    beforeUpdate: function () {

    }
});