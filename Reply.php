<?php
class Reply
{

    public function __construct()
    {
        require("db.php");
        $this->mysql = new SaeMysql();
        $table = "CREATE TABLE IF NOT EXISTS `autoreply` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `KeytoWord` varchar(255) NOT NULL COMMENT '关键字',
  `KeytoAnswer` varchar(255) NOT NULL COMMENT '回复',
  `Committer` varchar(100) NOT NULL COMMENT '提交人',
  PRIMARY KEY (`id`,`KeytoWord`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;";
        $this->mysql->query($table);
    }

    public function getReply($keyword)
    {
        $sql = "SELECT  `KeytoAnswer` FROM  `autoreply` WHERE KeytoWord = '{$keyword}'";
        $data = $this->mysql->getAll($sql);
        if ($data) {
            $reply = $this->getInit($data[0]['KeytoAnswer']);
            return $reply;
        } else {
            return "0";
        }
    }

//修改与添加
    public function updateReply($object, $keyword)
    {
        $content1 = strstr($keyword, "@");
        $cLen1 = mb_strlen($content1, "UTF-8");
        $content2 = mb_substr($content1, 1, $cLen1 - 1, "UTF-8");
        $keytoword = strstr($content2, "@", true);
        $content3 = strstr($content2, "@");
        $cLen2 = mb_strlen($content3, "UTF-8");
        $keytoanswer = $this->getInit(mb_substr($content3, 1, $cLen2 - 1, "UTF-8"));
        $sql = "SELECT  `KeytoWord` FROM  `autoreply` WHERE KeytoWord =  '{$keytoword}'";
        $data = $this->mysql->getAll($sql);
        if ($data) {
            $name = $object->FromUserName;
            $sql = "Update `autoreply` Set `KeytoAnswer` = '{$keytoanswer}', `Committer` = '{$name}' where `KeytoWord` = '{$keytoword}'";
            $res = $this->mysql->query($sql);
            return array(
                "action" => 0,
                "result" => $res
            );
        } else {
            $name = $object->FromUserName;
            $sql = "Insert into `autoreply`(`Committer`, `KeytoWord`, `KeytoAnswer`) values('{$name}', '{$keytoword}', '{$keytoanswer}')";
            $res = $this->mysql->query($sql);
            return array(
                "action" => 1,
                "result" => $res
            );
        }
    }

    public function getInit($string)
    {//<a>标签链接解决方法
        $sLen = strlen($string);
        $newString = '';
        for ($i = 0; $i < $sLen; $i++) {
            if ($string[$i] == ' ' and $string[$i + 1] == ">") {
                $a = ">";
                $i++;
            } else {
                $a = $string[$i];
            }
            $newString = $newString . $a;
        }
        return $newString;
    }
}