<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/2/4 11:49
 */

namespace Cmb\Payment\Notify;

use Cmb\Payment\Handler;
use Closure;

class Paid extends Handler
{
    /**
     * @param Closure $closure
     * @return mixed|\Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Cmb\Kernel\Exceptions\InvalidSignException
     */
    public function handle(Closure $closure)
    {
        $this->strict(
            \call_user_func($closure, $this->getMessage(), [$this, 'fail'])
        );

        return $this->toResponse();
    }
}