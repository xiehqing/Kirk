use kirk;
-- 菜单表
create table `tb_home_menu`(
  `id` int unsigned auto_increment primary key ,
  `p_id` int unsigned not null default 0 comment '父级菜单id',
  `name` varchar(20) not null default '' comment '菜单名',
  `ename` varchar(20) not null default '' comment '英文菜单名',
  `url` varchar(255) not null default '#' comment '链接地址',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1不可用，2top左侧，3top右侧',
  `create_time` timestamp not null default current_timestamp,
--   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;

-- banner图表
create table `tb_home_banner`(
  `id` int unsigned auto_increment primary key ,
  `name` varchar(20) not null default '' comment 'banner图名',
  `url` varchar(255) not null default '' comment 'banner图url',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;

-- 标签表
create table `tb_home_tag`(
  `id` int unsigned auto_increment primary key ,
  `name` varchar(20) not null default '' comment '标签名',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;

-- 分类表
create table `tb_home_category`(
  `id` int unsigned auto_increment primary key ,
  `p_id` int unsigned not null default 0 comment '父级菜单id',
  `name` varchar(20) not null default '' comment '分类名',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;

-- 新闻表
CREATE TABLE `tb_home_news`(
	`id` int unsigned auto_increment primary key ,
	`title` varchar(100) not null default '' comment '标题',
	`site_url` varchar(255) not null default '' comment '新闻url',
	`image_url` varchar(255) not null default '' comment '图片url',
	`abs` varchar(255) not null default '' comment '简介',
	`content` varchar(2500) comment '获取的文本内容',
	`sort` int unsigned not null default 0 comment '排序',
	`status` int unsigned not null default 1 comment '状态：1待审，2可用',
	`create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;

-- 文章表
CREATE TABLE `tb_home_article`(
	`id` int unsigned auto_increment primary key ,
	`title` varchar(100) not null default '' comment '标题',
	`site_url` varchar(255) not null default '' comment '文章url',
	`image_url` varchar(255) not null default '' comment '图片url',
	`abs` varchar(255) not null default '' comment '简介',
	`content` TEXT comment '文章内容',
	`tag_id` varchar(100) not null default 0 comment '标签id使用英文","隔开',
	`category_id` varchar(100) not null default 0 comment '分类id使用英文","隔开',
	`sort` int unsigned not null default 0 comment '排序',
	`status` int unsigned not null default 1 comment '状态：1待审，2可用',
	`create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;

-- 相册表
CREATE TABLE `tb_home_photo`(
  `id` int unsigned auto_increment primary key ,
  `title` varchar(100) not null default '' comment '图片标题',
  `path` varchar(255) not null default '' comment '图片路径',
  `abs` varchar (255) not null default '' comment '图片简介',
  `content` varchar(2500) not null default '' comment '图片描述内容',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;
ALTER TABLE tb_home_photo COMMENT = 'Home-相册表';

-- 公告表
CREATE TABLE `tb_home_notice`(
  `id` int unsigned auto_increment primary key ,
  `title` varchar(100) not null default '' comment '公告标题',
  `url` varchar(255) not null default '' comment '公告路径(如果有跳转)',
  `abs` varchar (255) not null default '' comment '公告简介',
  `content` varchar(2500) not null default '' comment '公告描述内容',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;
ALTER TABLE tb_home_notice COMMENT = 'Home-公告表';

-- 友链表
CREATE TABLE `tb_home_friends`(
  `id` int unsigned auto_increment primary key ,
  `title` varchar(100) not null default '' comment '友链标题',
  `url` varchar(255) not null default '' comment '友链路径(如果有跳转)',
  `abs` varchar (255) not null default '' comment '友链简介',
  `content` varchar(2500) not null default '' comment '友链描述内容',
  `sort` int unsigned not null default 0 comment '排序',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;
ALTER TABLE tb_home_friends COMMENT = 'Home-友链表';

-- 联系方式
CREATE TABLE `tb_home_contact`(
	`id` int unsigned auto_increment primary key ,
	`title` varchar(100) not null default '' comment '标题',
	`content` TEXT comment '内容',
	`status` int unsigned not null default 1 comment '状态：1待审，2可用',
	`create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
)engine =InnoDB default charset =utf8;



-- 用户表
create table `tb_admin_user`(
  `id` int unsigned auto_increment primary key ,
  `name` varchar(40) not null comment '用户名' ,
  `passwd` varchar(32) not null comment '密码',
  `salt` varchar(6) not null comment '盐',
  `permission` int unsigned not null default 0 comment '操作权限',
  `permission_list` varchar(2500) not null comment '有操作权限的列表',
  `owner_permission` varchar(2500) not null comment '有操作权限的地区',
  `status` int unsigned not null default 1 comment '状态：1待审，2可用',
  `claim_time` datetime null comment '审核时间',
  `create_time` timestamp not null default current_timestamp,
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;


-- 访客行为分析表
create table `tb_log_action`(
  `id` int unsigned auto_increment primary key ,
  `user_id` varchar(11)  not null default '' comment '是登录的用户就获取用户ID，反之为空',
  `page_url` varchar(2500) not null comment '当前页面url',
  `p_page_url` varchar (2500) not null default '' comment '上级页面url，直接url来的就为空',
  `start_time` varchar (20) not null default '' comment '访问本页面的开始时间',
  `end_time` varchar (20) not null default '' comment '访问本页面的结束时间',
  `action` varchar (2500) not null default '' comment '访客行为，直接离开、访问下一页面或者返回上一页面',
  `vpn_ip` varchar(2500) not null default '' comment '开启了代理就获取所有跳板机的ip，json格式',
  `ip` varchar(50) not null comment '真实ip',
  `create_time` int not null comment '创建时间',
  --   `last_update_time` timestamp not null default current_timestamp on update current_timestamp
  `last_update_time` timestamp not null default current_timestamp
) engine =InnoDB default charset =utf8;