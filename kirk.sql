-- 菜单表
create table `tb_home_menu`(
  `menu_id` int unsigned auto_increment primary key ,
  `p_menu_id` int unsigned not null default 0 comment '父级菜单id',
  `menu_name` varchar(20) not null default '' comment '菜单名',
  `menu_url` varchar(255) not null default '#' comment '链接地址',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态：0不可用，1top左侧，2top右侧',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- banner图表
create table `tb_home_banner`(
  `banner_id` int unsigned auto_increment primary key ,
  `banner_name` varchar(20) not null default '' comment 'banner图名',
  `banner_url` varchar(255) not null default '' comment 'banner图url',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态：0待审，1可用',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 标签表
create table `tb_home_tag`(
  `tag_id` int unsigned auto_increment primary key ,
  `tag_name` varchar(20) not null default '' comment '标签名',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态：0待审，1可用',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 分类表
create table `tb_home_category`(
  `category_id` int unsigned auto_increment primary key ,
  `p_category_id` int unsigned not null default 0 comment '父级菜单id',
  `category_name` varchar(20) not null default '' comment '分类名',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态：0待审，1可用',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 新闻表
CREATE TABLE `tb_home_news`(
	`news_id` int unsigned auto_increment primary key ,
	`news_title` varchar(100) not null default '' comment '标题',
	`news_site_url` varchar(255) not null default '' comment '新闻url',
	`news_image_url` varchar(255) not null default '' comment '图片url',
	`news_abs` varchar(255) not null default '' comment '简介',
	`news_content` TEXT comment '获取的文本内容',
	`status` int unsigned not null default 0 comment '状态：0待审，1可用',
	`create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
)engine =InnoDB auto_increment=1 default charset =utf8;

-- 文章表
CREATE TABLE `tb_home_article`(
	`article_id` int unsigned auto_increment primary key ,
	`article_title` varchar(100) not null default '' comment '标题',
	`article_site_url` varchar(255) not null default '' comment '文章url',
	`article_image_url` varchar(255) not null default '' comment '图片url',
	`article_abs` varchar(255) not null default '' comment '简介',
	`article_content` TEXT comment '文章内容',
	`article_tag_id` varchar(100) not null default 0 comment '标签id使用英文","隔开',
	`article_category_id` varchar(100) not null default 0 comment '分类id使用英文","隔开',
	`status` int unsigned not null default 0 comment '状态：0待审，1可用',
	`create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
)engine =InnoDB auto_increment=1 default charset =utf8;

-- 用户表
create table `tb_admin_user`(
  `user_id` int unsigned auto_increment primary key ,
  `user_name` varchar(40) not null comment '用户名' ,
  `user_passwd` varchar(32) not null comment '密码',
  `salt` varchar(6) not null comment '盐',
  `permission` int unsigned not null default 0 comment '操作权限',
  `permission_list` varchar(2500) not null comment '有操作权限的列表',
  `owner_permission` varchar(2500) not null comment '有操作权限的地区',
  `status` int unsigned not null default 0 comment '状态：0待审，1可用',
  `claim_time` int not null default 0 comment '审核时间',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 用户日志表
create table `tb_admin_user_log`(
  `id` int unsigned auto_increment primary key ,
  `user_id` int unsigned not null ,
  `action` varchar(2500) not null comment '用户操作',
  `ip` varchar(50) not null comment 'ip',
  `create_time` int not null comment '创建时间',
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;