// pages/qy/qy.js

var qy = require("../../utils/qy") ;
var WxParse = require('../../wxParse/wxParse.js') ;
const app = getApp() ;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    qy:[] 
  } ,

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var that = this ;
    var $data = [] ;
    $data=qy.init ;
    that.setData({
      qy: $data
    }) ;
    wx.request({
      url: 'https://www.qqy.fun/data/Data/getHotel',
      success:function(res)
      {
        that.putData(res.data,"酒店") ;
      }
    }) ;
    // 获取游记
    // wx.request({
    //   url: 'https://www.qqy.fun/data/Data/getTrvaels',
    //   success: function (res) {
    //     var re = [];
    //     for (var i = 0; i < res.data.length; i++) {
    //       re[i] = WxParse.wxParse('article', 'md', res.data[i].src, that, 5);
    //       re[i].name = res.data[i].msg ;
    //     }
    //     var put_data = [] ;
    //     for (var i = 0; i < that.data.qy.length; i++) {
    //       if (that.data.qy[i].name == "游记") {
    //         that.data.qy[i].sub = re ;
    //         put_data = that.data.qy ;
    //       }
    //     } ;
    //     that.setData({
    //       qy: put_data
    //     });
    //   }
    // })
  },

  /**
   * 功能描述：加载更多
     * 参数：
     * QQUser：
     * 返回：推荐数据
     * 作者：yonjin L
     * 时间：18-4-11
   */
  more:function(){
    var that = this;
    // 获取游记
    wx.request({
      url: 'https://www.qqy.fun/data/Data/getTrvaels',
      success: function (res) {
        var re = [];
        for (var i = 0; i < res.data.length; i++) {
          re[i] = WxParse.wxParse('article', 'md', res.data[i].src, that, 5);
          re[i].name = res.data[i].msg;
        }
        var put_data = [];
        for (var i = 0; i < that.data.qy.length; i++) {
          if (that.data.qy[i].name == "游记") {
            that.data.qy[i].sub = re;
            put_data = that.data.qy;
          }
        };
        that.setData({
          qy: put_data
        });
      }
    })
  } ,
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    var that = this ;
    // 获取酒店信息
    // wx.request({
    //   url: 'https://www.qqy.fun/data/Data/getHotel',
    //   success:function(res)
    //   {
    //     that.putData(res.data,"酒店") ;
    //   }
    // }) ;
    // // 获取游记
    // wx.request({
    //   url: 'https://www.qqy.fun/data/Data/getTrvaels',
    //   success: function (res) {
    //     var re = [] ;
    //     for( var i = 0;i < res.data.length;i++ )
    //     {
    //       re[i] = WxParse.wxParse('article', 'md', res.data[i].src, that, 5);
    //     }
    //     for (var i = 0; i < that.data.qy.length; i++) {
    //       if (that.data.qy[i].name == "游记") {
    //         that.data.qy[i].sub = re ;
    //         putdata = that.data.qy ;
    //       }
    //     }
        

    //   }
    // })
  },
  /**
   * 替换数据
   */
  putData:function(data,flag)
  {
    var that = this ;
    var putdata = [] ;
    for (var i = 0; i < that.data.qy.length;i++ )
    {
      if (that.data.qy[i].name == flag )
      { 
        that.data.qy[i].sub = data ;
        putdata = that.data.qy ;
      }
    }
    that.setData({
      qy: putdata
    }) ;
    
  } ,

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