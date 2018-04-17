// entry.js
var app = getApp()
var diaries = require("diaries.js");
var toolbar = [
  '../../images/download.png', '../../images/fav.png',
  '../../images/share.png', '../../images/comment.png',
];
var logo = '../../images/reg.png'

Page({
  data: {
    // 当前日志详情
    diary: undefined,

    // 右上角工具栏
    toolbar: toolbar,

    // 图片预览模式
    previewMode: false,

    // 当前预览索引
    previewIndex: 0,

    // 多媒体内容列表
    mediaList: [],
    //logo图
    logo: logo
  },

  /**
   * 生命周期函数--监听页面显示
   */
  escape2Html: function (str) {
    var arrEntities = { 'lt': '<', 'gt': '>', 'nbsp': ' ', 'amp': '&', 'quot': '"' };
    return str.replace(/&(lt|gt|nbsp|amp|quot);/ig, function (all, t) { return arrEntities[t]; });
  },
  onShow: function () {


  },
  // 加载日记
  getDiary(params) {
    console.log("Loading diary data...")

    var id = params["id"], diary;
    if (id === undefined) {
      diary = diaries.diaries[0];
    } else {
      diary = diaries.diaries[id % 2]
    }

    this.setData({
      diary: diary,
    });
  },

  // 过滤出预览图片列表
  getMediaList() {
    if (typeof this.data.diary !== 'undefined' &&
      this.data.diary.list.length) {
      this.setData({
        mediaList: this.data.diary.list.filter(
          content => content.type === 'IMAGE'),
      })
    }
  },

  // 进入预览模式
  enterPreviewMode(event) {
    let url = event.target.dataset.src;
    let urls = this.data.mediaList.map(media => media.content);
    let previewIndex = urls.indexOf(url);

    this.setData({ previewMode: true, previewIndex });
  },

  // 退出预览模式
  leavePreviewMode() {
    this.setData({ previewMode: false, previewIndex: 0 });
  },

  onLoad: function (params) {
    console.log(params)
    var _this = this;
    // console.log(sid);
    //发送请求获取游记数据
    wx.request({
      url: 'https://qqy.fun/data/Notes/getItem?sid=' + params.id,
      data: [],
      method: 'GET',
      dataType: 'json',
      header: { 'content-type': 'application/x-www-form-urlencoded' },
      success: function (res) {
        //设置当前页面标题
        wx.setNavigationBarTitle({
          title: res.data[0].title
        })
        _this.data.content = _this.escape2Html(res.data[0].content)
        _this.data.content = app.convertHtmlToText(_this.data.content);
        console.log(_this.data.content);
        console.log(res.data)
        _this.setData({
          content: _this.data.content,
          item: res.data//设置数据

        })
      },
      fail: function (err) {
        console.log(err)
      },
      complete: function () {

      }
    })
    this.getDiary(params);
    this.getMediaList();
  },

  onHide: function () { }
})
