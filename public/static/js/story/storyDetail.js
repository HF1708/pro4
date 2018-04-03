var vue=new Vue({
    el:'#app',
    data:{
        user:[],
        notes:[]
    },
    methods:{
        getUser:function () {
            this.user=[];
            $.ajaxSetup({
                async: false
            });
            $.post(getUserUrl,{"id":id},function (res) {
                var userArr=JSON.parse(res);
                this.city=userArr;
            }.bind(this))
        },
        getNotes:function () {
            this.notes=[];
            $.ajaxSetup({
                async: false
            });
            $.post($getNotesUrl,{"id":id},function (res) {
                var notesArr=JSON.parse(res);
                this.notes=notesArr;
            }.bind(this))
        }
    },
    beforeUpdate: function () {

    }
});