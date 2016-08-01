<?php
function getGlobalNews($object)
{
    $xml = file_get_contents("http://rss.sina.com.cn/news/world/focus15.xml");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[0]->guid}\">".trim($result->channel->item[0]->title)."</a>";
    $news2 = "<a href=\"{$result->channel->item[1]->guid}\">".trim($result->channel->item[1]->title)."</a>";
    $news3 = "<a href=\"{$result->channel->item[2]->guid}\">".trim($result->channel->item[2]->title)."</a>";
    $news4 = "<a href=\"{$result->channel->item[3]->guid}\">".trim($result->channel->item[3]->title)."</a>";
    $news5 = "<a href=\"{$result->channel->item[4]->guid}\">".trim($result->channel->item[4]->title)."</a>";
    
    $textTpl = "<xml>
 				<ToUserName><![CDATA[%s]]></ToUserName>
 				<FromUserName><![CDATA[%s]]></FromUserName>
 				<CreateTime>%s</CreateTime>
 				<MsgType><![CDATA[text]]></MsgType>
 				<Content><![CDATA[%s]]></Content>
 				</xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "最新国际新闻：\n".$news1."\n\n".$news2."\n\n".$news3."\n\n".$news4."\n\n".$news5);    
    return $result;
}

function getHomeNews($object)
{
    $xml = file_get_contents("http://rss.sina.com.cn/news/society/focus15.xml");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[0]->guid}\">".trim($result->channel->item[0]->title)."</a>";
    $news2 = "<a href=\"{$result->channel->item[1]->guid}\">".trim($result->channel->item[1]->title)."</a>";
    $news3 = "<a href=\"{$result->channel->item[2]->guid}\">".trim($result->channel->item[2]->title)."</a>";
    $news4 = "<a href=\"{$result->channel->item[3]->guid}\">".trim($result->channel->item[3]->title)."</a>";
    $news5 = "<a href=\"{$result->channel->item[4]->guid}\">".trim($result->channel->item[4]->title)."</a>";
    
    $textTpl = "<xml>
 				<ToUserName><![CDATA[%s]]></ToUserName>
 				<FromUserName><![CDATA[%s]]></FromUserName>
 				<CreateTime>%s</CreateTime>
 				<MsgType><![CDATA[text]]></MsgType>
 				<Content><![CDATA[%s]]></Content>
 				</xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "最新国内新闻：\n".$news1."\n\n".$news2."\n\n".$news3."\n\n".$news4."\n\n".$news5);    
    return $result;
}

$xml = file_get_contents("http://rss.sina.com.cn/news/society/focus15.xml");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[0]->guid}\">".trim($result->channel->item[0]->title)."</a>";
	echo $news1;
function getNews($object)
{
    $xml = file_get_contents("http://language.chinadaily.com.cn/portal.php?mod=rss");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[1]->link}\">".trim($result->channel->item[1]->title)."</a>";
    $news2 = "<a href=\"{$result->channel->item[2]->link}\">".trim($result->channel->item[2]->title)."</a>";
    $news3 = "<a href=\"{$result->channel->item[3]->link}\">".trim($result->channel->item[3]->title)."</a>";
    $news4 = "<a href=\"{$result->channel->item[4]->link}\">".trim($result->channel->item[4]->title)."</a>";
    $news5 = "<a href=\"{$result->channel->item[5]->link}\">".trim($result->channel->item[5]->title)."</a>";
    
    $textTpl = "<xml>
 				<ToUserName><![CDATA[%s]]></ToUserName>
 				<FromUserName><![CDATA[%s]]></FromUserName>
 				<CreateTime>%s</CreateTime>
 				<MsgType><![CDATA[text]]></MsgType>
 				<Content><![CDATA[%s]]></Content>
 				</xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "最近新闻：\n".$news1."\n\n".$news2."\n\n".$news3."\n\n".$news4."\n\n".$news5);    
    return $result;
}

function getEnglish2($object)
{
    $xml = file_get_contents("http://www.msnbc.com/feeds/latest");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[0]->link}\">".trim($result->channel->item[0]->title)."</a>";
    $news2 = "<a href=\"{$result->channel->item[1]->link}\">".trim($result->channel->item[1]->title)."</a>";
    $news3 = "<a href=\"{$result->channel->item[2]->link}\">".trim($result->channel->item[2]->title)."</a>";
    $news4 = "<a href=\"{$result->channel->item[3]->link}\">".trim($result->channel->item[3]->title)."</a>";
    $news5 = "<a href=\"{$result->channel->item[4]->link}\">".trim($result->channel->item[4]->title)."</a>";
    
    $textTpl = "<xml>
 				<ToUserName><![CDATA[%s]]></ToUserName>
 				<FromUserName><![CDATA[%s]]></FromUserName>
 				<CreateTime>%s</CreateTime>
 				<MsgType><![CDATA[text]]></MsgType>
 				<Content><![CDATA[%s]]></Content>
 				</xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "最近新闻：\n".$news1."\n\n".$news2."\n\n".$news3."\n\n".$news4."\n\n".$news5);    
    return $result;
}

function getEnglish($object)
{
    $xml = file_get_contents("http://rssfeeds.usatoday.com/usatodaycomworld-topstories&x=1");
    $result = simplexml_load_string($xml);
    
    $news1 = "<a href=\"{$result->channel->item[0]->link}\">".trim($result->channel->item[0]->title)."</a>";
    $news2 = "<a href=\"{$result->channel->item[1]->link}\">".trim($result->channel->item[1]->title)."</a>";
    $news3 = "<a href=\"{$result->channel->item[2]->link}\">".trim($result->channel->item[2]->title)."</a>";
    $news4 = "<a href=\"{$result->channel->item[3]->link}\">".trim($result->channel->item[3]->title)."</a>";
    $news5 = "<a href=\"{$result->channel->item[4]->link}\">".trim($result->channel->item[4]->title)."</a>";
    
    $textTpl = "<xml>
 				<ToUserName><![CDATA[%s]]></ToUserName>
 				<FromUserName><![CDATA[%s]]></FromUserName>
 				<CreateTime>%s</CreateTime>
 				<MsgType><![CDATA[text]]></MsgType>
 				<Content><![CDATA[%s]]></Content>
 				</xml>";
    $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "From USA Today：\n1.".$news1."\n\n2.".$news2."\n\n3.".$news3."\n\n4.".$news4."\n\n5.".$news5);    
    return $result;
}

?>