<?php
class Weather{

    public function __construct()
    {
        require("db.php");
        $this->mysql = new SaeMysql();
        $table = "CREATE TABLE IF NOT EXISTS`location` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL COMMENT '地点',
  `fromusername` varchar(255) DEFAULT NULL COMMENT '用户',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
        $this->mysql->query($table);
    }

    public function getWeather($n, $postObj)
    {
        $weatherurl="http://api.map.baidu.com/telematics/v2/weather?location={$n}&ak=1a3cde429f38434f1811a75e1a90310c";
        $apistr=file_get_contents($weatherurl);
        $apiobj=simplexml_load_string($apistr);
        $placeobj=$apiobj->currentCity;//当前城市
        $season = date("m");
        if($season == 3 || $season == 4 || $season == 5){
            $seasonpic = "http://119.29.101.95/public/images/spring.gif";
        }elseif($season == 6 || $season == 7 ||$season ==8){
            $seasonpic = "http://119.29.101.95/public/images/summer.gif";   
        }elseif($season == 9 ||$season == 10 ||$season == 11){
            $seasonpic = "http://119.29.101.95/public/images/autumn.gif";
        }elseif($season == 12 || $season == 1 ||$season == 2){
            $seasonpic = "http://119.29.101.95/public/images/winter.gif";
        }
        if(empty($placeobj))
        {
            $contentStr = "抱歉，没有查询到".$n."的天气信息";
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[text]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>1</FuncFlag>
                        </xml>";
            $resultStr = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $contentStr);
        }else{                
            $weatherobj1=$apiobj->results->result[0]->weather;//今天天气
            $windobj1=$apiobj->results->result[0]->wind;//今天风力
            $temobj1=$apiobj->results->result[0]->temperature;//今天气温
            $picobj1=$apiobj->results->result[0]->dayPictureUrl;//今天图片
            $weatherobj2=$apiobj->results->result[1]->weather;//明天天气
            $windobj2=$apiobj->results->result[1]->wind;//明天风力
            $temobj2=$apiobj->results->result[1]->temperature;//明天气温
            $picobj2=$apiobj->results->result[1]->dayPictureUrl;//明天图片
            $weatherobj3=$apiobj->results->result[2]->weather;//后天天气
            $windobj3=$apiobj->results->result[2]->wind;//后天风力
            $temobj3=$apiobj->results->result[2]->temperature;//后天气温
            $picobj3=$apiobj->results->result[2]->dayPictureUrl;//后天图片
            
            $weatherTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>4</ArticleCount>
                        <Articles>
                        <item>
                        <Title><![CDATA[%s]]></Title>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        </item>
                        <item>
                        <Title><![CDATA[%s]]></Title>             
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        </item>
                        <item>
                        <Title><![CDATA[%s]]></Title>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        </item>
                        <item>
                        <Title><![CDATA[%s]]></Title>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        </item>
                        </Articles>
                        <FuncFlag>1</FuncFlag>
                        </xml> ";
            $resultStr = sprintf($weatherTpl, $postObj->FromUserName, $postObj->ToUserName, time(), $n."天气信息", $seasonpic, "今天  ".$temobj1."\n".$weatherobj1."  ".$windobj1, $picobj1,"明天  ".$temobj2."\n".$weatherobj2."  ".$windobj2, $picobj2,"后天  ".$temobj3."\n".$weatherobj3."  ".$windobj3, $picobj3); 
        }
        return $resultStr;
    }

    public function getLocation($postObj){
        $fromusername = $postObj->FromUserName;        
        $sql = "SELECT  `location` FROM  `location` WHERE fromusername =  '{$fromusername}'";
        $data = $this->mysql->getOne($sql);
        if ($data)
        {
            return $data['location'];
        }else{
            return '0';
        }
    }

    public function newLocation($location,$postObj){
        $fromusername = $postObj->FromUserName;
        $sql = "SELECT  `location` FROM  `location` WHERE fromusername =  '{$fromusername}'";
        $data = $this->mysql->getAll($sql);
        if ($data)
        {
            $sql = "Update `location` set `location` = '{$location}' where `fromusername` = '{$fromusername}'";
            $this->mysql->query( $sql );
        }else{
            $sql = "Insert into `location`(`fromusername`, `location`) values('{$fromusername}', '{$location}')";
            $this->mysql->query( $sql );
        }
        $this->mysql->close();
    }
}
