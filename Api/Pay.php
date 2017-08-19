<?php
/**
*手机网站支付类
*/
namespace AliWapPay\Api;

class Pay extends Common{
	
	public $body;

	public $subject;

	public $out_trade_no;

	public $timeout_express = '30m';

	public $time_expire;

	public $total_amount;

	public $auth_token;

	public $product_code = 'QUICK_WAP_WAY';

	public $goods_type;

	public $passback_params;

	public $extend_params;

	public $enable_pay_channels;

	public $disable_pay_channels;

	public $store_id;

	public $quit_url;

	//////////////////业务扩展参数////////////////

	public $sys_service_provider_id;

	public $needBuyerRealnamed;

	public $TRANS_MEMO;

	public $hb_fq_num;

	public $hb_fq_seller_percent;

	public function Request(){
		//获取公共参数
		$params = $this->common_content("alipay.trade.wap.pay");
		$params['biz_content'] = $this->biz_content();
		//拼接字符串
		$string = $this->getSignContent($params);
		//获取签名
		$params['sign']=$this->sign($string);

		return $this->buildRequestForm($params);
	}
	/**
	*获取请求参数
	*/
	private function biz_content(){

		$params = array(
			'body'=>$this->body, //点单详情
			'subject'=>$this->subject,//点单标题
			'out_trade_no'=>$this->out_trade_no,//商户网站订单唯一编号
			'timeout_express'=>$this->timeout_express,
			'time_expire'=>$this->time_expire,
			'total_amount'=>$this->total_amount,//支付的金额，单位为元
			'auth_token'=>$this->auth_token,
			'product_code'=>$this->product_code,
			'goods_type'=>$this->goods_type,
			'passback_params'=>$this->passback_params,
			'extend_params'=>$this->extend_params(),
			'enable_pay_channels'=>$this->enable_pay_channels,
			'disable_pay_channels'=>$this->disable_pay_channels,
			'store_id'=>$this->store_id,
			'quit_url'=>$this->quit_url
		);
		//排除空白选项
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		return json_encode($params);
	}
	/**
	*获取扩展参数
	*/
	public function extend_params(){
		$params = array(
			'sys_service_provider_id'=>$this->sys_service_provider_id,
			'needBuyerRealnamed'=>$this->needBuyerRealnamed,
			'TRANS_MEMO'=>$this->TRANS_MEMO,
			'hb_fq_num'=>$this->hb_fq_num,
			'hb_fq_seller_percent'=>$this->hb_fq_seller_percent
		);
		foreach ($params as $key => $value) {
			if($value=='' || $value==NULL){
				unset($params[$key]);
			}
		}
		return json_encode($params);
	}
	/**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
	protected function buildRequestForm($params) {
		
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".GATEWAYURL."?charset=".trim($this->charset)."' method='POST'>";

		foreach ($params as $key => $value) {
			if (false !== $this->checkEmpty($val)) {
				$sHtml .= "<input type='hidden' name='".$key."' value='".$value."'/>";
			}
		}

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
		
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		
		return $sHtml;
		// var_dump($sHtml);
	}

}






?>