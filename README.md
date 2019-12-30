## 让项目支持psr4加载规范
### 使用
```php

require_once "./Autoload.php";

spl_autoload_register("Autoload::autoloader"); # 向php注册自动加载 [不会覆盖掉composer的自动加载,无需担心]

Autoload::set_error(true);        # 设置抛错 [正式环境不要开启. 且注意:在规范中不应在自动加载中抛错]
Autoload::set_root_dir("/home/"); # 查找的根目录 [加载规范:根目录/类名空间对应目录/类名]
Autoload::add("zslm\\user\\", "src/user/");    # 向自动加载加入需要自动载入的空间名称 [类PSR4规范,参考composer的自动加载说明:autoload->psr-4]

```
### 加载说明
```php

Autoload::set_root_dir("/home/");
Autoload::add("zslm\\user\\", "src/user/");# 如何理解呢 看下面的注释

new zslm\user\auth(); # 触发自动加载 从 /home/src/user/ 中寻找 auth.php 如果没用找到 php会自动抛出类不存在错误 如果设置了开启报错也会先抛出一个文件不存在的提示错误.
# 只要遵从规范 都可以做到自动加载

new zslm\user\app\index(); # 触发自动加载 从 /home/src/user/app/ 中寻找 index.php

# 这样就可以多个空间对应多个文件夹 psr4规范就是这么简单轻松 如
Autoload::add("zslm\\a\\",    "src/aaa/");
Autoload::add("zslm\\b\\",    "src/666/");

# 不过 务必注意大小写区分

```
