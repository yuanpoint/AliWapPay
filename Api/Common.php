<?php
/**
*公共参数封装
*/
namespace AliWapPay\Api;

class Common{
	public $app_id;

	public $method;

	public $format = "JSON";

	public $return_url;//HTTP/HTTPS开头字符串

	public $charset = "utf-8";

	public $sign_type = "RSA2";

	public $sign;

	public $timestamp;

	public $version = "1.0";

	public $notify_url;//支付宝回调地址
 
    public $biz_content;//请求参数合集

    public function __construct(){
    	$this->timestamp = date('Y-m-d H:i:s');
    }
    /**
	*获取公共参数
	*/
	public function common_content($method){
		$params = array(
			'app_id'=>APPID,
			'method'=>$method,
			'format'=>$this->format,
			'return_url'=>$this->return_url,
			'charset'=>$this->charset,
			'sign_type'=>$this->sign_type,
			'timestamp'=>$this->timestamp,
			'version'=>$this->version,
			'notify_url'=>$this->notify_url
		);
		foreach ($params as $item) {
			if($item=="" || $item==NULL){
				unset($item);
			}
		}
		return $params;
	}
	/**
	 * 校验$value是否非空
	 *  if not set ,return true;
	 *    if is null , return true;
	 **/
	public function checkEmpty($value) {
		if (!isset($value))
			return true;
		if ($value === null)
			return true;
		if (trim($value) === "")
			return true;

		return false;
	}

	/**
	*拼接字符串函数
	*$params array 数组
	*@return  string $stringToBeSigned
	*/
	public function getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}

	/**
	*待签名的字符串 string $data
	*$signType 签名算法的规则，支付宝支持RSA、RSA2，推荐RSA2;
	*/
	public function sign($data, $signType = "RSA2") {

		$priKey=RSA_PRIVATE_KEY;
		$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
			wordwrap($priKey, 64, "\n", true) .
			"\n-----END RSA PRIVATE KEY-----";

		($res) or die('您使用的私钥格式错误，请检查RSA私钥配置'); 

		if ("RSA2" == $signType) {
			openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
		} else {
			openssl_sign($data, $sign, $res);
		}

		$sign = base64_encode($sign);

		return $sign;
	}
}








?>