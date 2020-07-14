<?php
namespace Yurun\Crawler\Module\Proxy\Handler;

use Imi\Db\Db;
use Imi\Bean\Annotation\Bean;
use Yurun\Crawler\Module\Proxy\Model\Proxy;
use Yurun\Crawler\Module\Proxy\Contract\IProxyPool;
use Yurun\Crawler\Module\Proxy\Exception\EmptyProxyPoolException;

/**
 * MySQL 代理 IP 池
 * @Bean("MySqlProxyPool")
 */
class MySqlProxyPool implements IProxyPool
{
    /**
     * 创建表的 SQL
     */
    const CREATE_TABLE_SQL = <<<SQL
CREATE TABLE `{table}`  (
  `host` varchar(39) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主机地址',
  `port` smallint(5) UNSIGNED NOT NULL COMMENT '端口号',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '密码',
  `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类型'
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '代理IP池表-v1.0.0';
SQL;

    /**
     * 连接池名
     *
     * @var string
     */
    protected $poolName;

    /**
     * 表名
     *
     * @var string
     */
    protected $table;

    /**
     * 当前序号
     *
     * @var integer
     */
    protected $index = 0;

    public function __construct(string $poolName = null, string $table = null)
    {
        $this->poolName = $poolName;
        $this->table = $table;
    }

    public function __init()
    {
        $db = Db::getInstance($this->poolName);
        // 判断表是否存在
        if(1 != $db->query(<<<SQL
SELECT
	1
FROM
	`information_schema`.`TABLES`
WHERE
	`TABLE_SCHEMA` = database()
	AND `TABLE_NAME` = '{$this->table}';
SQL
        )->fetchColumn())
        {
            // 不存在则创建表
            $db->exec(str_replace('{table}', $this->table, static::CREATE_TABLE_SQL));
        }
    }

    /**
     * 获取下一个代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getNextProxy(): Proxy
    {
        $record = Db::query($this->poolName)->from($this->table)->offset($this->index++)->limit(1)->select()->get() ?? Db::query($this->poolName)->from($this->table)->offset($this->index = 0)->limit(1)->select()->get();
        if(!$record)
        {
            throw new EmptyProxyPoolException;
        }
        return Proxy::createFromArray($record);
    }

    /**
     * 获取随机代理 IP
     *
     * @return \Yurun\Crawler\Module\Proxy\Model\Proxy
     */
    public function getRandomProxy(): Proxy
    {
        $count = $this->getCount();
        if($count <= 0)
        {
            throw new EmptyProxyPoolException;
        }
        $record = Db::query($this->poolName)->from($this->table)
                                            ->offset(mt_rand(0, $count - 1))
                                            ->limit(1)
                                            ->select()
                                            ->get();
        if(!$record)
        {
            throw new EmptyProxyPoolException;
        }
        return Proxy::createFromArray($record);
    }

    /**
     * 获取所有代理 IP
     *
     * @return array
     */
    public function getProxys(): array
    {
        $list = [];
        foreach(Db::query($this->poolName)->from($this->table)->select()->getArray() as $row)
        {
            $list[] = Proxy::createFromArray($row);
        }
        return $list;
    }

    /**
     * 获取代理 IP 数量
     *
     * @return integer
     */
    public function getCount(): int
    {
        return Db::query($this->poolName)->from($this->table)
                                         ->count();
    }

    /**
     * 增加代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function add(Proxy $proxy)
    {
        Db::query($this->poolName)->from($this->table)
                                  ->insert((array)$proxy);
    }

    /**
     * 移除代理 IP
     *
     * @param \Yurun\Crawler\Module\Proxy\Model\Proxy $proxy
     * @return void
     */
    public function remove(Proxy $proxy)
    {
        $query = Db::query($this->poolName)->from($this->table);
        foreach($proxy as $k => $v)
        {
            if(null === $v)
            {
                $query->where($k, 'is', $v);
            }
            else
            {
                $query->where($k, '=', $v);
            }
        }
        $query->delete();
    }

    /**
     * 清空代理 IP 池
     *
     * @return void
     */
    public function clear()
    {
        Db::getInstance()->exec('TRUNCATE `' . $this->table . '`');
    }

}
