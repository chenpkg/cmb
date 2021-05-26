<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 14:40
 */

namespace Cmb\Payment\PolyPay;

class Client extends BaseClient
{
    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function qrCode(array $params)
    {
        return $this->requestVerify('mchorders/qrcodeapply', $params);
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderQuery($orderId)
    {
        return $this->requestVerify('mchorders/orderquery', [
            'orderId' => $orderId
        ]);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refund(array $params)
    {
        return $this->requestVerify('mchorders/refund', $params);
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refundQuery($orderId)
    {
        return $this->requestVerify('mchorders/refundquery', [
            'orderId' => $orderId
        ]);
    }

    /**
     * @param $orderId
     * @return array|\Cmb\Kernel\Http\Response|\Chenpkg\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function close($orderId)
    {
        return $this->request('mchorders/close', [
            'origOrderId' => $orderId
        ]);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function orderQrCode(array $params)
    {
        return $this->requestVerify('mchorders/orderqrcodeapply', $params);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function onlinePay(array $params)
    {
        return $this->requestVerify('mchorders/onlinepay', $params);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aliServerPay(array $params)
    {
        return $this->requestVerify('mchorders/servpay', $params);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function aliQrCode(array $params)
    {
        return $this->requestVerify('mchorders/zfbqrcode', $params);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function miniAppOrder(array $params)
    {
        return $this->requestVerify('mchorders/MiniAppOrderApply', $params);
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function wxQrCode(array $params)
    {
        return $this->requestVerify('mchorders/wxqrcode', $params);
    }
}