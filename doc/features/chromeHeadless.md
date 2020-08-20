# Chrome Headless 页面渲染采集

支持使用 Chrome Headless 渲染页面及JS后，采集页面内容。

> 此功能建议在 Swoole v4.5.3 正式版中使用

## 配置

`@app.beans`:

```php
[
    'ChromeDownloader'  =>  [
        'path'      =>  '', // 可执行文件路径或http接口地址
        'options'   =>  [], // 创建浏览器的参数
    ],
]
```

> Docker 下使用建议 `path` 填 http 接口地址，即：`http://{host}:{port}/json`

## 注解

在 `@Downloader` 注解中，指定 `class` 为 `ChromeDownloader`

### @ChromeNavigation

Chrome 导航注解

类名：`\Yurun\Crawler\Module\Downloader\Annotation\ChromeNavigation`

**参数：**

名称 | 描述 | 默认值
-|-|-
eventName|等待事件名称(`DOMContentLoaded`/`load`/`networkIdle`)|`load`
timeout|超时时间，单位：毫秒|30000

## 安装

### Docker

```shell
docker pull alpeware/chrome-headless-trunk
docker run -d -p 9222:9222 alpeware/chrome-headless-trunk
```

### apt

`apt install chromium-browser`
