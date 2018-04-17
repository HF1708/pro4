var qy = require("../../utils/qy");
var WxParse = require('../../wxParse/wxParse.js');
const app = getApp();
Page({
    /**
   * 页面的初始数据
   */
    data: {
      qy: []
    },
    /**
   * 生命周期函数--监听页面加载
   */
    onLoad() {
        var that = this;
        // // 获取当前设备信息
        // app.getDeviceInfo(function(deviceInfo) {
        //     that.setData({
        //         deviceInfo: deviceInfo,
        //     });

        //     console.log(deviceInfo);
        // })
        //发送请求获取游记数据
        wx.request({
          url: 'http://47.93.193.212/data/Notes/getNotes',
          data: [],
          method: 'GET',
          dataType: 'json',
          header: { 'content-type': 'application/x-www-form-urlencoded' },
          success: function (res) {
            var re = [];
            for (var i = 0; i < res.data.length; i++) {
              re[i] = WxParse.wxParse('article', 'md', res.data[i].content, that, 5);
              re[i].name = res.data[i].title;
            }
            var put_data = [];
            for (var i = 0; i < that.data.qy.length; i++) {
              if (that.data.qy[i].name == "游记") {
                that.data.qy[i].sub = re;
                put_data = that.data.qy;
              }
            };
            console.log(re);
            that.setData({
              notes:res.data  //设置数据
            })
          },
          fail: function (err) {
            console.log(err)
          },
          complete: function () {

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

    }
})
