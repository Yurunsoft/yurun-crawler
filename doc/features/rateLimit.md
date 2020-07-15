# 下载器限流

使用`@Downloader`注解实现。

## 注解

### @Downloader

类名：`\Yurun\Crawler\Module\Crawler\Annotation\Downloader`

为这个爬虫对象下所有爬虫项目设置一个缺省的下载器

**参数：**

名称 | 描述 | 默认值
-|-|-
class|下载器类名|`Yurun\Crawler\Module\Downloader\Handler\YurunHttpDownloader`
queue|下载器队列名|defaultDownloader
limit|限流数量，小于等于0时不限制|`null`
limitUnit|限流单位时间，默认为：秒(second)；支持：microsecond、millisecond、second、minute、hour、day、week、month、year|`limitUnit`
limitWait|限流等待时间，单位：秒|60
