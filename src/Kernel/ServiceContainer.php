<?php

/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 10:43
 */

namespace Cmb\Kernel;

use Pimple\Container;
use Cmb\Kernel\Providers\EventServiceProvider;
use Cmb\Kernel\Providers\RequestServiceProvider;
use Cmb\Kernel\Providers\ConfigServiceProvider;

/**
 * @property \Chenpkg\Support\Repository                        $config
 * @property \Symfony\Component\HttpFoundation\Request          $request
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $events
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    public function __construct(array $config = [], array $prepends = [])
    {
        $this->userConfig = $config;

        parent::__construct($prepends);

        $this->registerProviders($this->getProviders());
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return array_replace_recursive($this->defaultConfig, $this->userConfig);
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            RequestServiceProvider::class,
            EventServiceProvider::class,
        ], $this->providers);
    }

    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function __isset($id)
    {
        return $this->offsetExists($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}
