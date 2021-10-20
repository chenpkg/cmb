<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/10/20 13:55
 */

namespace Cmb\Kernel\Events;

use Psr\Http\Message\ResponseInterface;

class HttpResponseCreated
{
    /**
     * @var ResponseInterface
     */
    public $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }
}