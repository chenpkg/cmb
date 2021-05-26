<h1 align="center"> cmb </h1>

<p align="center"> 招商银行聚合支付 SDK </p>


## Installing

```shell
$ composer require chenpkg/cmb -vvv
```

## Usage

```php
require './vendor/autoload.php';

use Cmb\Factory;

$config = [
    'appid'  => 'appid',
    'secret' => 'secret',
    // 商户 ID
    'mer_id' => 'mer_id',
    // 收银员 ID
    'user_id' => 'user_id',
    // 商户公钥
    'public_key' => '...',
    // 商户私钥
    'private_key' => '...',
    // 招行公钥
    'cmb_public_key' => '...',

    // 是否开启测试环境
    'test' => true
];

$app = Factory::payment($config);

$orderId = date('YmdHis').random_int(1000, 9999);

$params = [
    'orderId'    => $orderId,
    'notifyUrl'  => 'https://localhost/payment/notify',
    'txnAmt'     => 0.1 * 100,
    'tradeScene' => 'OFFLINE',
];

// 二维码支付
$app->polypay->qrCode($params);

// 查询订单
$app->polypay->orderQuery($orderId);

// 订单退款
$app->polypay->refund($refundData);

// 查询退款订单
$app->polypay->refundQuery($refundOrderId);

// 关闭订单
$app->polypay->close($orderId);

// 订单二维码
$app->polypay->orderQrCode($params);
```

## 消息通知

```php
$response = $app->handlePaidNotify(function ($message, $fail) {
    // data
    var_dump($message);
    
    // 你的逻辑
    
    return true;
    
    // 或者错误消息
    return $fail('Order not exists.');
});

$response->send(); // Laravel 里请使用：return $response;
```

## License

MIT