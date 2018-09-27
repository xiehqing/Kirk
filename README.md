**Read this in other languages: [English](README-EN.md).**  
# Kirk
一套PHP框架

[演示地址](http://huangkuankuan.cn)

借鉴了[RSF框架](https://github.com/suxianbaozi/RSF/)

## 框架目录结构
```
======================================= Kirk =======================================
www(我的配置是直接在github目录下)
|---kirk
|   |
|   |---app-admin           # admin模块
|   |   |---class           # 类文件
|   |   |---config          # 项目内配置文件
|   |   |---ctrl            # 控制器
|   |   |---interceptor     # 拦截器
|   |   |---plugin          # 视图插件
|   |   |---view            # 视图文件
|   |   |---index.php       # 项目A的入口文件
|   |
|   |---app-api             # api接口模块
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---index.php
|   |
|   |---app-job             # 脚本文件
|   |   |---class           # 类文件（要执行的脚本文件）
|   |   |   |---bin
|   |   |---config
|   |   |---run.php         # 脚本启动文件
|   |
|   |---app-static          # 静态文件模块
|   |   |---admin           # admin 模块
|   |   |   |---css
|   |   |   |---js
|   |   |   |---fonts
|   |   |   |---images
|   |   |   |...
|   |   |
|   |   |---home
|   |   |...
|   |
|   |---core                # 核心文件
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |
|   |---config              # 本地配置文件（开发者本地部署）
|   |   |---common.php
|   |   |---database.php
|   |   |---interceptor.php
|   |   |---pay.php
|   |   | ...
|   |
|   |---system              # 系统文件
|   |   |---class
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---functions.php   # 系统方法
|   |   | ...
|   |
|   |---log                 # 日志文件
|   |
|   |---vendor              # 外部依赖包
|   |
|   |--- ...
|
|
|---... 
======================================= Kirk =======================================
```

## 部署
项目应用部署`kirk.conf`文件：

### 首页模块部署
```
server {
    listen 80;
    server_name huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/kirk/app-home;
    rewrite . /index.php;
    location ~ .*\.(php|php5)?$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 后台模块部署
```
server {
    listen 80;
    server_name admin.huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/kirk/app-admin;
    rewrite . /index.php;
    location ~ .*\.(php|php5)?$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 接口模块部署
```
server {
    listen 80;
    server_name api.huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/kirk/app-api;
    rewrite . /index.php;
    location ~ .*\.(php|php5)?$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 静态文件模块部署
业务量大时，可单独部署到其它服务器。
```
server {
    listen 80;
    server_name static.huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/Cicada/app-static;
    limit_rate 512k;
}
```

## 注意

`nginx`重写路由绝对不允许指向项目根目录。在开发环境通过执行`Tool.php`可生成对应dao、bll、ctrl、view等代码，辅助开发，但线上环境必须删除`Tool.php`。

## 参考列表

* [RSF框架](https://github.com/suxianbaozi/RSF/)
