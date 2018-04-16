Page({

  /**
   * 页面的初始数据
   */
  data: {
    nickName:'',
    email:'',
    phone:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    //判断是否登录
    var that = this;
    wx.getStorage({
      key: 'user',
      success: function (res) {
        var data = JSON.parse(res.data)[0];
        console.log(data);
        that.setData({
          phone: data.user_phone,
          nickName: data.user_name,
          email:data.user_email
        });
      },
      //无登录者信息，跳转到登录页面
      fail: function (res) {
        wx.wx.redirectTo({
          url: '../register/register',
        })
      }
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
    
  },
  //提交表单
  formSubmit:function(e){
    wx.showModal({
      title: '提示',
      content: '确定要修改个人信息吗？',
      success: function (res) {
        if (res.confirm) {
          console.log(e.detail.value);
          var data = e.detail.value
          wx.request({
            url: 'http://www.qqy.fun/data/Changeuser/changeUser',
            data: data,
            method: "POST",
            header: {
              'content-type': 'application/json' // 默认值
            },
            success: function (res) {
              if(res.data==1){
                wx.showToast({
                  title: '修改成功',
                  icon: 'success',
                  duration: 2000
                })
              }
              else{
                wx.showToast({
                  title: '修改失败',
                  icon: 'success',
                  image:'/images/fail.png',
                  duration: 2000
                })
              }
              console.log(res)
            }
          })
        } else if (res.cancel) {
          //console.log('用户点击取消')
        }
      }
    })
  }
})