<?php
$nes = new News();
$obj = array("FromUserName" => "adgfa", "ToUserName" => "aewgfrg");
$res = $nes->getNews(json_decode(json_encode($obj)));
var_dump($res);
class News
{
	public function __construct()
	{
		$this->apikey = "032b47a738ebc74af3b7af660d81834a";
	}
	
	public function getNews($object)
	{
		$url = "http://apis.baidu.com/txapi/weixin/wxhot?num=5";
		$header = array("apikey:{$this->apikey}");
		$json = json_decode($this->curl_get($url,$header), true);
		$result = $this->responseNews($object, 5, $json["newslist"]);
		return $result;
	}
	
	//curl实现post请求
    function curl_get($url, $data)
    {
        //创建一个新cURL资源
        $curl = curl_init();
        //设置URL和相应的选项
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行curl，抓取URL并把它传递给浏览器
        $output = curl_exec($curl);
        //关闭cURL资源，并且释放系统资源
        curl_close($curl);
        return $output;
    }
	
	public function responseNews($object, $num, $array)
    {
        $xml = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>6</ArticleCount>
				<Articles>
				<item>
					<Title><![CDATA[新闻精选]]></Title>
					<Description><![CDATA[]]></Description>
					<PicUrl><![CDATA[]]></PicUrl>
					<Url><![CDATA[]]></Url>
				</item>";
		for($i = 0; $i < $num; $i ++){
			$xml .= "<item>
					<Title><![CDATA[{$array[$i]["title"]}]]></Title>
					<Description><![CDATA[{$array[$i]["description"]}]]></Description>
					<PicUrl><![CDATA[{$array[$i]["picUrl"]}]]></PicUrl>
					<Url><![CDATA[{$array[$i]["url"]}]]></Url>
				</item>";
		}		
		$xml .=	"</Articles>
				</xml>";
        $resultStr = sprintf($xml, $object->FromUserName, $object->ToUserName, time());
        return $resultStr;
    }
}