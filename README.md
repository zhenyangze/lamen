# Lamen: laravel along with lumen
在laravel框架中支持Lumen的运行，运行模式包含php-fpm和swoole两种模式。

Lumen可以使用Laravel框架大分部代码，包含配置，路由，控制器，模型，集合，缓存，队列，事件

**目前代码先在laravel5.5中测试**
**在仓库[swooletw/laravel-swoole](https://github.com/swooletw/laravel-swoole)基础上修改**
**貌似注意事项好多，有问题请留言**

### 快速上手
> 务必注意Lumen bug，看本页Lumen bug说明

1、安装包
```php
composer require yangze/lamen --prefer-dist
```
2、修改config/app.php，添加provider引用
```php
Lamen\Http\LaravelServiceProvider::class
```
3、发布配置文件
```php
php artisan vendor:publish --tag=lamen-swoole
```
4、修改config/lamen.php文件（**重要，影响程序运行**）
### 变量说明
| 键 | 名称 | 值 |
|--------|--------|--------|
|FRAME_WORK_NAME|当前框架的名称|laravel 或者 lumen|

5、运行
**以laravel模型运行**
```php
php artisan lamen:http start
```
**以lumen模式运行**
```php
php artisan_lume lamen:http start
```
**以nginx+php-fpm模式运行**
注意修改public/lamen.php文件，将其设置为入口文件。有2种方法，2选1：
- nginx 配置文件中 index 设置为lamen.php
- 移动public/lamen.php为public/index.php

### 配置文件说明
### 运行方式

### 备注说明

### 已知问题
1、路由正则配置模式有差别，在针对lumen的路由中不要出现laravel路由相应的写法，否则会提示route找不到或者为空的情况

2、laravel中获取路由参数和Lumen中获取路由参数不一样，需要写兼容方法调用

3、Lumen bug
```php
Type error: Too few arguments to function Illuminate\Cache\Console\ClearCommand::__construct(), 1 passed in vendor/laravel/lumen-framework/src/Console/ConsoleServiceProvider.php on line 113 and exactly 2 expected
```
修改文件： `vendor/laravel/lumen-framework/src/Console/ConsoleServiceProvider.php`，将代码
```php
    protected function registerCacheClearCommand()
    {
        $this->app->singleton('command.cache.clear', function ($app) {
            return new CacheClearCommand($app['cache']);
        });
    }
```
修改为：
```php
    protected function registerCacheClearCommand()
    {
        $this->app->singleton('command.cache.clear', function ($app) {
            return new CacheClearCommand($app['cache'], $app['files']);
        });
    }
```
