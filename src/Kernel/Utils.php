<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 14:23
 */

namespace Chenpkg\Cmb\Kernel;

use Chenpkg\Support\Arr;
use Chenpkg\Support\RSA;

final class Utils
{
    /**
     * @param $params
     * @param $privateKey
     * @return string
     */
    public static function sign($params, $privateKey)
    {
        ksort($params);

        return RSA::sign(urldecode(http_build_query($params)), $privateKey);
    }

    /**
     * @param $params
     * @param $publicKey
     * @return bool
     */
    public static function verifyPolyPay($params, $publicKey)
    {
        if (! array_key_exists('sign', $params)) {
            return false;
        }

        $sign = Arr::pull($params, 'sign');

        ksort($params);
        $string = urldecode(http_build_query($params));

        if (! RSA::verify($string, $sign, $publicKey)) {
            return false;
        }

        return true;
    }
}