//index.js

var app = getApp()
Page({
    /**
   * 页面的初始数据
   */
  data: {
    pageType: 1,
    // index
    userInfo: {},
    orderOrBusiness: 'order',

    // buycar
    totalMoney: 0,
    chooseAll: false,
    arr: [
      { id: 0, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "3", price: "51.21", selected: false },
      { id: 1, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "3", price: "61", selected: false },
      { id: 2, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "3", price: "71", selected: false },
      { id: 3, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "3", price: "81", selected: false },
      { id: 4, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "3", price: "81", selected: false }
    ],
    arr3: [
      { id: 0, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "0", price: "51", message: "配米饭一份哦", message2: "月售330｜好评率100%", message3: [{ id: 0, value: "香辣味" }, { id: 1, value: "盐焗味" }, { id: 2, value: "蒜香味" }, { id: 3, value: "姜葱味" },] },
      { id: 1, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "0", price: "51", message: "配米饭一份哦", message2: "月售330｜好评率100%", message3: '' },
      { id: 2, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "0", price: "51", message: "配米饭一份哦", message2: "月售330｜好评率100%", message3: [{ id: 0, value: "香辣味2" }, { id: 1, value: "盐焗味2" }, { id: 2, value: "蒜香味2" }, { id: 3, value: "姜葱味2" },] },
      { id: 3, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "0", price: "51", message: "配米饭一份哦", message2: "月售330｜好评率100%", message3: [{ id: 0, value: "香辣味3" }, { id: 1, value: "盐焗味3" }, { id: 2, value: "蒜香味3" }, { id: 3, value: "姜葱味3" },] },
      { id: 4, img: "../../img/food2.jpg", name: "五花肉石锅拌饭", num: "0", price: "51", message: "配米饭一份哦", message2: "月售330｜好评率100%", message3: [{ id: 0, value: "香辣味4" }, { id: 1, value: "盐焗味4" }, { id: 2, value: "蒜香味4" }, { id: 3, value: "姜葱味4" },] },
    ],
    // order
    orderOk: false,
    // me
    img: ''
  },
    /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function () {    
    var that = this;
    // 显示酒店页面
      wx.request({
        url: 'https://www.qqy.fun/data/Hotel/gethotel',
          method: "get",
          dataType:'json',
          header:{'content-type':'application/x-www-form-urlencoded'},
          success: function (res) {
            console.log(res.data);
            that.setData({
              hotel:res.data
            }) 
            console.log(that.data.hotel);
          },
          fail:function(err){
            console.log(err)
          }
    })
    app.getUserInfo(function (userInfo) {
      that.setData({
        userInfo: userInfo,
        img: userInfo.avatarUrl
      })
    })
    wx.getSystemInfo({
      success: function (res) {
        that.setData({ 
          height: (res.windowHeight*.57)+'px'
        })
      }
    });
  },
  turnMenu: function(e) {
    var type = e.target.dataset.index;
    // console.log(type)
    this.setData({
      orderType: type
    })
  },
  chooseType: function (e) {
    var type = e.currentTarget.dataset.id;
    if (type == 1 && this.data.restaurant == true) {
      wx.setNavigationBarTitle({ title: '酒店' })
    } else if (type == 1 && this.data.restaurant != true) {
      wx.setNavigationBarTitle({ title: '' })
    } else if (type == 2) {
      wx.setNavigationBarTitle({ title: '收藏' })
    } else if (type == 3) {
      wx.setNavigationBarTitle({ title: '订单' })
    } else if (type == 4) {
      wx.setNavigationBarTitle({ title: '我的' })
    }
    this.setData({
      pageType: type
    })
  },
  // index
  searchKey: function(e) {
    this.setData({
      searchKey: e.detail.value
    })    
  },
  searchBtn: function() {
    var keyWork = this.data.searchKey;
    wx.redirectTo({
      url: '../test/test',
    })
    wx.request({
      url: '',
      data: {
        
      },
      success: function (res) {
        
      }
    })
  },
  tabChange: function(e) {
    var type = e.currentTarget.dataset.id;
    this.setData({
      orderOrBusiness: type
    })
  },
  //打开红包
  getPag: function() {
    this.setData({
      open: true,
      page: false
    })
  },
  //关闭红包
  hasGet: function () {
    this.setData({
      open: false
    })
  },
  toSetmenu: function() {
    wx.navigateTo({
      url: '../setmenu/setmenu'
    })
  },
  saoma: function() {
    var that = this;
    wx.scanCode({
      onlyFromCamera: true,
      success: (res) => {
        // console.log(res);
        that.setData({
          restaurant: true
        })
        wx.setNavigationBarTitle({ title: '点餐' })
      },
      fail: (res) => {
        that.setData({
          restaurant: false
        });
      }
    })
  },
  //酒店详情跳转
  toHoteilDetail: function(event) {
    console.log('hahh')
    console.log(event)
    let postId = event.currentTarget.dataset.postid;
    console.log(postId)
    wx.navigateTo({
      url: '../detail/detail?hId=' + postId,
    })
  },
  reduce: function (e) {
    var i = e.currentTarget.dataset.id;
    var arr3 = this.data.arr3;
    if (arr3[i].num > 1) { 
      wx.showToast({
        title: '多规格商品只能去购物车删除哦',
        duration: 2000
      })
    }else{
      if (arr3[i].num > 0) {
        arr3[i].num = parseInt(arr3[i].num) - 1;
        this.setData({
          arr3: arr3
        })
      }      
    }
  },
  reduce2: function (e) {
    var i = e.currentTarget.dataset.id;
    var arr3 = this.data.arr3;
    if (arr3[i].num > 0) {      
      arr3[i].num = parseInt(arr3[i].num) - 1;
      this.setData({
        arr3: arr3
      })
    }
  },
  add: function (e) {
    var i = e.currentTarget.dataset.id;
    var arr3 = this.data.arr3;
    var arr = arr3[i].message3;    
    this.setData({
      block: true,
      arr2: arr,
      bindId: i
    })
  },
  add2: function (e) {
    var i = e.currentTarget.dataset.id;
    var arr3 = this.data.arr3;
    arr3[i].num = parseInt(arr3[i].num) + 1;
    this.setData({
      arr3: arr3
    })
  },
  close: function () {
    this.setData({
      block: false
    })
  },
  resetNum: function (e) {
    var type = e.currentTarget.dataset.id;
    this.setData({
      foodtype: type
    })
  },
  submit: function() {
    var i = this.data.bindId;
    var arr3 = this.data.arr3;
    arr3[i].num = parseInt(arr3[i].num)+1
    this.setData({
      block: false,
      arr3: arr3
    })
  },
  getAddress: function() {
    var that = this;
    wx.chooseLocation({
      success: function (res) {
        if (res.address.length > 10) {
          res.address = res.address.substr(0, 10) + '...'
        }
        that.setData({
          map_address: res.address
        })
      },
    })
  },
  takeOut: function() {
    this.setData({
      restaurant: false
    })
    wx.setNavigationBarTitle({ title: '外卖' })
  },
  // buycar
  del: function (e) {
    var that = this;
    wx.showModal({
      title: '提示',
      content: '确定删除吗',
      success: function (res) {
        if (res.confirm) {
          var index = parseInt(e.currentTarget.dataset.id);
          var arr = that.data.arr;
          var totalMoney = that.data.totalMoney;
          var buycar_num = that.data.buycar_num;
          if (arr[index].selected) {
            totalMoney -= Number(arr[index].price * arr[index].num);
            buycar_num -= Number(arr[index].num);
          }
          arr.splice(index, 1);
          that.setData({
            arr: arr,
            totalMoney: totalMoney,
            buycar_num: buycar_num
          });
        }
      }
    })    
  },
  choose: function (e) {
    var index = parseInt(e.currentTarget.dataset.id);
    var selected = this.data.arr[index].selected;
    var arr = this.data.arr;
    var totalMoney = this.data.totalMoney;
    var buycar_num = this.data.buycar_num;
    arr[index].selected = !selected;
    if (arr[index].selected) {
      totalMoney += Number(arr[index].price * arr[index].num);
      buycar_num += Number(arr[index].num);
    } else {
      totalMoney -= Number(arr[index].price * arr[index].num);
      buycar_num -= Number(arr[index].num);
    }
    totalMoney = Number(totalMoney).toFixed(2);
    this.setData({
      arr: arr,
      totalMoney: Number(totalMoney),
      buycar_num: buycar_num
    });
  },
  toSubmit: function() {
    wx.navigateTo({
      url: '../submitOrder/submitOrder',
    })
  },
  numAdd: function(e) {
    var index = parseInt(e.currentTarget.dataset.id);
    var selected = this.data.arr[index].selected;
    var arr = this.data.arr;
    var totalMoney = this.data.totalMoney;
    var buycar_num = this.data.buycar_num;
    arr[index].num = Number(arr[index].num) + 1;
    if(selected==true){
      totalMoney += Number(arr[index].price);
      buycar_num += 1;
    }
    totalMoney = Number(totalMoney).toFixed(2);
    this.setData({
      arr: arr,
      totalMoney: Number(totalMoney),
      buycar_num: buycar_num
    });
  },
  numReduce: function (e) {
    var index = parseInt(e.currentTarget.dataset.id);    
    var arr = this.data.arr;
    if (arr[index].num > 1) {
      var selected = arr[index].selected;
      var totalMoney = this.data.totalMoney;
      var buycar_num = this.data.buycar_num;
      arr[index].num = Number(arr[index].num) - 1;
      if (selected == true) {
        totalMoney -= Number(arr[index].price);
        buycar_num -= 1;
      }
      totalMoney = Number(totalMoney).toFixed(2);
      this.setData({
        arr: arr,
        totalMoney: Number(totalMoney),
        buycar_num: buycar_num
      });
    }    
  },
  // order
  orderOk: function() {
    this.setData({
      orderOk: true
    })
  },
  okCancel: function() {
    this.setData({
      orderOk: false
    })
  },
  calling: function () {
    wx.makePhoneCall({
      phoneNumber: '18316588252',
      success: function () {
        console.log("拨打电话成功！")
      },
      fail: function () {
        console.log("拨打电话失败！")
      }
    })
  },
  okOk: function () {
    this.setData({
      orderOk: false
    })
  },
  //事件处理函数
  bindViewTap: function () {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  toMyPackage: function () {
    wx.navigateTo({
      url: '../myPackage/myPackage'
    })
  },
  toMyAddress: function () {
    wx.navigateTo({
      url: '../address/address'
    })
  },
  toDetail: function() {
    wx.navigateTo({
      url: '../orderDetail/orderDetail'
    })
  }
})
