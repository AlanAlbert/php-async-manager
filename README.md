# php-async

PHP异步任务管理工具（搭配[php-async](https://github.com/AlanAlbert/php-async)使用）

## Installation / 安装

```sh
$ composer require alanalbert/php-async-manager
```

## Usage / 使用

**该命令行工具只能配合php-async-manager进行使用**

```sh
$ php vendor/bin/pam list
```

> 可用的命令：
> * list : 显示所有可用命令
> * task [-a|-c|-r|-s]: 查看异步进程
> * stop <pid> : 终止某个异步进程
