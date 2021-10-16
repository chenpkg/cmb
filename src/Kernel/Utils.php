<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 14:23
 */

namespace Cmb\Kernel;

use Chenpkg\Support\Arr;
use Chenpkg\Support\RSA;
use Cmb\Support\SM2;

final class Utils
{
    /**
     * @param $params
     * @param $privateKey
     * @param string $signMethod
     * @return string
     */
    public static function sign($params, $privateKey, $signMethod = '01', $path = '')
    {
        ksort($params);

        $params = urldecode(http_build_query($params));

        if ($signMethod == '01') {
            return RSA::sign($params, $privateKey);
        }

        return SM2::sign($path, base64_encode($params), $privateKey);
    }

    /**
     * @param $params
     * @param $publicKey
     * @return bool
     */
    public static function verifyPolyPay($params, $publicKey, $signMethod = '01', $path = '')
    {
        if (! array_key_exists('sign', $params)) {
            return false;
        }

        $sign = Arr::pull($params, 'sign');

        ksort($params);
        $string = urldecode(http_build_query($params));

        if ($signMethod == '01') {
            return RSA::verify($string, $sign, $publicKey);
        }

        return SM2::verify($path, base64_encode($string), $sign, $publicKey);
    }
}