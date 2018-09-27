**Read this in other languages: [中文](README.md).** 
# Kirk
A PHP Framework.

[Demo Site](http://huangkuankuan.cn)

refer by [RSF Framework](https://github.com/suxianbaozi/RSF/)

## Project Structure
```
======================================= Kirk =======================================
www(Project file under github document in my VPS)
|---kirk
|   |
|   |---app-admin           # Admin Module
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---index.php
|   |
|   |---app-api             # API Module
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---index.php
|   |
|   |---app-job             # Script Module
|   |   |---class
|   |   |   |---bin
|   |   |---config
|   |   |---run.php         # Active The Job
|   |
|   |---app-static          # Static Module
|   |   |---admin           # Store Admin Module' Ststic Files
|   |   |   |---css
|   |   |   |---js
|   |   |   |---fonts
|   |   |   |---images
|   |   |   |...
|   |   |
|   |   |---home
|   |   |...
|   |
|   |---core                # Core Module
|   |   |---class
|   |   |---config
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |
|   |---config              # Local Config Module
|   |   |---common.php
|   |   |---database.php
|   |   |---interceptor.php
|   |   |---pay.php
|   |   | ...
|   |
|   |---system              # System Module
|   |   |---class
|   |   |---ctrl
|   |   |---interceptor
|   |   |---plugin
|   |   |---view
|   |   |---functions.php   # System Common Functions
|   |   | ...
|   |
|   |---log                 # Log Files
|   |
|   |---vendor              # Vendor Package
|   |
|   |--- ...
|
|
|---... 
======================================= Kirk =======================================
```

## Deploy
config file named `kirk.conf` under `/etc/nginx`：

### Home Module
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

### Admin Module
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

### API Module
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

### Static File Module
If your project is heavy, you can chose anther VPS to deploy the static file module.
```
server {
    listen 80;
    server_name static.huangkuankuan.cn;
    index index.php index.html index.htm default.php;
    root /home/kirk/github/Cicada/app-static;
    limit_rate 512k;
}
```

## Notice

Can't direct to project's root document when setting rewrite route!
In development, you can run the `Tool.php` to build those files about `dao`、`bll`、`ctrl`、`view` etc... But in production, you must delete the file `Tool.php`.

## Refer List

* [RSF Framework](https://github.com/suxianbaozi/RSF/)
