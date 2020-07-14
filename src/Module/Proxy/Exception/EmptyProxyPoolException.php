<?php
namespace Yurun\Crawler\Module\Proxy\Exception;

/**
 * 空的代理 IP 池
 */
class EmptyProxyPoolException extends \Exception
{
    public function __construct (string $message = 'The proxy pool is empty', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
