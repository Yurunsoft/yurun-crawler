# 随机 UserAgent

## 配置 UserAgent 列表

`@app.beans`：

```php
[
    'UserAgentManager'  =>  [
        'list'  =>  [
            // 这里可以放想要用的 UserAgent 列表
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:65.0) Gecko/20100101 Firefox/65.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0.3 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/18.17763',
            'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko',
        ],
    ],
]
```

## 启用随机 UA

在`Crawler`或`CrawlerItem`类上写上`@RandomUA`注解

## 注解

### @RandomUA

类名：`\Yurun\Crawler\Module\Crawler\Annotation\RandomUA`

**参数：**

名称 | 描述 | 默认值
-|-|-
enable|是否启用|`true`
