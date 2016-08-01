<?php

function getreply($keyword){
	
	require_once('db.php');
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "SELECT  `KeytoAnswer` FROM  `AutoReply` WHERE KeytoWord =  '{$keyword}'";
    $data = $mysql->getData( $sql );
    $line = count($data);
    if ($line > 0)
    {
        $reply = getinit($data[0]['KeytoAnswer']);
        return $reply;
    }else{
        return "0";
    }
	if ($mysql->errno != 0)
	{
		die("Error:" . $mysql->errmsg());
    }
	$mysql->closeDb();
}

//修改与添加
function updatereply($object, $keyword){
	require_once('db.php');
    $content1 = strstr($keyword,"@");
    $cLen1 = mb_strlen($content1, "UTF-8");
    $content2 = mb_substr($content1, 1, $cLen1 -1, "UTF-8");
    $keytoword = strstr($content2, "@",true);
    $content3 = strstr($content2, "@");
    $cLen2 = mb_strlen($content3, "UTF-8");
    $keytoanswer = getinit(mb_substr($content3, 1, $cLen2 -1, "UTF-8"));
    $mysql = new SaeMysql();
    $sql = "SELECT  `KeytoWord` FROM  `AutoReply` WHERE KeytoWord =  '{$keytoword}'";
    $mysql->runSql($sql);
    $data = $mysql->getData( $sql );
    $line = count($data);
    if ($line > 0)
    {
        $name = $object->FromUserName;
        $sql = "Update `AutoReply` Set `KeytoAnswer` = '{$keytoanswer}' where `KeytoWord` = '{$keytoword}'";
    	$mysql->runSql($sql);
        return "0";
    }else{
        $name = $object->FromUserName;
        $sql = "Insert into `AutoReply`(`Committer`, `KeytoWord`, `KeytoAnswer`) values('{$name}', '{$keytoword}', '{$keytoanswer}')";
    	$mysql->runSql($sql);
        return "1";
    }
	if ($mysql->errno() != 0)
	{
		die("Error:" . $mysql->errmsg());
    }
	$mysql->closeDb();
}

function getinit($string){//<a>标签链接解决方法
    $sLen = strlen($string);
    $newString = '';
    for($i =0; $i < $sLen; $i ++){
        if($string[$i] == ' ' and $string[$i+1] == ">")
        {
            $a = ">";
            $i ++;
        }else
        {
            $a = $string[$i];
        }
        $newString = $newString.$a;
    }
    return $newString;
}

?>