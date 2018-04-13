Page({

  /**
   * 页面的初始数据
   */
  data: {
    headSrc: 'http://p6gnb5g93.bkt.clouddn.com/184259d34cf7b25692ffa080f2c2a66505ebab08.jpg' ,
    uName:'游客'
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    /**
     * 判断用户是否已登录
     */
    (!wx.getStorageSync('user'))?( wx.navigateTo({ url: "/pages/register/register" }) ):"" ;
    // end 

    //获取登录者信息
    var that=this;
    wx.getStorage({
      key: 'user',
      success: function(res) {
        var data = JSON.parse(res.data)[0]; 
        console.log(data);
        that.setData({
          headSrc: data.user_image,
          uName:data.user_name
        });
        console.log(that.data);
      }
      //无登录者信息，跳转到登录页面
     // fail:function(res){
        //wx.redirectTo({
         // url: '../register/register'
        //})   
      //}
    })
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