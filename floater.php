<?php
function getfloater($postObj)
{
    $Gn = $postObj->FromUserName;
    require_once('db.php');
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "SELECT * FROM  `Floater` ";
    $mysql->runSql($sql);
    $data = $mysql->getData( $sql );
    $line = count($data);
    if($line == 0){
        return "海面还空空荡荡哦，快扔一个吧~";
    }else{
    	$i = rand(1, $line);
        $sql = "SELECT * FROM `Floater` where `Id` = '{$i}'";
    	$mysql->runSql($sql);
    	$data = $mysql->getData( $sql );
        $sn = $data[0]["Sender"];
        $read = $data[0]["R"];
        if($sn == $Gn || $read == 1 || $read == '1')
        {
            return "没捡到哦，再捡一次吧~";
        }else{
    		$contentStr = $data[0]['Content'];
            $sql = "Update `Floater` Set `R` = '1' where `Id` = '{$i}'";
            $mysql->runSql($sql);
    		return $contentStr;
        }
    }
		if ($mysql->errno() != 0)
		{
			die("Error:" . $mysql->errmsg());
    	}
		$mysql->closeDb();
}

function setfloater($postObj, $contentStr)
{
    $fromusername = $postObj->FromUserName;
    require_once('db.php');
    $mysql = new SaeMysql('127.0.0.1', 'root', '384399002', 'weixin');
    $sql = "Insert into `Floater`(`Content`, `Sender`) values('{$contentStr}', '{$fromusername}')";
    $mysql->runSql($sql);
    if ($mysql->errno() != 0)
	{
		die("Error:" . $mysql->errmsg());
    }else{        
    	return 1;
    }
	$mysql->closeDb();
}
?>