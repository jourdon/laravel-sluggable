# laravel-Sluggable
[![Latest Stable Version](https://poser.pugx.org/jourdon/sluggable/v/stable)](https://packagist.org/packages/jourdon/sluggable)
[![Total Downloads](https://poser.pugx.org/jourdon/sluggable/downloads)](https://packagist.org/packages/jourdon/sluggable)
[![Latest Unstable Version](https://poser.pugx.org/jourdon/sluggable/v/unstable)](https://packagist.org/packages/jourdon/sluggable)
[![License](https://poser.pugx.org/jourdon/sluggable/license)](https://packagist.org/packages/jourdon/sluggable)

## 说明
我的博客有很多文章，很多分类，他们的链接是这样的
```base
//文章
http://example.com/post/1
http://example.com/post/2
//分类
http://example.com/category/1
http://example.com/category/2
```
这看起来非常不友好，我希望将后面的id换成文章的村里或者分类的名称，这样看起来比较友好，从链接就能看出来文章的内容，对搜索引擎也比较友好，像这样：
```base
http://example.com/post/php-is-the-best-language-in-the-world
http://example.com/post/yes-i-think-so
//分类
http://example.com/category/php
http://example.com/category/laravel
```
你只需要安装本扩展包，你不需要另外做什么，它会自动帮你搞定，可以根据你的Eloquent模型生成相应的slug，让你的url更加的友好。


##要求

* PHP版本: 7.1+
* laravel版本:5.5+

## 安装

1、 使用 Composer 安装:

```bash
composer require jourdon/sluggable
```
2、 配置

>本扩展包本身不需要配置文件,也无需配置，但本扩展包依赖于 [laravel-slug](https://github.com/jourdon/laravel-slug) ,所以需要导出`laravel-slug` 的配置文件，具体请前往 [laravel-slug](https://github.com/jourdon/laravel-slug)  查看并配置。

3、 添加Slug字段 

你的数据表中需要有slug字段，执行下面的命令生成迁移文件，以Post模型为例:
```php
php artisan jourdon:make_slug Post
```
4、 运行迁移
```php
php artisan migrate
```
>如果你的数据表中已经有slug字段，请忽略 3，4

5、将Eloquent模型的slug加入缓存，注意这里，Laravel默认的Model目录在app下，假如你的Eloquent模型都放在app/models目录下，你需要在Eloquent模型前加上Models/
```php
php artisan jourdon:make_cache Models/Post
```


## 使用
还是以Post模型为例，我们需要使用SlugTrait
```php

use Jourdon\Sluggable\Traits\SlugTrait;

class Post extends Model
{
    use SlugTrait;
    .
    .
    .
}

```
如果你还需要将Category的URL也变得这么漂亮，只需要重复3，4，5即可。
### OK. 已经完成了，去看看你的链接吧，
