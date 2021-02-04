<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 10:47
 */

namespace Chenpkg\Cmb\Kernel\Providers;

use Chenpkg\Support\Repository;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        ! isset($pimple['config']) && $pimple['config'] = function ($app) {
            return new Repository($app->getConfig());
        };
    }
}