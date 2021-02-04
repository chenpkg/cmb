<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 11:37
 */

namespace Cmb\Payment\PolyPay;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['polypay'] = function ($app) {
            return new Client($app);
        };
    }
}