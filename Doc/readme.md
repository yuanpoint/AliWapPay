调用方法
$Pay = new \AliWapPay\Pay();
$Pay->subject = "";//订单标题
$Pay->out_trade_no = ;//商户网站订单唯一编号
$Pay->total_amount = "";//支付金额
$Pay->Request();