var store=new Vue({
    el: "#myapp" ,
    data:{
        showCreatBtn:true,
        showCreatBox:false,
        backBtn:false,
        showIndex:true
    } ,
    mounted:function(){


    } ,
    methods:{
        /**
         * 功能描述：显示增加员工模块
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-1
         */
        showBox:function () {
            this.showCreatBox=true;
            this.showCreatBtn=false;
            this.backBtn=true;
            this.showIndex=false;
        },
        /**
         * 功能描述：点击返回按钮
         * 参数：
         * QQUser：
         * 返回：
         * 作者：yonjin L
         * 时间：18-4-1
         */
        hideBox:function () {
            this.showCreatBox=false;
            this.showCreatBtn=true;
            this.backBtn=false;
            this.showIndex=true;
        }
    }
}) ;
