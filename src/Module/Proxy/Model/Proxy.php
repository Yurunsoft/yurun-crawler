<?php
namespace Yurun\Crawler\Module\Proxy\Model;

use Yurun\Crawler\Module\Proxy\Enum\ProxyType;

/**
 * 代理信息
 */
class Proxy
{
    /**
     * 主机名
     *
     * @var string
     */
    public $host;

    /**
     * 端口
     *
     * @var string
     */
    public $port;

    /**
     * 用户名
     *
     * @var string|null
     */
    public $username;

    /**
     * 密码
     *
     * @var string|null
     */
    public $password;

    /**
     * 类型
     *
     * @var string
     */
    public $type;

    public function __construct(string $host, int $port, ?string $username = null, ?string $password = null, string $type = ProxyType::HTTP)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->type = $type;
    }

    /**
     * 从数组创建
     *
     * @param array $array
     * @return self
     */
    public static function createFromArray(array $array): self
    {
        return new static($array['host'] ?? '', $array['port'] ?? 0, $array['username'] ?? null, $array['password'] ?? null, $array['type'] ?? ProxyType::HTTP);
    }

}
