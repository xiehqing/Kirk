# Kirk
自己琢磨的一套框架。

演示地址（博客版本，前端没弄，本人前端太烂了）：http://huangkuankuan.cn

借鉴了RSF框架[https://github.com/suxianbaozi/RSF/]

## 框架运行流程：
1. 入口文件(具体项目目录下)
2. 定义常量（框架所带的目录或者是函数库、第三方类库所带的目录）
3. 引入函数库
4. 定义核心文件
5. 定义配置文件（注意各目录下配置文件的优先级，项目目录《 核心文件《 根目录 ）
4. 自动加载类（自动加载一些文件，框架类、请求类等等）
5. 启动框架

## 框架目录结构
```
======================================= Kirk =======================================
www(我的配置是直接在github目录下)
|---kirk # 主要的项目文件（依赖较多，更新相对频繁的部分）
|   |
|   |---app-admin   # admin模块
|   |   |---class           # 类文件
|   |   |---config          # 项目内配置文件
|   |   |---ctrl            # 控制器
|   |   |---interceptor     # 拦截器
|   |   |---plugin          # 视图插件
|   |   |---view            # 视图文件
|   |   |---index.php       # 项目A的入口文件
|   |
|   |---app-home    # home模块
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---index.php
|   |
|   |---app-api     # 接口模快
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |   |---v1
|   |   |   |   |---admin   #一个模块对应一个控制器，新版本接口需要改动的就继承
|   |   |   |   |---home
|   |   |   |   |---...
|   |   |   |---v2
|   |   |   |---...
|   |   |
|   |   |---index.php       # 入口配置文件
|   |
|   |---app-job     # 脚本文件
|   |   |---class           # 类文件（要执行的脚本文件）
|   |   |   |---bin
|   |   |---config          # 配置文件
|   |   |---run.php         # 脚本启动文件
|   |
|   |---core        # 核心文件
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |
|   |---config      # 本地配置文件（开发者本地部署）
|   |   |---common.php
|   |   |---database.php
|   |   |---interceptor.php
|   |   |---pay.php
|   |   | ...
|   |
|   |---system  # 系统文件
|   |   |---class
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---functions.php   # 系统方法
|   |   | ...
|   |
|   |---log     # 日志文件
|   |
|   |---vendor  # 外部依赖包
|   |
|   |--- ...
|
|
|---Cicada # 文件系统，上传下载专用（依赖较少，更新也少的部分。可另外单独部署到其它服务器）
|   |
|   |---app-file      # 文件模块
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |
|   |---core        # 核心文件
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |
|   |---system  # 系统文件
|   |   |---class
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---functions.php   # 系统方法
|   |   | ...
|
|
|---static  # 静态文件部分，对外只支持读取（无依赖，只能开发中上传资源。可另外单独部署到其它服务器）
|   |
|   |---admin   # 项目admin的静态文件
|   |   |---css
|   |   |---js
|   |   |---font
|   |   |---...
|   |
|   |---home    # 项目home的静态文件
|   |---...
|
|
|---... 
======================================= Kirk =======================================
```

## 部署
项目应用部署`kirk.conf`文件：
```
# 首页模块
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

# 后台管理
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

# 接口模块
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

文件系统、静态文件部署`file.conf`文件（业务量大时，可单独部署到其它服务器）：
```
# 文件系统
server {
    listen 80;
    server_name file.huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/Cicada/app-show;
    rewrite . /index.php;
    location ~ .*\.(php|php5)?$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
server {
        listen       80;
        server_name upfile.huangkuankuan.cn;
        index index.html index.htm index.php;
        root  /home/kirk/github/Cicada/app-upload;
        rewrite . /index.php;
        location ~ .*\.(php|php5)?$ {
            fastcgi_pass   unix:/tmp/php-cgi.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME   $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
}
# 静态资源
server {
    listen 80;
    server_name static.huangkuankuan.cn;
    root /home/kirk/github/static
    limit_rate 512k;
}
```

## 框架思路

### 动静分离
将依赖少，几乎不更新的部分单独抽离，比如文件系统。

### 多层配置
项目的配置文件分为应用模块下的配置文件`app-admin/config`、公共配置文件`core/config`、开发者本地配置文件`根目录下的config`。各目录下的配置文件优先级：`根目录` 大于 `项目目录` 大于 `核心文件`。根目录下的配置文件单独拿出，适用于开发者在开发环境调试，（或者作为重要的配置文件单独配置）

### 业务逻辑
`bll`放到`core`的类文件中，各应用模块需要时调用即可。

### 自动生成
根目录下的`Tool.php`文件，辅助开发者快速建立相应的`控制器文件`、`视图文件`、`bll`、`dao`等等。如建立`app-home`目录下的`index`控制器和视图文件，在项目根目录执行命令`
php Tool.php create-page app-home Home\\Index HomeFrame`即可。

### 注意
`nginx`重写路由绝对不允许指向项目根目录，线上环境必须删除`Tool.php`。

## 参考列表

* RSF框架[https://github.com/suxianbaozi/RSF/]
