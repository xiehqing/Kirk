## app-api模块

### nginx配置
```
server {
	listen 80;
	server_name api.example.com;
	index index.php index.html index.htm;
	# 此处以我的Linux开发机路径为demo示例
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

### 调用方式
```
Demo：
http://api.kirk.com/v1/home?action=get_article_list
注解：
域名/版本号/相应板块?方法=方法名
```