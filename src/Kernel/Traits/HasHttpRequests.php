<?php
/**
 * Created by Cestbon.
 * Author Cestbon <734245503@qq.com>
 * Date 2021/1/27 11:04
 */

namespace Cmb\Kernel\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use function Chenpkg\Support\tap;

trait HasHttpRequests
{
    use ResponseCastable;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    protected $handlerStack;

    /**
     * The request options.
     *
     * @var array
     */
    protected $requestOptions = [];

    /**
     * @var array
     */
    protected static $defaults = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * Set guzzle default settings.
     *
     * @param array $defaults
     */
    public static function setDefaultOptions($defaults = [])
    {
        self::$defaults = $defaults;
    }

    /**
     * Return current guzzle default settings.
     */
    public static function getDefaultOptions(): array
    {
        return self::$defaults;
    }

    /**
     * Specify the request's content type.
     *
     * @param  string  $contentType
     * @return $this
     */
    public function contentType(string $contentType)
    {
        return $this->withHeaders(['Content-Type' => $contentType]);
    }

    /**
     * Indicate that JSON should be returned by the server.
     *
     * @return $this
     */
    public function acceptJson()
    {
        return $this->accept('application/json');
    }

    /**
     * Indicate the type of content that should be returned by the server.
     *
     * @param  string  $contentType
     * @return $this
     */
    public function accept($contentType)
    {
        return $this->withHeaders(['Accept' => $contentType]);
    }

    /**
     * Add the given headers to the request.
     *
     * @param array $headers
     * @return $this
     */
    public function withHeaders(array $headers)
    {
        // 简化 return $this

        return tap($this, function ($request) use ($headers) {
            $this->requestOptions = array_merge_recursive($this->requestOptions, [
                'headers' => $headers
            ]);
        });
    }

    /**
     * Set GuzzleHttp\Client.
     *
     * @param ClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        if (! ($this->httpClient instanceof  ClientInterface)) {
            $this->httpClient = new Client(['handler' => HandlerStack::create($this->getGuzzleHandler())]);
        }
        return $this->httpClient;
    }

    /**
     * Add a middleware.
     *
     * @param callable    $middleware
     * @param string|null $name
     * @return $this
     */
    public function pushMiddleware(callable $middleware, string $name = null)
    {
        if (! is_null($name)) {
            $this->middlewares[$name] = $middleware;
        } else {
            $this->middlewares[] = $middleware;
        }

        return $this;
    }

    /**
     * Return all middlewares.
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param        $url
     * @param string $method
     * @param array  $options
     * @return ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($url, $method = 'GET', $options = []): ResponseInterface
    {
        $method = strtoupper($method);

        if (isset($options['json'])) {
            $this->contentType('application/json');
        }

        if (property_exists($this, 'baseUri') && ! is_null($this->baseUri)) {
            $url = ltrim(rtrim($this->baseUri, '/').'/'.ltrim($url, '/'), '/');
        }

        $response = $this->getHttpClient()->request($method, $url, $this->mergeRequestOptions([
            'handler' => $this->getHandlerStack()
        ], static::$defaults, $options));

        $response->getBody()->rewind();

        return $response;
    }

    /**
     * @param HandlerStack $handlerStack
     * @return $this
     */
    public function setHandlerStack(HandlerStack $handlerStack)
    {
        $this->handlerStack = $handlerStack;

        return $this;
    }

    /**
     * Build a handler stack.
     *
     * @return HandlerStack
     */
    public function getHandlerStack(): HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        return $this->handlerStack = tap(HandlerStack::create($this->getGuzzleHandler()), function ($stack) {
            foreach ($this->middlewares as $name => $middleware) {
                $stack->push($middleware, $name);
            }
        });
    }

    /**
     * Get guzzle handler.
     *
     * @return callable
     */
    public function getGuzzleHandler()
    {
        return \GuzzleHttp\choose_handler();
    }

    /**
     * Merge the given options with the current request options.
     *
     * @param  array  $options
     * @return array
     */
    public function mergeRequestOptions(...$options)
    {
        return array_merge_recursive($this->requestOptions, ...$options);
    }
}