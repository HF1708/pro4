// pages/register/register.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    "mobile":"",
    "code":"",
    "popErrorMsg":"",
    "getCodeBnt":"获取验证码"
  },
  getCode:function(){
    if (this.data.getCodeBnt =="获取验证码"){
      var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;
      if (!myreg.test(this.data.mobile)) {
        this.setData(
          { popErrorMsg: "请正确输入手机号" }
        );
        this.ohShitfadeOut();
      } else {
        var _this = this;
        wx.request({
          url: 'http://47.93.193.212/data/User/getCode',
          method: "POST",
          data: this.data,
          header: { 'content-type': 'application/x-www-form-urlencoded' },
          success: function (res) {
            console.log(res.data.code)
            console.log(res.data.mobileCode)
            if (res.data.code == 1000) {
              wx.showToast({
                title: "提交成功",
                icon: 'success',
                duration: 2000
              })
              wx.setStorage({
                key: 'code',
                data: res.data.mobileCode,
                success: function (res) {
                  console.log(res)
                }
              });
              wx.setStorage({
                key: 'mobile',
                data: res.data.mobile,
                success: function (res) {
                  console.log(res)
                }
              });

              var getCodeBnt = 60;
              var time = setInterval(function () {
                getCodeBnt -= 1;
                if (getCodeBnt <= 0) {
                  _this.setData({
                    getCodeBnt: "获取验证码"
                  })
                  clearInterval(time);
                  
                } else {
                  _this.setData({
                    getCodeBnt: getCodeBnt + "秒后获取"
                  })
                }

              }, 1000)
            }
            else {
              _this.setData(
                { popErrorMsg: "提交失败" }
              );
              _this.ohShitfadeOut();
            }
          }
        })
      }  
    }
    console.log(this.data.mobile);
  },
  // 获取手机号
  getMobile: function (res) {
    var mobile = res.detail.value;
    this.setData({
      mobile: mobile
    })
  },
  // 获取验证码
  getCodeA: function (res) {
    var code = res.detail.value;
    this.setData({
      code: code
    })
  },
  ohShitfadeOut() {
    var fadeOutTimeout = setTimeout(() => {
      this.setData({ popErrorMsg: '' });
      clearTimeout(fadeOutTimeout);
    }, 3000);
  }, 
  userinfotap: function() {
    wx.showToast({
      title: '登录中...',
      icon: 'loading',
      duration: 10000
    })
    var mobileCode =wx.getStorageSync('code')
    var mobile = wx.getStorageSync('mobile')
      if(this.data.code == mobileCode&&this.data.mobile == mobile){
        var _this=this;
        wx.request({
          url: 'http://47.93.193.212/data/User/login',
          method: "POST",
          data: { "mobile": mobile},
          header: { 'content-type': 'application/x-www-form-urlencoded' },
          success: function (res) {
            if(res.data!=""){
              var data = JSON.stringify(res.data);
              wx.setStorage({
                key: 'user',
                data: data,
                success: function (res) {
                  wx.redirectTo({
                    url: '../qy/qy'
                  })
                }
              })

            }else{
        
              _this.setData(
                { popErrorMsg: "登录失败！" }
              );
              _this.ohShitfadeOut();
            }
            wx.hideToast();
            wx.showToast({
              title: '登录成功',
              icon: 'success',
              duration: 10000
            })
          }
        })
      }else{
        this.setData(
          { popErrorMsg: "验证码错误" }
        );
        this.ohShitfadeOut();
      }
   
     
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
