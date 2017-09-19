## 介绍
Laravel对ID进行对称加密的辅助函数

只适用于正整数加密,目前只测试12位以内正整数有效
## 安装
```sh
$ composer require jiaxincui/hashid
```
## 配置
1. 复制`config/hashid.php`文件到Laravel项目的`config`文件夹
2. 在.env文件添加配置项`HASH_ID_KEY=your-key`
* 请务必手动重新生成HASH_ID_KEY,为0-9a-zA-Z共62个字符随机排序,字符不可重复,长度为16-62,可使用以下方法生成
```php
echo str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
```
## 使用
在laravel项目的任何地方均可使用`id_encode()`或`id_decode()`函数对ID进行加密或解密

### 例子
```php

echo id_encode(4568); //输出:N5lkv0
  
echo id_decode('N5lkvO'); //输出:4568
  
//不可对float类型数字加密，不可对负数加密，给定任何非正整数参数都会返回null
echo id_encode(2.36); //非正整数,输出:null
echo id_encode(-23); //非正整数,输出:null
  
//解密时任何无效字符串参数或校验错误都将返回null, 如：
echo id_decode('m_Dl9'); //包含无效字符,输出:null
echo id_decode('nlK8GhRW'); //校验错误,输出:null

```