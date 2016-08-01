<?php

class User
{
    public function __construct()
    {
        require("db.php");
        $this->mysql = new SaeMysql();
        $table = "CREATE TABLE IF NOT EXISTS `user` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) NOT NULL COMMENT '昵称',
  `fromusername` varchar(255) NOT NULL COMMENT '用户标识',
  `createtime` varchar(100) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`,`fromusername`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;";
        $this->mysql->query($table);
    }

    public function newName($postObj, $name)
    {
        $fromusername = $postObj->FromUserName;
        $sql = "SELECT * FROM `user` WHERE `fromusername` = '{$fromusername}'";
        $data = $this->mysql->getAll($sql);
        if ($data) {
            $sql = "Update `user` Set `nickname` = '{$name}' where `fromusername` = '{$fromusername}'";
            if ($this->mysql->query($sql)) {
                return "你好~" . $name;
            } else {
                return "不好意思没听清。。更新出错";
            }
        }
        $sql = "SELECT * FROM `user` WHERE `nickname` = '{$name}'";
        $data = $this->mysql->getAll($sql);
        if ($data) {
            return "阿偶。。昵称已被使用啦";
        } else {
            $time = time();
            $sql = "Insert into `user`(`nickname`,`createtime`,`fromusername`) values('{$name}','{$time}','{$fromusername}')";
            if ($this->mysql->query($sql)) {
                return "你好~" . $name;
            } else {
                return "不好意思没听清。。插入出错";
            }
        }
    }
}