<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "mijo");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

//$wechatObj->valid();

class wechatCallbackapiTest
{
    public function __construct()
    {
        require_once('Weather.php');
        require_once('Reply.php');
        require_once('Message.php');
        require_once('User.php');
        require_once('Music.php');
        require_once('News.php');
        $this->config = include("config.php");
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        file_put_contents("1.txt", $echoStr);
        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments

        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        //extract post data
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE) {
                case "text":
                    $resultStr = $this->handleText($postObj);
                    break;
                case "event":
                    $resultStr = $this->handleEvent($postObj);
                    break;
                case "image":
                    $resultStr = $this->handleImage($postObj);
                    break;
                default:
                    $resultStr = "Unknow msg type: " . $RX_TYPE;
                    break;
            }
            echo $resultStr;
        } else {
            echo "error";
            exit;
        }
    }

    public function handleText($postObj)
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            $keyword = trim($postObj->Content);
            if (!empty($keyword)) {
                $str_len = mb_strlen($keyword, "UTF-8");
                $str_key = mb_substr($keyword, 2, $str_len - 1, "UTF-8");
                $str = mb_substr($keyword, 0, 2, "UTF-8");
                $str2 = mb_substr($keyword, 0, 3, "UTF-8");
                $str_key2 = mb_substr($keyword, 3, $str_len - 1, "UTF-8");
                if ($str == '天气' && !empty($str_key)) {
                    $weather = new Weather($postObj);
                    $weather->newLocation(trim($str_key), $postObj);
                    $resultStr = $weather->getWeather(trim($str_key), $postObj);
                } elseif ($str2 == '添加@')//添加关键字回复
                {
                    $reply = new Reply();
                    $result = $reply->updateReply($postObj, $keyword);
                    if ($result['action'] == "0") {
                        if ($result['result']) {
                            $contentStr = "修改成功！";
                        } else {
                            $contentStr = "修改失败！";
                        }
                    } else {
                        if ($result['result']) {
                            $contentStr = "插入成功！";
                        } else {
                            $contentStr = "插入失败！";
                        }
                    }
                    $resultStr = $this->responseText($postObj, $contentStr);
                } elseif ($str2 == '报修#')//添加关键字回复
                {
                    require('getrepaired.php');
                    $result = submitReport($postObj, $keyword);
                    $resultStr = $this->responseText($postObj, $result);
                } elseif ($keyword == '随便听听')//随机播放音乐
                {
                    $music = new Music();
                    $res = $music->randomPlay();
//                    $media_id = $this->uploadTempImage($res['pic']);
                    $resultStr = $this->responseMusic($postObj, $res['title'], $res['author'], $res['url'], $media_id = '123456');
                } elseif ($str == '播放' && !empty($str_key))//播放音乐
                {
                    $music = new Music();
                    $res = $music->getMusic($str_key);
//                    $media_id = $this->uploadTempImage($res['pic']);
                    $resultStr = $this->responseMusic($postObj, $res['title'], $res['author'], $res['url'], $media_id = '123456');
                } elseif ($keyword == "天气") {
                    $weather = new Weather();
                    $result = $weather->getLocation($postObj);
                    if ($result == '0') {
                        $resultStr = $this->responseText($postObj, "请输入“天气地区“");
                    } else {
                        $resultStr = $weather->getWeather(trim($result), $postObj);
                    }
                } elseif ($str2 == '漂流瓶' && !empty($str_key2))//投放漂流瓶
                {
                    $contentStr = substr(strstr(trim($str_key2), '@'), 1);
                    $message = new Message();
                    $contentStr = $message->setMessage($postObj, $contentStr);
                    $resultStr = $this->responseText($postObj, $contentStr);
                } elseif ($str == '我是' || $str == '我叫' && !empty($str_key))//音乐
                {
                    $user = new User();
                    $contentStr = $user->newName($postObj, trim($str_key));
                    $resultStr = $this->responseText($postObj, $contentStr);
                } elseif ($keyword == "漂流瓶") {
                    $message = new Message();
                    $contentStr = $message->getMessage($postObj);
                    $resultStr = $this->responseText($postObj, $contentStr);
                } elseif ($keyword == "新闻") {
                    $news = new News();
                    $resultStr = $news->getNews($postObj);
                } else {
                    //关键字回复                
                    $reply = new Reply();
                    $contentStr = $reply->getReply($keyword);
                    if ($contentStr == "0") {
                        $contentStr = "您可以选择\n【1】试听音乐，回复“播放歌曲名”或“随便听听”，如“播放小苹果”；\n【2】查看天气情况，回复“天气城市”，如“天气杭州”。下次可直接回复“天气”即可查看上次地点天气；\n【3】查看新闻，回复“新闻”、“国内新闻”、“国际新闻”有不同惊喜；\n【4】漂流瓶，回复“漂流瓶”捡瓶子或“漂流瓶@你想说的话”，如“漂流瓶@我喜欢你！”来投放漂流瓶，会被别人捡到哦~";
                        $resultStr = $this->responseText($postObj, $contentStr);
                    } else {
                        $resultStr = $this->responseText($postObj, $contentStr);
                    }
                }
                return $resultStr;
            } else {
                return "Input something...";
            }

        } else {
            return "error";
        }
    }

    public function handleImage($postObj)
    {
        $resultStr = $this->responseText($postObj, "谢谢");
        return $resultStr;
    }

    public function handleEvent($object)
    {
        switch ($object->Event) {
            case "subscribe":
                $contentStr = "感谢你的关注！你可以试试以下功能：" . "\n" . "【1】天气查询，回复 天气+城市 如 天气杭州；" . "\n" . "【2】歌曲播放，回复 播放+歌曲名+@歌手 如播放小苹果@筷子兄弟 或 播放小苹果；\n【3】秒速新闻，回复 新闻或国内新闻、国际新闻。";
                break;
            default:
                $contentStr = "Unknow Event: " . $object->Event;
                break;
        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }

    public function responseText($object, $content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $resultStr;
    }

    public function responseNews($object, $title, $picurl, $url, $contentStr)
    {
        $picTpl = "<xml>
				   <ToUserName><![CDATA[%s]]></ToUserName>
				   <FromUserName><![CDATA[%s]]></FromUserName>
				   <CreateTime>%s</CreateTime>
				   <MsgType><![CDATA[news]]></MsgType>
				   <ArticleCount>1</ArticleCount>
				   <Articles>
				   <item>
				   <Title><![CDATA[%s]]></Title>
				   <Description><![CDATA[%s]]></Description>
				   <PicUrl><![CDATA[%s]]></PicUrl>
				   <Url><![CDATA[%s]]></Url>
				   </item>
				   </Articles>
				   </xml> ";
        $resultStr = sprintf($picTpl, $object->FromUserName, $object->ToUserName, time(), $title, $contentStr, $picurl, $url);
        return $resultStr;
    }

    public function responseMusic($object, $title, $author, $url, $media_id)
    {
        $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[music]]></MsgType>
                <Music>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <MusicUrl><![CDATA[%s]]></MusicUrl>
                <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                </Music>
                </xml>";
        $resultStr = sprintf($xml, $object->FromUserName, $object->ToUserName, time(), $title, $author, $url, $url);
        return $resultStr;
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadTempImage($img)
    {
        file_put_contents("1.jpg", file_get_contents($img));
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
        $file = array('media' => '@' . realpath("1.jpg"));
        $data = json_decode($this->curl_post($url, $file));
        return $data->media_id;
    }

    public function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->config["appKey"] . "&secret=" . $this->config["appSecret"];
        $data = json_decode(file_get_contents($url), true);
        if ($data['access_token']) {
            return $data['access_token'];
        } else {
            echo "Error";
            exit();
        }
    }

    //curl实现post请求
    function curl_post($url, $data)
    {
        //创建一个新cURL资源
        $curl = curl_init();
        //设置URL和相应的选项
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行curl，抓取URL并把它传递给浏览器
        $output = curl_exec($curl);
        //关闭cURL资源，并且释放系统资源
        curl_close($curl);
        return $output;
    }
}