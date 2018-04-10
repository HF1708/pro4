// pages/register/register.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "mobile":"",
    "popErrorMsg":""
  },
  getCode:function(){
    console.log(this.data.mobile);
    var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;  
    if (!myreg.test(this.data.mobile)) {
      this.setData(
        { popErrorMsg: "请正确输入手机号" }
      );
      this.ohShitfadeOut(); 
    } else {
      console.log("ssss")
    }  
   
  },
  // 获取手机号
  getMobile: function (res) {
    var mobile = res.detail.value;
    this.setData({
      mobile: mobile
    })
  },
  ohShitfadeOut() {
    var fadeOutTimeout = setTimeout(() => {
      this.setData({ popErrorMsg: '' });
      clearTimeout(fadeOutTimeout);
    }, 3000);
  }, 
  userinfotap: function() {
    // wx.redirectTo({
    //   url: '../userinfo/userinfo'
    // })
 
      wx.request({
         
          url: 'https://www.qqy.fun/wx/Applet/index.php?c=Wjx&a=reg',
          method:"POST",
          data:this.data,
          header: { 'content-type': 'application/x-www-form-urlencoded'},
          success:function(res){

          }
      })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})
