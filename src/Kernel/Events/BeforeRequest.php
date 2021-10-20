<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/10/20 13:55
 */

namespace Cmb\Kernel\Events;

class BeforeRequest
{
    public $base;

    /**
     * @param array $base
     */
    public function __construct(array $base)
    {
        $this->base = $base;
    }
}