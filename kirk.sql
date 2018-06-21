-- 菜单表
create table `tb_home_menu`(
  `menu_id` int unsigned auto_increment primary key ,
  `p_menu_id` int unsigned not null default 0 comment '父级菜单id',
  `menu_name` varchar(20) not null default '' comment '菜单名',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- banner图表
create table `tb_home_banner`(
  `banner_id` int unsigned auto_increment primary key ,
  `banner_name` varchar(20) not null default '' comment 'banner图名',
  `banner_url` varchar(255) not null default '' comment 'banner图url',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 标签表
create table `tb_home_tag`(
  `tag_id` int unsigned auto_increment primary key ,
  `tag_name` varchar(20) not null default '' comment 'banner图名',
--   `banner_url` varchar(255) not null default '' comment 'banner图url',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态',
  `create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
) engine =InnoDB auto_increment=1 default charset =utf8;

-- 分类表
create table `tb_home_category`(
  `category_id` int unsigned auto_increment primary key ,
  `p_category_id` int unsigned not null default 0 comment '父级菜单id',
  `category_name` varchar(20) not null default '' comment '分类名',
  `list_order` int not null default 0 comment '排序',
  `status` int unsigned not null default 0 comment '状态',
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
	`create_time` timestamp not null default current_timestamp,
  `last_update_time` timestamp not null default current_timestamp on update current_timestamp
)engine =InnoDB auto_increment=1 default charset =utf8;