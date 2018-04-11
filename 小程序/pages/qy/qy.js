// pages/qy/qy.js
var qy = require("../../utils/qy");
Page({

  /**
   * 页面的初始数据
   */
  data: {
    qy:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this ;
    console.log(qy.init) ;
    var $data = [] ;
    for(var i = 0; i < qy.init.length-1;i++)
    {
      $data[i]=(qy.init[i]) ;
    }
    that.setData({
      qy: $data
    }) ;
  },
  /**
   * 
   */
  more:function(){
    console.log("加载更多") ;
    var that = this;
    var $data = that.data.qy;
    for (var i = $data.length; i < qy.init.length; i++) {
      $data[i] = (qy.init[i]);
    }
    that.setData({
      qy: $data
    });
  } ,
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