Component({
  options: {
    multipleSlots: true // 在组件定义时的选项中启用多slot支持
  },
  /**
   * 组件的属性列表
   * 用于组件自定义设置
   */
  properties: {
    setName:String
  },

  /**
   * 私有数据,组件的初始数据
   * 可用于模版渲染
   */
  data: {
    latitude: 26.04769,
    longitude: 119.27345,
    markers: []
  },

  /**
   * 组件的方法列表
   * 更新属性和数据的方法与更新页面数据的方法类似
   */
  methods: {
    includePoints: function () {
      var that = this ;
      this.mapCtx.includePoints({
        padding: [10],
        points: [{
          latitude: (that.data.latitude+0.1),
          longitude: (that.data.longitude),
          iconPath: '/images/location.png'
        }, {
            latitude: (that.data.latitude),
            longitude: (that.data.longitude),
          iconPath: '/images/location.png'
        }]
      })
    }
  },

  /**
   * 组件布局完成后执行
   */
  ready:function(){
    var that = this ;
    this.mapCtx = wx.createMapContext('myMap',this) ;
    // 获取信息的对应参数
    var data = {
      name: this.properties.setName
    } ;

    // 获取对应经纬度信息
    wx.request({
      url: 'https://www.qqy.fun/data/Data/getLL' , //仅为示例，并非真实的接口地址
      data: data , 
      method:"POST" ,
      dataType:"json" ,
      header: {
        'content-type': 'application/json' // 默认值
      },
      success: function (res) {
        that.setData({
          markers: res.data
        }) ;
        that.mapCtx.includePoints({
          padding: [10],
          points: that.data.markers
        });
      }
    }) ;
    /**
     * 获取用户位置信息
     */
    wx.getLocation({
      // type: 'wgs84',
      type: 'GCJ02' ,
      success: function (res) {
        var latitude = res.latitude ;
        var longitude = res.longitude ;
        var speed = res.speed ;
        var accuracy = res.accuracy ;
        that.setData({
          latitude : res.latitude ,
          longitude: res.longitude
        }) ;
      }
    }) 
  } ,
 

})
