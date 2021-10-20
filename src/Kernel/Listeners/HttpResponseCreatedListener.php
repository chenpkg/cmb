<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/10/20 14:05
 */

namespace Cmb\Kernel\Listeners;

use Cmb\Kernel\Events\HttpResponseCreated;

class HttpResponseCreatedListener
{
    public function handle(HttpResponseCreated $event)
    {
        // var_dump($event->response->getBody()->__toString());
    }
}