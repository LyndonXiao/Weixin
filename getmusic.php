<?php
function getmusic($object, $song, $singer)
    {
        $xml = file_get_contents("http://box.zhangmen.baidu.com/x?op=12&count=1&title=".$song."$$".$singer."$$$$");
        $result = simplexml_load_string($xml);
        if($result->count == 0)
        {
            $resultStr = "";
        }else{
        	$musicTpl ="<xml>
 				    	<ToUserName><![CDATA[%s]]></ToUserName>
 						<FromUserName><![CDATA[%s]]></FromUserName>
 						<CreateTime>123456</CreateTime>
 						<MsgType><![CDATA[music]]></MsgType>
 						<Music>
 						<Title><![CDATA[%s]]></Title>
 						<Description><![CDATA[%s]]></Description>
 						<MusicUrl><![CDATA[%s]]></MusicUrl>
 						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
 						</Music>
 						</xml>";
            if(strstr($result->durl[0]->decode,"&mid=") == false){
                $HQmusicUrl = mb_substr($result->durl[0]->encode,0,strrpos($result->durl[0]->encode,"/"),"UTF-8")."/".$result->durl[0]->decode;
            }else{
                $HQmusicUrl = mb_substr($result->durl[0]->encode,0,strrpos($result->durl[0]->encode,"/"),"UTF-8")."/".strstr($result->durl[0]->decode,'&mid=',true);
            }
            if(strstr($result->durl[0]->decode,"&mid=") == false){
                $musicUrl = mb_substr($result->url[0]->encode,0,strrpos($result->url[0]->encode,"/"),"UTF-8")."/".$result->url[0]->decode;
            }else{
                $musicUrl = mb_substr($result->url[0]->encode,0,strrpos($result->url[0]->encode,"/"),"UTF-8")."/".strstr($result->url[0]->decode,'&mid=',true);
            }        	
       		$resultStr = sprintf($musicTpl,$object->FromUserName, $object->ToUserName, $song, $singer,$musicUrl, $HQmusicUrl);
            //$resultStr = $musicUrl."\n".$HQmusicUrl;
        }
        return $resultStr;
    }
?>