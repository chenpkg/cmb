<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/10/15 9:43
 */

namespace Cmb\Support;


use Cmb\Kernel\Exceptions\RuntimeException;

class SM2
{
    /**
     * 签名
     *
     * @param $content
     * @param $privateKey
     * @return string
     * @throws RuntimeException
     */
    public static function sign($path, $content, $privateKey)
    {
        $command = static::getBin($path).' sign -pri "'.$privateKey.'" -src64 "'.$content.'"';

        $sign = shell_exec($command);

        if (! $sign) {
            throw new RuntimeException("sm2 sign error.");
        }

        return $sign;
    }

    /**
     * 验签
     *
     * @param $path
     * @param $content
     * @param $sign
     * @param $publicKey
     * @return bool
     */
    public static function verify($path, $content, $sign, $publicKey)
    {
        $command = static::getBin($path).' verify -pub "'.$publicKey.'" -sign "'.$sign.'" -src64 "'.$content.'"';

        $status = shell_exec($command);

        if ($status != 'true') {
            return false;
        }

        return true;
    }

    /**
     * 获取 sm2 签名程序
     *
     * @param $path
     * @return string
     */
    public static function getBin($path)
    {
        $bin = strpos(PHP_OS, "Linux") !== false ? 'sm2' : 'sm2.exe';

        return rtrim($path, '/').'/'.$bin;
    }
}