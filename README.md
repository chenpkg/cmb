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

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/chenpkg/cmb/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/chenpkg/cmb/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT