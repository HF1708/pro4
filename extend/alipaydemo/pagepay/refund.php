<?php

require_once dirname(dirname(__FILE__)).'/config.php';
require_once dirname(__FILE__).'/service/AlipayTradeService.php';
require_once dirname(__FILE__).'/buildermodel/AlipayTradeRefundContentBuilder.php';


//商户订单号，商户网站订单系统中唯一订单号
//    $out_trade_no = trim($_POST['WIDTRout_trade_no']);
$out_trade_no = trim(input("?post.WIDTRout_trade_no")?input("post.WIDTRout_trade_no"):"");

//支付宝交易号
$trade_no = trim(input("?post.WIDTRtrade_no")?input("post.WIDTRtrade_no"):"");
//请二选一设置

//需要退款的金额，该金额不能大于订单金额，必填
//    $refund_amount = trim($_POST['WIDTRrefund_amount']);
$refund_amount = trim(input("?post.WIDTRrefund_amount")?input("post.WIDTRrefund_amount"):"");

//退款的原因说明
//    $refund_reason = trim($_POST['WIDTRrefund_reason']);
$refund_reason = trim(input("?post.WIDTRrefund_reason")?input("post.WIDTRrefund_reason"):"");

//标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
//    $out_request_no = trim($_POST['WIDTRout_request_no']);
$out_request_no = trim(input("?post.WIDTRout_request_no")?input("post.WIDTRout_request_no"):"1");



//构造参数
	$RequestBuilder=new AlipayTradeRefundContentBuilder();
	$RequestBuilder->setOutTradeNo($out_trade_no);
	$RequestBuilder->setTradeNo($trade_no);
	$RequestBuilder->setRefundAmount($refund_amount);
	$RequestBuilder->setOutRequestNo($out_request_no);
	$RequestBuilder->setRefundReason($refund_reason);

	$aop = new AlipayTradeService($config);
	
	/**
	 * alipay.trade.refund (统一收单交易退款接口)
	 * @param $builder 业务参数，使用buildmodel中的对象生成。
	 * @return $response 支付宝返回的信息
	 */
	$response = $aop->Refund($RequestBuilder);
    if($response->code=="10000"){
        $re=db('store_hotelorder')->where('hoId',$out_trade_no)->setField('orderstate', '2');
        if($re==1){
            $returnJson = [
                'code' => 10000 ,
                'msg' => "操作成功" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }else{
            $returnJson = [
                'code' => 10001,
                'msg' => "操作失败" ,
                'data' => []
            ] ;
            echo json_encode($returnJson);
        }
    }else{
        $returnJson = [
            'code' => 10001,
            'msg' => "操作失败" ,
            'data' => []
        ] ;
        echo json_encode($returnJson);
    }
?>