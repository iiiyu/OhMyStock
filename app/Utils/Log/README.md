## 说明
该Log主要实现分文件按日输出日志，便于调试查错，目的是主要用于业务日志。

## 注册
```
AppServiceProvider注册
$this->app->singleton('fileLog', 'App\Utils\Log\FileDailyWriter');
```

## 使用
```php
use App\Utils\Log\Facades\FileLog as Log;
//支持直接文件名打印
//输出在 storage/logs/filename-2018-08-10.log
//$msg可以是多种类型
Log::filename($msg);
//支持定义log级别
Log::filename('debug', $msg);
//支持常规log,各种级别的日志，会输出到到默认日志
Log::debug($msg);
```

