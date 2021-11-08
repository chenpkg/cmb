<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 16:08
 */

namespace Cmb\Payment\Notify;

use Closure;
use Symfony\Component\HttpFoundation\JsonResponse;
use Cmb\Kernel\Utils;
use Cmb\Kernel\Exceptions\InvalidSignException;
use Cmb\Payment\Application;

abstract class Handler
{
    public const SUCCESS = 'SUCCESS';
    public const FAIL = 'FAIL';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $fail;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * Check sign.
     * If failed, throws an exception.
     *
     * @var bool
     */
    protected $check = true;

    /**
     * Respond with sign.
     *
     * @var bool
     */
    protected $sign = false;

    /**
     * Handler constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Closure $closure
     * @return mixed
     */
    abstract public function handle(Closure $closure);

    /**
     * @param string $message
     */
    public function fail(string $message)
    {
        $this->fail = $message;
    }

    /**
     * @return JsonResponse
     */
    public function toResponse()
    {
        $returnCode = is_null($this->fail) ? static::SUCCESS : static::FAIL;

        $base = [
            'version'    => '0.0.1',
            'encoding'   => 'UTF-8',
            'signMethod' => $this->app['config']->get('sign_method', '01'),
            'returnCode' => $returnCode,
            'respCode'   => $returnCode,
        ];

        if (! is_null($this->fail)) {
            $base['respMsg'] = $this->fail;
        }

        ksort($base);

        $base['sign'] = Utils::sign(
            $base,
            $this->app['config']->get('private_key'),
            $this->app['config']->get('sign_method', '01'),
            $this->app['config']->get('bin_path')
        );

        return new JsonResponse($base);
    }

    /**
     * @return array
     * @throws InvalidSignException
     */
    public function getMessage()
    {
        if (! empty($this->message)) {
            return $this->message;
        }

        $message = $this->app['request']->request->all();

        if ($this->check) {
            $this->verify($message);
        }

        return $this->message = $message;
    }

    /**
     * @param array $message
     * @throws InvalidSignException
     */
    public function verify(array $message)
    {
        if (! Utils::verifyPolyPay(
            $message,
            $this->app['config']->get('cmb_public_key'),
            $this->app['config']->get('sign_method', '01'),
            $this->app['config']->get('bin_path')
        )) {
            throw new InvalidSignException('Invalid sign.');
        }
    }

    /**
     * @param $result
     */
    protected function strict($result)
    {
        if (true !== $result && is_null($this->fail)) {
            $this->fail((string) $result);
        }
    }
}