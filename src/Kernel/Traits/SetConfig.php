<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/21 10:16
 */

namespace Cmb\Kernel\Traits;

trait SetConfig
{
    /**
     * @param array $config
     * @return $this
     * @example
     *     [
     *     'appid' => '',
     *     'secret' => '',
     *     'mer_id' => '',
     *     'user_id' => '',
     *     'public_key' => '',
     *     'private_key' => '',
     *     'cmb_public_key' => '',
     *
     *     'test' => false
     * ]
     */
    public function setConfig(array $config)
    {
        if (property_exists($this, 'app')) {
            $this->app['config']->set($config);
        } else {
            $this['config']->set($config);
        }

        return $this;
    }
}