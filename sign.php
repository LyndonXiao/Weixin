<?php
function Lselect($postObj)
{
    $fromusername = $postObj->FromUserName;
	require_once('db.php');
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "SELECT  `location` FROM  `Location` WHERE fromusername =  '{$fromusername}'";
    $data = $mysql->getData( $sql );
    $line = count($data);
    if ($line > 0)
    {
        return $data[0]['location'];
    }else{
        return '0';
    }
	if ($mysql->errno() != 0)
	{
		die("Error:" . $mysql->errmsg());
    }
	$mysql->closeDb();
}

function Lupdate($postObj, $location)
{
	require_once('db.php');
    $fromusername = $postObj->FromUserName;
    $tousername = $postObj->ToUserName;
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "SELECT  `location` FROM  `Location` WHERE fromusername =  '{$fromusername}'";
    $data = $mysql->getData( $sql );
    $line = count($data);
	exit;
    if ($line > 0)
    {
        $sql = "update `Location` set `location` = '{$location}' where `fromusername` = '{$fromusername}'";
        $data = $mysql->getData( $sql );
    }else{
        $sql = "Insert into `Location`(`fromusername`, `tousername`, `location`) values('{$fromusername}', '{$tousername}', '{$location}')";
    	$data = $mysql->getData( $sql );
    }    
	if ($mysql->errno() != 0)
	{
		die("Error:" . $mysql->errmsg());
    }
	$mysql->closeDb();
}

function PwdChange($pwd)
{
    require_once('db.php');
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "update `Valid` set `pwd` = '{$pwd}'";
    $mysql->runSql($sql);
    $mysql->closeDb();
    return "密码修改为".$pwd;
}

?>