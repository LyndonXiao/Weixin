<?php

class Message
{
    public function __construct()
    {
        require("db.php");
        $this->mysql = new SaeMysql();
        $table = "CREATE TABLE IF NOT EXISTS `message` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL COMMENT '内容',
  `fromusername` varchar(100) NOT NULL COMMENT '来自',
  `tousername` varchar(100) DEFAULT NULL COMMENT '发给',
  `createtime` varchar(100) NOT NULL COMMENT '创建时间',
  `status` int(9) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;";
        $this->mysql->query($table);
    }

    function getMessage($postObj)
    {
        $fromusername = $postObj->FromUserName;
        $sql = "SELECT `nickname` FROM  `user` WHERE `fromusername` = '{$fromusername}'";
        $user = $this->mysql->getOne($sql);
        if(!$user){//如果未注册昵称，则获取一条随机消息
            $sql = "SELECT * FROM  `message`";
            $data = $this->mysql->getAll($sql);
            if (!$data) {
                return "海面还空空荡荡哦，快扔一个吧~";
            } else {
                $id = rand(1, count($data));
                $sql = "SELECT `content`, `fromusername`, `createtime` FROM `message` where `id` = '{$id}'";
                $data = $this->mysql->getOne($sql);
                $status = $data["status"];
                if ($status == 0) {
                    return "没捞到哦，再捞一次试试~";
                } else {
                    $contentStr = "msg: ".$data['content']."\nfrom: ".$data['fromusername']."\ndate: ".date("Y-m-d",$data['createtime']);
                    $sql = "Update `message` Set `status` = 0 where `id` = '{$id}'";
                    $this->mysql->query($sql);
                    return $contentStr;
                }
            }
        }
        //已注册昵称，有限获取指定的信息，如无则获取随机信息
        $sql = "SELECT * FROM  `message` WHERE `tousername` = '{$user['nickname']}' and `status` = 1";
        $data = $this->mysql->getAll($sql);
        if (!$data) {
            $sql = "SELECT * FROM  `message`";
            $data = $this->mysql->getAll($sql);
            $id = rand(1, count($data));
            $sql = "SELECT * FROM `message` where `id` = '{$id}'";
            $data = $this->mysql->getOne($sql);
            $sn = $data['fromusername'];
            $status = $data["status"];
            if ($sn == $user['nickname'] || $status == 0) {
                return "没捞到哦，再捞一次试试~";
            } else {
                $contentStr = "msg: ".$data['content']."\nfrom: ".$data['fromusername']."\ndate: ".date("Y-m-d",$data['createtime']);
                $sql = "Update `message` Set `status` = 0 where `id` = '{$id}'";
                $this->mysql->query($sql);
                return $contentStr;
            }
        } else {
            $sql = "SELECT id, content, fromusername FROM `message` where `tousername` = '{$user['nickname']}' and `status` = 1";
            $data = $this->mysql->getAll($sql);
            $contentStr = "";
            foreach ($data as $key => $value){
                $contentStr .= "msg: ".$value['content']."\nfrom: ".$value['fromusername']."\ndate: ".date("Y-m-d",$value['createtime'])."\n------";
                $sqlStr = "Update `message` Set `status` = 0 where `id` = '{$value['id']}'";
                $this->mysql->query($sqlStr);
            }
            return $contentStr;
        }
    }

    function setMessage($postObj, $contentStr)
    {
        $fromusername = $postObj->FromUserName;
        $sql = "SELECT `nickname` FROM  `user` WHERE `fromusername` = '{$fromusername}'";
        $data = $this->mysql->getOne($sql);
        if(!$data){
            return "请先使用“我是XXX”注册昵称再投放漂流瓶";
        }
        $time = time();
        $fromusername = $data['nickname'];
        if(strstr(trim($contentStr),'@')){
            $content = strstr(trim($contentStr),'@',true);
            $tousername = mb_substr(strstr(trim($contentStr),'@'),1);
            $sql = "Insert into `message`(`content`, `createtime`,`fromusername`,`tousername`) values('{$content}','{$time}', '{$fromusername}','{$tousername}')";
            if($this->mysql->query($sql)){
                return "投放成功！";
            }
            return "貌似搁浅了。。。";
        }
        $sql = "Insert into `message`(`content`, `createtime`,`fromusername`) values('{$contentStr}','{$time}', '{$fromusername}')";
        if($this->mysql->query($sql)){
            return "投放成功！";
        }
        return "貌似搁浅了。。。";
    }
}