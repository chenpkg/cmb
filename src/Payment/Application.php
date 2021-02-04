<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 11:22
 */

namespace Cmb\Payment;

use Closure;
use Cmb\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \Cmb\Payment\PolyPay\Client $polypay
 */
class Application extends ServiceContainer
{
    protected $providers = [
        PolyPay\ServiceProvider::class
    ];

    /**
     * pay notify.
     *
     * @param Closure $closure
     * @return mixed|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Cmb\Kernel\Exceptions\InvalidSignException
     */
    public function handlePaidNotify(Closure $closure)
    {
        return (new Notify\Paid($this))->handle($closure);
    }
}