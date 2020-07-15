# 模型存储

类名：`\Yurun\Crawler\Module\Processor\Handler\ModelStorageProcessor`

Bean 名：`ModelStorageProcessor`

用于在`@Processor`注解中指定。

## 注解

### @ModelStorage

类名：`\Yurun\Crawler\Module\Processor\Annotation\ModelStorage`

**参数：**

名称 | 描述 | 默认值
-|-|-
model|对应的模型类名|
fields|字段映射列表，将 DataModel 中的 a 赋值给模型类的 b：'a' => 'b'，为空则为全部字段都赋值|
uniqueFields|用于判断，重复数据不入库的模型字段，为空则不判断|
