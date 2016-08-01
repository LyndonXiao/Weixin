<?php
function submitReport($postobj, $keyword){
    $fromusername = $postobj->FromUserName;
    $tousername = $postobj->ToUserName;
    $sdate = date('Y-m-d h:i:sa');
    $content1 = strstr($keyword,"#");
    $cLen1 = mb_strlen($content1, "UTF-8");
    $content2 = mb_substr($content1, 1, $cLen1 -1, "UTF-8");
    $location = strstr($content2, "#",true);
    $content3 = strstr($content2, "#");
    $cLen2 = mb_strlen($content3, "UTF-8");
    $phone = mb_substr($content3, 1, $cLen2 -1, "UTF-8");
    $mysql = new SaeMysql();
    $sql = "Insert into `repaire`(`fromusername`, `tousername`, `phone`,`location`,`sdate`) values('{$fromusername}', '{$tousername}','{$phone}', '{$location}','{$sdate}')";
    $mysql->runSql($sql);
    $sql = "Select `id`,`sdate` FROM  `repaire` WHERE fromusername =  '{$fromusername}' order by 'date' desc limit 1";
    $mysql->runSql($sql);
    $data = $mysql->getData( $sql );
    $id = $data[0]['id'];
    $sdate = $data[0]['sdate'];
    if ($mysql->errno() != 0)
	{
		$result = "Error:" . $mysql->errmsg();
    }else{
        $result = "报修成功，报修编号{$id}，请耐心等待工作人员的答复。";
    }
    return $result;
	$mysql->closeDb();
    $engineer = "";
    senmsg($engineer,"有新报修单，\n报修编号：{$id}，\n地址：{$location}，\n电话：{$phone}，\n提交时间：{$sdate}");
}

function sendmsg($openID, $content){
$appid = "wx928a85df40e36be5";//"wx40bbdef91ec028d5";
$appsecret = "6e774be9be08110c5ae41aa072d1f854";//"d7f40569f91630363acf790d2f7c228d";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);
$jsoninfo = json_decode($output, true);
$access_token = $jsoninfo["access_token"];

$jsonmenu = '{
    "touser":"'.$openID.'",
    "msgtype":"text",
    "text":
    {
         "content":"'.$content.'"
    }
}';


$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);
}