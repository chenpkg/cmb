<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 10:41
 */

namespace Chenpkg\Cmb;

use Chenpkg\Support\Str;

/**
 * Class Factory
 *
 * @method static \Chenpkg\Cmb\Payment\Application payment(array $config = [])
 */
class Factory
{
    /**
     * @param       $name
     * @param array $config
     * @return mixed
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Chenpkg\\Cmb\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}