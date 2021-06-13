# 一个简易的PHP网盘

#### 介绍
毕业设计的一部分成果，用PHP构建了一个简易的网盘，可以在服务器上管理一些小型的文件，无需数据库管理系统支持，即开即用

#### 软件架构
* 开发语言: PHP(version 7.3)、JS、HTML
* 数据库：sqlite(db文件在源码的“DB”文件夹中)


#### 安装教程

把“code”文件夹下的“fileManager”文件夹放置在PHP服务器的根目录下即可，无需其它任何配置

#### 使用说明

1.  管理员用户：admin 密码：admin
2.  管理员用户可以查看所有用户的文件，在首页点击右键可以进入用户信息管理模块。（就是放入了"phpSQLiteAdmin"数据库管理工具，类似于"phpMyAdmin",默认密码是：admin)
3.  网盘基本功能：上传单个文件、下载单个文件、新建文件、删除文件、删除文件夹
4. 文件上传的大小有限制，一般php默认是小于2M，可以在php源码的php.ini中修改这个限制。

#### 静态展示
* [点我查看系统静态演示DEMO](https://markchen7788.github.io/a-simple-php-network-disk-/staticDemo/)

