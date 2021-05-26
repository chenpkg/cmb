<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/5/26 17:04
 */

include '../vendor/autoload.php';

use Cmb\Factory;
use Cmb\Payment\PolyPay\Client;

$config = [
    'appid'  => '8ab74856-8772-45c9-96db-54cb30ab9f74',
    'secret' => '5b96f20a-011f-4254-8be8-9a5ceb2f317f',
    // 商户 ID
    'mer_id' => '30899910742001D',
    // 收银员 ID
    'user_id' => 'N003189955',
    // 商户公钥
    'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnOeNKrmAvccwjGXhTnvFJhN1uS1q6hXf9gw0h0AEsavL5josBUUhtobFV7Y35jS0DYbaU0dEhg1I5ArMfkiR9CQ5zn0NsVx2rDuuUZ79sKx7OuD+lNGlKzFo4GqY5Ji8M0VddgCjQF++zBiKHKXAdCmYZPtAFXOqEAgcm1euSUxrvqQMhSzCUbSD+ZB91TLl5ooOlXomQLIxHsA/3psYCt3F3ozEL6pTWBZwi7Ge6LwIa/m4c+kh5DsLN6fNDus30Gyny83UlWmSvBZ8DT851MQCu+20WTdMxd1fZi/fs62q7xTw+VZHFRzS49A0cy5q9nOU24gooLOPiPjTH4aaCwIDAQAB',

    'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCc540quYC9xzCMZeFOe8UmE3W5LWrqFd/2DDSHQASxq8vmOiwFRSG2hsVXtjfmNLQNhtpTR0SGDUjkCsx+SJH0JDnOfQ2xXHasO65Rnv2wrHs64P6U0aUrMWjgapjkmLwzRV12AKNAX77MGIocpcB0KZhk+0AVc6oQCBybV65JTGu+pAyFLMJRtIP5kH3VMuXmig6VeiZAsjEewD/emxgK3cXejMQvqlNYFnCLsZ7ovAhr+bhz6SHkOws3p80O6zfQbKfLzdSVaZK8FnwNPznUxAK77bRZN0zF3V9mL9+zrarvFPD5VkcVHNLj0DRzLmr2c5TbiCigs4+I+NMfhpoLAgMBAAECggEAbM8GzoImDXV87WAZhtu+NFF6ahhc9EiHL5H3O3PhzXRdyiK9NEpkvrdnUxRCX5pc4qSJ8waRNoUv7zSt60VYMf6NN+zw+fYtNfONR30CYOq76nDtGzbnW7TADiDeNmjU2plX3uVCUPoUzmSWIpevht7xl9XE8xtq7AM0E2YSrzEADcxtqQslM0uVOf+ki1eu0/OwCz13FzPlPtnDwt2Lw9xxCxWqTgpN4oD5m6EWTqbognUIJ0EFD0dHXjrYnHXc+/Za5e+CDXYApHuhR9bifa1e4HMN084oLY+rkSXUV3+Te0APPCfbeEeqvubziDmKxxKaWUq1wPbYi4c06ZQdgQKBgQDhF7zDWgiJFTgrLGmExJRKiR/3QZN4sugYE1itdRDJmiPV4xhWPXSsND3WtqR5+0otb/hbzRa3cyl/RXV/1ZmBbE46fX2DKnmLQ1gP74iOuqWpfxjh/qpk+3kEY9aP57le/O0QEEPsJmqCsGM7XnzfNsxGAFYaDHooRbcGtv++AwKBgQCycuvRUQjV4dxTuRJuwFbmdq4odSBMu7yCS4i5I9I73d3TGZBWfiXQWFmuiPh+pf3HdvMbgyA243Uv/NGapSmNvARXm0/eEyfTxV7+GVdwLf3sSe8DQMCR1eJA9VzuS+jhCrHkFgyW3V/3ki66W8YITENlgC+VebOatfFE8i/ZWQKBgQCZ2VmhxFX1LFW53J86qgoZb+QzYdTkOJQ+cGq6FDunL/2yYYfu2g527TYfHbMJ1OH8cH22cVVHiiUg4l7PQzWqqlZF0CQLlOqCb0MvkS8rLxOv6DkfrqrUXrV2dK7gqSegbwuxYQyryg4eyWTp3UlIX/H7Hpu7LjAIeq4Anu/p9QKBgFMtpiYHM6segGi2F5VwKhF6uGs7TTb3O0MwmiZSQCiPnlpLzC/E1TNsO0FTryC5lrVnCKKGWHm9RF595eXDnr7mKM/9IRlOrH3VvhWLEmrDxVxiifpmMFzJ6ZCFzi91SrO7HHhIns2jmpv3k7hiFsi/Y5roSUXPWJyAull82jjhAoGAaKujjF4HL91UXZFetkkKiBIpIrH5+XbiX9z7H9/Tv8NSy/zTvXp3hFl3dr9gO722i/96dTq4th23Gqtih4cA9x8Wd7RChR9yAK/ffSj1lW6RhBWj1j2JCPFCm1TJD5iO3bIeuHm2sAuafKKoWT/VCUkKRwt9Wwh9yF20vMQ3kFw=',

    'cmb_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjutZyxP2L9eYM6DhZ11jk5lZieyyA6Wsr4baAU7PT+E0fv3KlERoh0edHLsLVff2I4AzuEqSoKDywKIBw1aSkIXGAaESj/FzA/V1jtmorq1RpPFmaqAOGDocMiaqukBBemwFnsYrTegsZUf88fU7KujwEMffLhhpwnM/Vf0NJ2s3ZwEZCgPWDa5cm1YpMLgopzc5HozENI5K9VFL92ThjHiTiutE28Bpi2xgSt6Cx+S8Nxqhy6/r/YVxvfgP66YCccnWOObN3fWo5TXepP6uBReTwjqNajlcSC5JqINqUUEAqief87y3NAFKRbE7Bu312y6zqcJgC/TIrWLXXB1/XQIDAQAB',

    // 是否开启测试环境
    'test' => true
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
$a = $app->polypay->wxQrCode($params);

var_dump($a);