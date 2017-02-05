CREATE TABLE `admin` (
  `admin_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin_name` varchar(20) NOT NULL COMMENT '姓名',
  `admin_username` varchar(20) NOT NULL COMMENT '用户名',
  `admin_password` varchar(48) NOT NULL COMMENT '密码',
  `admin_email` varchar(32) COMMENT '邮箱',
  `admin_department` varchar(20) NOT NULL COMMENT '部门',
  `admin_type` int(1) unsigned NOT NULL COMMENT '管理员类型',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20161 DEFAULT CHARSET=utf8 COMMENT='管理员';



CREATE TABLE `student` (
  `student_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '学生id',
  `student_xgz` int(1) unsigned NOT NULL COMMENT '学工组',
  `student_fdy` varchar(20) NOT NULL COMMENT '辅导员',
  `student_email` varchar(32) COMMENT '邮箱',
  `student_class` varchar(20) COMMENT '所属单位',
  `student_number` varchar(11) NOT NULL COMMENT '学号',
  `student_name` varchar(20) NOT NULL COMMENT '姓名',
  `student_type` int(1) unsigned COMMENT '学生类型',
  `student_password` varchar(48) NOT NULL COMMENT '密码',
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=205 DEFAULT CHARSET=utf8 COMMENT='学生';



CREATE TABLE `activity` (
  `activity_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `activity_sqdw` varchar(255) NOT NULL COMMENT '申请单位',
  `activity_sqr` varchar(255) NOT NULL COMMENT '申请人',
  `activity_tel` varchar(255) NOT NULL COMMENT '申请人电话',
  `activity_kssj` int(10) unsigned NOT NULL COMMENT '开始时间',
  `activity_jssj` int(10) unsigned NOT NULL COMMENT '结束时间',
  `address_id` int(10) unsigned NOT NULL,
  `activity_cjrs` varchar(255) NOT NULL COMMENT '参加人数',
  `activity_zzz` varchar(255) NOT NULL COMMENT '活动组织者',
  `activity_aqfzr` varchar(255) NOT NULL COMMENT '安全负责人',
  `activity_wsfzr` varchar(255) NOT NULL COMMENT '卫生负责人',
  `activity_nram` text NOT NULL COMMENT '活动内容和方案',
  `activity_aqya` text NOT NULL COMMENT '安全预案',
  `activity_fdyyj` varchar(255) COMMENT '辅导员意见',
  `activity_fdyname` varchar(255) COMMENT '辅导员姓名',
  `activity_fdysj` varchar(11) COMMENT '辅导员时间',
  `activity_fdysp` int(1) NOT NULL DEFAULT 0 COMMENT '标识辅导员审批是否通过',
  `activity_tzzyj` varchar(255) COMMENT '团总支意见',
  `activity_tzzname` varchar(255) COMMENT '团总支姓名',
  `activity_tzzsj` varchar(11) COMMENT '团总支时间',
  `activity_tzzsp` int(1) NOT NULL DEFAULT 0 COMMENT '标识团总支审批是否通过',
  `activity_bwbyj` varchar(255) COMMENT '保卫办意见',
  `activity_bwbname` varchar(255) COMMENT '保卫办姓名',
  `activity_bwbsj` varchar(11) COMMENT '保卫办时间',
  `activity_bwbsp` int(1) NOT NULL DEFAULT 0 COMMENT '标识保卫办审批是否通过',
  `activity_ldyj` varchar(255) COMMENT '领导意见',
  `activity_ldname` varchar(255) COMMENT '领导姓名',
  `activity_ldsj` varchar(11) COMMENT '领导时间',
  `activity_ldsp` int(1) NOT NULL DEFAULT 0 COMMENT '标识领导审批是否通过',
  `activity_zt` int(1) NOT NULL DEFAULT 0 COMMENT '状态',
  `activity_updatetime` varchar(11) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `activity_dateline` varchar(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`activity_id`),
  KEY `student_id` (`student_id`),
  KEY `address_id` (`address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

CREATE TABLE `address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address_name` varchar(255) NOT NULL COMMENT '活动地点',
  `address_lastclass` int(10) unsigned COMMENT '最多的班级数',
  `address_stutype` int(1) unsigned COMMENT '运行学生申请类型',
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  `event_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `event_connect` varchar(255) NOT NULL COMMENT '事件内容',
  `event_ip` varchar(15) NOT NULL COMMENT '事件ip',
  `event_time` varchar(11) NOT NULL COMMENT '事件时间',
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;


INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_username`, `admin_password`, `admin_email`, `admin_department`, `admin_type`) VALUES ('20161', '超级管理员', 'suseadmin', '021e5b2f8c65fc4d57ac64f41a0d8d5c', 'suseadmin', '管理员', '0');

