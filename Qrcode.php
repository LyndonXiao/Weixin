<?php
$qr = new Qrcode();
$access_token = $qr->getAccessToken();
echo $qr->getTemporaryQr($access_token, 600, "34185");
class Qrcode
{
	public function __construct()
	{
		$this->config = include("config.php");
		file_put_contents("1.txt","1\r\n");
	}
	
	public function getTemporaryQr($access_token, $expire_time, $scene_id)
	{
		$json = array(
			"expire_seconds" => $expire_time,
			"action_name" => "QR_SCENE",
			"action_info" => array("scene" => array("scene_id"=> $scene_id))
		);
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
		$res = json_decode($this->curl_post($url, json_encode($json)));
		$res = file_get_contents("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($res->ticket));
		return $res;
	}
	
	public function getPermanentQr($access_token)
	{
		
	}
	
	public function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->config["appKey"]."&secret=".$this->config["appSecret"];
        $data = json_decode(file_get_contents($url),true);
        if($data['access_token']){
            return $data['access_token'];
        }else{
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
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行curl，抓取URL并把它传递给浏览器
        $output = curl_exec($curl);
        //关闭cURL资源，并且释放系统资源
        curl_close($curl);
        var_dump($output);
        return $output;
    }
}