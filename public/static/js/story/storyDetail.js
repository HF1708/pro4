// var vue=new Vue({
//     el:'#app',
//     data:{
//         user:[],
//         notes:[]
//     },
//     methods:{
//         getUser:function () {
//             this.user=[];
//             $.ajaxSetup({
//                 async: false
//             });
//             $.post(getUserUrl,{"id":id},function (res) {
//                 var userArr=JSON.parse(res);
//                 this.city=userArr;
//             }.bind(this))
//         },
//         getNotes:function () {
//             this.notes=[];
//             $.ajaxSetup({
//                 async: false
//             });
//             $.post(getNotesUrl,function (res) {
//                 this.notes=JSON.parse(res);
//
//                 console.log(this.notes);
//             }.bind(this))
//         }
//     },
//     mounted:function(){
//         this.getNotes();
//         console.log(88888888888888888888)
//         console.log(this.notes)
//     },
//     beforeUpdate: function () {
//
//     }
// });
$(function () {
    $.post(getNotesUrl,function (res) {
        $notes=JSON.parse(res);
        console.log($notes);

    });
})
