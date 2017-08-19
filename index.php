<?php
/**
* 支付宝手机网站支付启动页
*author: yuanpoint 
* time 2017.7.18
*/
namespace AliWapPay;

use Alipay\Api;

//Alipay要求PHP环境必须大于PHP5.3
if (!substr(PHP_VERSION, 0, 3) >= '5.3') {
    return "Fatal error: AliWapPay requires PHP version must be greater than 5.3(contain 5.3). Because AliWapPay used php-namespace";
}
// 定义根目录
define('ALIWAPPAY_ROOT_PATH',dirname(__FILE__) . '/');

//载入配置文件
require_once ALIWAPPAY_ROOT_PATH . 'Config.php';

//载入自动加载类
require_once ALIWAPPAY_ROOT_PATH . 'Autoload.php';




?>