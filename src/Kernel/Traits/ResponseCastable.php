<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 14:04
 */

namespace Chenpkg\Cmb\Kernel\Traits;

use Chenpkg\Cmb\Kernel\Http\Response;
use Chenpkg\Support\Contracts\Arrayable;
use Chenpkg\Cmb\Kernel\Exceptions\InvalidConfigException;
use Psr\Http\Message\ResponseInterface;

trait ResponseCastable
{
    /**
     * @param ResponseInterface $response
     * @param null              $type
     * @return array|Response|\Chenpkg\Support\Collection|mixed|object
     *
     * @throws InvalidConfigException
     */
    protected function castResponseToType(ResponseInterface $response, $type = null)
    {
        $response = Response::buildFromPsrResponse($response);
        $response->getBody()->rewind();

        switch ($type ?? 'array') {
            case 'collection':
                return $response->toCollection();
            case 'array':
                return $response->toArray();
            case 'object':
                return $response->toObject();
            case 'raw':
                return $response;
            default:
                if (! is_subclass_of($type, Arrayable::class)) {
                    throw new InvalidConfigException(sprintf('Config key "response_type" classname must be an instanceof %s', Arrayable::class));
                }

                return new $type($response);
        }
    }
}