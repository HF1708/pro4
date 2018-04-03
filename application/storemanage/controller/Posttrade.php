<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 23:41
 */
namespace app\storemanage\controller;
use think\Controller;
use think\db;
//引用七牛CDN工具包
use qiniu\Auth;
//引用七牛 上传类
use Qiniu\Storage\UploadManager;
class Posttrade extends Controller
{
    /**
     *  *  功能描述:显示商家发布商品页面
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-28
     **/
    public function index()
    {
        //        查询省
        $where=["pid"=>0];
        $re=db("hy_area")->where($where)->select();
        $re=json_encode($re);
        $this->assign("province",$re);
        return $this->fetch();
    }
    /**
     *  *  功能描述:商品发布提交
     *  参数：无
     *  返回：无
     *  作者:qingtian Y
     *  时间：18-3-29
     **/
    public function posttrade(){
// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){

            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){

                // 成功上传后 获取上传信息
                // 输出 jpg
                $accessKey="Ou3dYnN_F3atjGwiQNj7ry2eVYVAPz4hmTCC3B1j";
                $secretKey="WTymiPYvuH_pI3jWC6BsPVb6K6G0KV5BSwPjSrOV";
                $auth=new Auth($accessKey,$secretKey);
                $bucket = 'hf1708traval';
                // 生成上传Token
                                $token = $auth->uploadToken($bucket);
                // 构建 UploadManager 对象
                               $filePath=ROOT_PATH.DS.'public/uploads/'.$info->getSaveName();
                               $filePath = "test.png";
                                $uploadMgr = new UploadManager();
                                $key=$info->getFilename();
                                $re=$uploadMgr->putFile($token,$key,$filePath);

                // 输出 jpg
//                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();

                //获取表单提交数据
                $store_id=1;
                $hotelName=input("?post.hotelName")?input("post.hotelName"):"";
                $corporation_province=input("?post.corporation_province")?input("post.corporation_province"):"";
                $corporation_city=input("?post.corporation_city")?input("post.corporation_city"):"";
                $corporation_province=input("?post.corporation_province")?input("post.corporation_province"):"";
                $site=input("?post.site")?input("post.site"):"";
                $roomNumber=input("?post.roomNumber")?input("post.roomNumber"):"";
                $roomPrice=input("?post.roomPrice")?input("post.roomPrice"):"";
                $corporation_grade=input("?post.corporation_grade")?input("post.corporation_grade"):"";
                $corporation_grade=input("?post.hotel_textarea")?input("post.hotel_textarea"):"";
                $corporation_town=input("?post.corporation_town")?input("post.corporation_town"):"";
                $hotel_textarea=input("?post.hotel_textarea")?input("post.hotel_textarea"):"";
                $submitTime=@date("Y-m-d H:i:s",time()+60*60*8);
                $data=['hName'=>$hotelName,
                    'hImg'=>$info->getSaveName(),
                    'hRoomNumber'=>$roomNumber,
                    'hAddress'=>$site,
                    'hPrice'=>$roomPrice,
                    'store_id'=>$store_id,
                    'provinceID'=>$corporation_province,
                    'cityID'=>$corporation_city,
                    'townID'=>$corporation_town,
                    'upTime'=>$submitTime,
                    'grade'=>$corporation_grade,
                    'textarea'=>$hotel_textarea
                ];
                $re=db('store_shotel')->insert($data);
               if($re==1){
                   $this->success('提交成功！请等待审核');
               }else{
                   $this->error('提交失败请重试！');
               }

            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
}