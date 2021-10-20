<h1 align="center"> cmb </h1>

<p align="center"> 招商银行聚合支付 SDK </p>

## Requirement

1. PHP >= 7.2 | PHP >= 8.0
2. shell_exec 函数

由于 `sm2` 国密算法使用 `go` 实现，所以需要使用 `shell_exec` 调用命令行程序。`go` 源码 [点击这里](https://github.com/chenpkg/cmbsm2) 查看

## Installing

```shell
$ composer require chenpkg/cmb -vvv
```

## Usage

```php
require './vendor/autoload.php';

use Cmb\Factory;
use Cmb\Payment\PolyPay\Client;

$config = [
    'appid'  => 'appid',
    'secret' => 'secret',
    // 商户 ID
    'mer_id' => 'mer_id',
    // 收银员 ID
    'user_id' => 'user_id',
    // 商户私钥
    'private_key' => '...',
    // 招行公钥
    'cmb_public_key' => '...',
    // 签名方法，默认使用 01(RSA2)
    'sign_method' => '01', // 01(RSA2) or 02(SM2)
    // sm2 签名程序目录，绝对路径，如果签名失败确认文件权限组、权限是否正确
    // 建议将 ./bin 目录下的 sm2 与 sm2.exe 拷贝出来，然后给予 755 权限。因为 composer update 该扩展包时，文件权限组可能会被修改
    'bin_path' => '/www/此处省略.../sm2',
    
    // 是否开启测试环境
    'test' => true,
    
    // 事件监听
    'events' => [
        // 将以下 Listener 类换成自己的 Listener 类即可
        'listen' => [
            // 请求前事件
            \Cmb\Kernel\Events\BeforeRequest::class => [
                // 支持两种监听方式
                // function ($event) { var_dump($event->base);die; }
                [new \Cmb\Kernel\Listeners\BeforeRequestListener(), 'handle']
            ],

            // 请求完成事件
            \Cmb\Kernel\Events\HttpResponseCreated::class => [
                [new \Cmb\Kernel\Listeners\HttpResponseCreatedListener(), 'handle']
            ]
        ]
    ]
];

// 扩展 api 接口, 添加宏方法
// 例如：添加银联云闪付api
Client::macro('cloudPay', function ($params) {
    // 如果需要同步验签
    return $this->requestVerify('mchorders/cloudpay', $params);
    // 不需要同步验签
    return $this->request('mchorders/cloudpay', $params);
});

$app = Factory::payment($config);

$orderId = date('YmdHis').random_int(1000, 9999);

$params = [
    'orderId'    => $orderId,
    'notifyUrl'  => 'https://localhost/payment/notify',
    'txnAmt'     => 0.1 * 100,
    'tradeScene' => 'OFFLINE',
];

// 调用自定义方法宏 api
$app->polypay->cloudPay($params);

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

// 微信统一下单
$app->polypay->onlinePay($params);

// 支付宝服务窗支付
$app->polypay->aliServerPay($params);

// 支付宝二维码
$app->polypay->aliQrCode($params);

// 微信小程序支付
$app->polypay->miniAppOrder($params);

// 微信二维码支付
$app->polypay->wxQrCode($params);
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
