## 介绍
一个对Laravel应用模型ID进行对称加密的辅助函数。
  
依赖于[hashid/hashid](https://github.com/ivanakimov/hashids.php)

只适用于正整数加密

## 安装
```sh
$ composer require jiaxincui/hashid
```
## 配置
1. 复制`config/hashid.php`文件到Laravel项目的`config`文件夹。
2. 在.env文件添加配置项`HASH_ID_KEY=your-key`。
* **为了加密成更安全的字符串，请手动重新生成HASH_ID_KEY，为0-9a-zA-Z共62个字符随机排序，字符不可重复，长度为16-62，可使用以下方法生成**
```php
echo str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
```
## 简单使用
包含两个辅助方法`id_encode()`和`id_decode()`。
在Laravel项目的任何地方均可使用这两个函数对ID进行加密或解密。

### 例子
```php

echo id_encode(4568); //输出:N5lkv0
  
echo id_decode('N5lkvO'); //输出:4568
  
//不可对float类型数字加密，不可对负数加密，给定任何非正整数参数都会返回null
echo id_encode(2.36); //非正整数,抛出错误
echo id_encode(-23); //非正整数,抛出错误
  
//解密时任何无效字符串参数或校验错误都将返回null, 如：
echo id_decode('m_Dl9'); //包含无效字符,抛出错误
echo id_decode('nlK8GhRW'); //校验错误,抛出错误

```
## Laravel深度应用
### 加密
有2种方法实现自动加密
* 如果模型主键为`id`

  通过Hashid提供的trait，在数据库模型中使用`use Hashid;`，对结果中的`id`字段自动加密成字符串，例如：
```php
<?php
namespace App;
  
use Illuminate\Database\Eloquent\Model;
use Jiaxincui\Hashid\Traits\Hashid;
 
class User extends Model
{
    use Hashid;

}
```
* 如果模型中的主键不是`id`
  
  你需要在模型中定义一个访问器，如你的主键为`pid`，在Model中添加访问器如下：
  
```php
public function getPidAttribute($value)
{
  return id_encode($value);
}
```
### 解密

通过Hashid提供的middleware对路由参数解码，在控制器中无需做任何操作即可解码加密后的路由参数。
首先在`App\Http\Kernel.php`中注册中间件，在`Kernel`类的`$routeMiddleware`属性添加中间件条目。例如：
```php
'hashid' => \Jiaxincui\Hashid\Http\Middleware\Hashid::class,
```
现在你可以在路由中分配中间件了。例如：
```php
Route::resource('/users', 'UserController')->middleware('hashid');
```
#### 中间件参数
默认情况下，`Hashid`中间件会解密当前路由的所有路由参数，如果你想指定被解密的路由参数可在中间件传入参数，例如：
```php
Route::get('users/{user}/posts/{post}/comments/{comment}', function ($user, $post, $comment) {
    //
})->middleware('hashid:user,post');

```
以上例子中间件只解密给出的参数，如以上例子会解密路由参数`user`和`post`,不会解密`commnent`

现在你的应用已经具备完整的加密和解密模型ID的功能。

## License

[MIT](https://github.com/jiaxincui/hashid/blob/master/LICENSE.md) © [JiaxinCui](https://github.com/jiaxincui)