# Kirk
自己琢磨的一套框架。

## 框架运行流程：
1. 入口文件(具体项目目录下)
2. 定义常量（框架所带的目录或者是函数库、第三方类库所带的目录）
3. 引入函数库
4. 定义核心文件
5. 定义配置文件（注意各目录下配置文件的优先级，项目目录《 核心文件《 根目录 ）
4. 自动加载类（自动加载一些文件，框架类、请求类等等）
5. 启动框架

# 框架修改方向大纲 V2.0
* 由根目录下单入口改为各应用目录下入口
* 模型层不再使用Medoo依赖包，放到core目录下统一管理

## 改动后框架目录结构
```
-Kirk
|---app-A  #应用A（同理可部署项目B、C、D...）
|   |---class           # 类文件
|   |---config          # 项目内配置文件
|   |---ctrl            # 控制器
|   |---interceptor     # 拦截器
|   |---plugin          # 视图插件
|   |---view            # 视图文件
|   |---index.php       # 项目A的入口文件
|
|---core    # 核心文件
|   |---class           # 通用的类文件
|   |---config          # 通用配置文件
|   |---ctrl            # 通用的控制器
|   |---interceptor     # 通用的拦截器
|   |---plugin          # 通用的视图插件
|   |---view            # 通用的视图文件
|
|---config  # 本地配置文件（开发者本地部署）
|   |---common.php
|   |---database.php
|   |---interceptor.php
|   |---pay.php
|   | ...
|
|---system  # 系统文件
|   |---class
|   |---ctrl
|   |---interceptor
|   |---plugin
|   |---view
|   |---functions.php   # 系统方法
|   | ...
|
|---log                 #日志文件
|
|---vendor              #外部依赖包
|
|--- ...
```
## Kirk V1.0 
* 采用的单入口文件（根目录下）
* 配置文件统一在/config目录下(根目录下)
* Model模型采用Medoo依赖包，通过composer安装管理

## Kirk V2.0 
借鉴了RSF框架[https://github.com/suxianbaozi/RSF/]
* 多应用模式，直接在nginx中重写路由指向对应的应用目录
```
server {
        listen  80;
        server_name domain.com;
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
其他应用部署同理。
* 多层配置，各目录下的配置文件优先级，项目目录 大于 核心文件 大于 根目录，根目录下的配置文件单独拿出，适用于开发者在开发环境调试，（或者作为重要的配置文件单独配置）

* model分割到core的类文件中
* 根目录下的Tool.php文件，辅助开发者快速建立相应的文件目录、Model等等。如建立app-home目录下的index控制器和视图文件，
```
php Tool.php create-page app-home Home\\Index HomeFrameView
```
注意，nginx重写路由绝对不允许指向根目录，线上环境必须删除Tool.php



修改于2018.06.01，儿童节快乐。
