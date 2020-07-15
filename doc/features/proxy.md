# 代理 IP 池

## 注解

### @ProxyPool

声明代理 IP 池，在爬虫对象或者爬虫项对象上声明，则请求时自动从代理 IP 池中取出代理IP

类名：`\Yurun\Crawler\Module\Crawler\Annotation\ProxyPool`

**参数：**

名称 | 描述 | 默认值
-|-|-
class|代理 IP 池名|
args|实例化参数|
method|获取 IP 的方式：`random`(随机)、`next`(下一个)|

#### 代理 IP 池支持

**MySqlProxyPool：**

实例化参数：`{连接池名, 表名}`

**RedisProxyPool：**

实例化参数：`{连接池名, 键名[, 格式化类名]}`

格式化类名默认：`\Imi\Util\Format\Json`

## 代理信息类

类名：`Yurun\Crawler\Module\Proxy\Model`

**属性：**

名称 | 描述
-|-
host|主机名
port|端口
username|用户名
password|密码
type|类型

## 方法

### getNextProxy

获取下一个代理 IP

### getRandomProxy

获取随机代理 IP

### getProxys

获取所有代理 IP

### getCount

获取代理 IP 数量

### add

增加代理 IP

`public function add(Proxy $proxy)`

### remove

移除代理 IP

`public function remove(Proxy $proxy)`

### clear

清空代理 IP 池
