<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 13:30
 */

namespace Cmb\Payment\PolyPay;

use Cmb\Kernel\Traits\SetConfig;
use Cmb\Payment\Application;
use Cmb\Kernel\Exceptions\InvalidSignException;
use Cmb\Kernel\Utils;
use Cmb\Kernel\Traits\HasHttpRequests;
use function Chenpkg\Support\tap;

class BaseClient
{
    use HasHttpRequests { request as performRequest; }
    use SetConfig;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $baseUri = 'https://api.cmbchina.com/polypay/v1.0';

    /**
     * BaseClient constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->resolveBaseUri();
    }

    /**
     * resolve baseUri.
     */
    public function resolveBaseUri()
    {
        if ($this->app['config']['test']) {
            $this->baseUri = 'https://api.cmburl.cn:8065/polypay/v1.0';
        }
    }

    /**
     * Extra request params.
     *
     * @return array
     */
    protected function prepends()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function bizPrepends()
    {
        return [];
    }

    /**
     * @param        $url
     * @param array  $params
     * @param string $method
     * @param array  $options
     * @param bool   $returnRaw
     * @return array|\Cmb\Kernel\Http\Response|\Chenpkg\Support\Collection|object|string|\Psr\Http\Message\ResponseInterface
     *
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($url, array $params = [], $method = 'post', array $options = [], $returnRaw = false)
    {
        $base = [
            'version'    => '0.0.1',
            'encoding'   => 'UTF-8',
            'signMethod' => '01',
            'biz_content' => ''
        ];

        // 业务字段
        $bizContent = [
            'merId' => $this->app['config']['mer_id'],
            'userId' => $this->app['config']['user_id']
        ];

        $base = array_filter(array_merge($base, $this->prepends()), 'strlen');

        $params = array_filter(array_merge($bizContent, $this->bizPrepends(), $params), 'strlen');

        $base['biz_content'] = json_encode($params);

        $base['sign'] = Utils::sign($base, $this->app['config']['private_key']);

        $this->headerMiddleware($base['sign']);

        $options = array_merge([
            'json' => $base
        ], $options);

        $response = $this->performRequest($url, $method, $options);

        return $returnRaw ? $response : $this->castResponseToType($response, $this->app['config']['response_type']);
    }

    /**
     * @param        $url
     * @param array  $params
     * @param string $method
     * @param array  $options
     * @return mixed
     * @throws \Cmb\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function requestVerify($url, array $params = [], $method = 'post', array $options = [])
    {
        return tap($this->request(...func_get_args()), function ($response) {
            $this->syncVerify($response);
        });
    }

    /**
     * @param array $params
     * @throws InvalidSignException
     */
    protected function syncVerify(array $params)
    {
        if (! Utils::verifyPolyPay($params, $this->app['config']['cmb_public_key'])) {
            throw new InvalidSignException('Invalid sign.');
        }
    }

    /**
     * header sign.
     *
     * @param $sign
     */
    protected function headerMiddleware($sign)
    {
        $this->requestOptions['headers'] = [];

        $appid = $this->app['config']['appid'];
        $secret = $this->app['config']['secret'];
        $timestamp = time();

        $data = [
            'appid'     => $appid,
            'secret'    => $secret,
            'sign'      => $sign,
            'timestamp' => $timestamp
        ];

        ksort($data);
        $apisign = md5(urldecode(http_build_query($data)));

        $this->withHeaders([
            'appid'     => $appid,
            'timestamp' => $timestamp,
            'apisign'   => $apisign
        ]);
    }
}