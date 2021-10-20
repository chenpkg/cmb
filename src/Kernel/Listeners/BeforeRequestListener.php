<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/10/20 14:04
 */

namespace Cmb\Kernel\Listeners;

use Cmb\Kernel\Events\BeforeRequest;

class BeforeRequestListener
{
    public function handle(BeforeRequest $event)
    {
        // var_dump(json_encode($event->base));
    }
}