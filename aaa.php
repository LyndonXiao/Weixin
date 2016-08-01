<?php
if (isset($_POST['send'])) {
    $start = microtime_float();
    $color = $_POST['color'];
    $date = date('Y-m-d', time());
    $dates = explode('-', $date);
    $sy = array('1', '3', '5', '7', '8', '10', '12');
    $ss = array('4', '6', '9', '11');
    if (in_array($dates[1], $sy)) {
        $day = range($dates[2], 31);
    } elseif (in_array($dates[1], $ss)) {
        $day = range($dates[2], 30);
    } else {
        if (($dates[0] % 4 == 0 && $dates[0] % 100 != 0)
            || ($dates[0] % 100 == 0 && $dates[0] % 400 == 0)
        ) {
            $day = range($dates[2], 29);
        } else {
            $day = range($dates[2], 28);
        }
    }
    $i = 0;
    $content = '';
    foreach ($day as $value) {
        $content .= '<span style="color:' . $color[$i] . '">' . $value . '</span> ';
        $i++;
        if ($i > (count($color) - 1)) $i = 0;
    }
    echo $content;
    $end = microtime_float();
    echo "\n time:" . ($end - $start);
}

//if (isset($_POST['send'])) {
//    $start = microtime_float();
//    $color = $_POST['color'];
//    $date = date('Y-m-d', time());
//    $dates = explode('-', $date);
//    switch ($dates[1]) {
//        case 1 || 3 || 5 || 7 || 8 || 10 || 12:
//            $days = 31 - $dates[2];
//            break;
//        case 4 || 6 || 9 || 11:
//            $days = 30 - $dates[2];
//            break;
//        case 2:
//            if (($dates[0] % 4 == 0 && $dates[0] % 100 != 0) || ($dates[0] % 100 == 0 && $dates[0] % 400 == 0)) {
//                $days = 29 - $dates[2];
//            } else {
//                $days = 28 - $dates[2];
//            }
//            break;
//        default:
//            break;
//    }
//    $content = '';
//    $j = 0;
//    for ($i = 0; $i < $days; $i++) {
//        $content .= '<span style="color:' . $color[$j] . '">' . ($dates[2] + 1) . '</span> ';
//        ++$j;
//        if ($j > (count($color) - 1)) $j = 0;
//    }
//    echo $content;
//    $end = microtime_float();
//    echo "\ntime2:" . ($end - $start);
//}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

//$text = 'John ';
//$text[10] = 'Doe';
//var_dump(strlen($text));
//$arr = array(30,30,30,30,30,30,30,30,30,30);
//for($i =0;$i<10;$i++){
//    $content = "";
//    while($content !== file_get_contents("http://www.qlcoder.com/train/spider3/".($i+1)) && $arr[$i] !==0){
//        $arr[$i] -= 1;
//        $content = file_get_contents("http://www.qlcoder.com/train/spider3/".($i+1));
//        sleep($arr[$i]);
//    }
//}
//$arr = asort($arr);
//var_dump($arr);
//
// require 'Requests.php';
// Requests::register_autoloader();
//$headers = array("Content-type:multipart/formdata");
// $options = array();
//$body = array("msg" => "你妹啊","file" => "@".__DIR__.'\a.txt');
// $request = Requests::post('http://wx.mylxl.com/bbb.php', $headers, $body, $options);
// echo $request->body;
// 
// todo
// $x = 0;
// $m = "0";
// while(substr($m, 0,6) !== "000000"){
//     $m = md5(date("Ymd")."lxl384399002"."1".$x);
//     $x += 1;
// }
// echo date("Ymd")."lxl384399002"."1".$x."\n";
// echo $m."\n";
// echo $x;


//画圆
// $im = imagecreatetruecolor(1000,1000);//新建一个真彩色图像，默认背景是黑色，返回图像标识符。另外还有一个函数 imagecreate 已经不推荐使用。
// //2、绘制所需要的图像
// $red = imagecolorallocate($im,255,255,255);//创建一个颜色，以供使用
// $data = fopen("d.txt", "r");
// while(!feof($data)){
//  $line = fgets($data);
//  $s = explode(" ", $line);
//  imageellipse($im,intval($s[0]),intval($s[1]),5,5,$red);
// }
// //画一个圆。参数说明：30，30为圆形的中心坐标；40，40为宽和高，不一样时为椭圆；$red为圆形的颜色（框颜色）
// //3、输出图像
// header("content-type: image/png");
// imagepng($im,"666.png");//输出到页面。如果有第二个参数[,$filename],则表示保存图像
// //4、销毁图像，释放内存
// imagedestroy($im);


//遍历文件夹
// function listDir($dir,$size)
// {
//     if(is_dir($dir))
//     {
//         if ($dh = opendir($dir)) 
//         {
//             while (($file = readdir($dh)) !== false)
//             {
//                 if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
//                 {
//                     echo "<b><font color='red'>文件夹：</font></b>",$file,"<br />";
//                     listDir($dir."/".$file."/", $size);
//                 }
//                 else
//                 {
//                     if($file!="." && $file!="..")
//                     {
//                         if(filesize($dir."/".$file)>$size){
//                             $size = filesize($dir."/".$file);
//                             echo file_get_contents($dir."/".$file);
//                         }
//                     }
//                 }
//             }
//             closedir($dh);
//         }
//     }
// }
// //开始运行
// listDir("./root",0);


// $data = fopen("c.txt", "r");
// while(!feof($data)){
//  $line[] = fgets($data);
// }
// $count = 0;
// for ($i =0;$i<500;$i ++){
//     $s[] = $line[rand(0,500000000)];
// }
// for ($i =0;$i<500;$i ++){
//     $g[] = $line[rand(0,500000000)];
// }
// foreach ($g as $key => $value) {
//     if(in_array($value, $s)){
//         $count += 1;
//     }
// }
// $p = $count/500*500000000;
// var_dump($p);


//todo 新词发现
// $data = file_get_contents("santi.txt");
// $s = $data;
// $arr = array();
// $len = mb_strlen($data);
// for($i = 0;$i<($len-1);$i ++){
//     $w = trim(mb_substr($data, $i, 2));
//     if($w == ""){
//         continue;
//     }
//     $count = 0;
//     while($l = mb_strpos($s, $w)){
//         $s = mb_substr($s, $l, $len);
//         $count += 1;
//     }
//     $s = $data;
//     if($count > 100){
//         $arr[] = $w;
//     }
// }

// var_dump($arr);


//todo
// $count = 0;
// $data = fopen("c.txt", "r");
// while(!feof($data)){
// 	$line = fgets($data);
//     $count += 1;
// 	$s = explode(" ", $line);
// 	$x[] = floatval($s[0]);
// 	$y[] = floatval($s[1]);
// }
// $v1 = 0;
// $v2 = 0;
// $v3 = 0;
// $v4 = 0;
// for($i = 0; $i < $count; $i ++){
//     $v1 += $x[$i]^2;
//     $v2 += $y[$i];
//     $v3 += $x[$i];
//     $v4 += $x[$i]*$y[$i];
// }
// $c = ($v1*$v2-$v3*$v4)/($count*$v1-$v3^2);
// $b = -1;
// $a = ($count*$v4-$v3*$v2)/($count*$v1-$v3^2);
// echo "y=".$a."x+".$c;
// $d = 0;
// for($i = 0; $i < $count; $i ++){
//     $d += abs(($a * $x[$i] + $b * $y[$i] + $c)/sqrt($a^2 + $b^2));
// }
// echo "\n".$d;


//获取色彩rgb
// $i=imagecreatefromjpeg("61244.jpg");
// for ($x=0;$x<imagesx($i);$x++) {
//   for ($y=0;$y<imagesy($i);$y++) {
//     $rgb = imagecolorat($i,$x,$y);
//     $r=($rgb >>16) & 0xFF;
//     $g=($rgb >>8) & 0xFF;
//     $b=$rgb & 0xFF;
//     $rTotal += $r;
//     $gTotal += $g;
//     $bTotal += $b;
//     $total++;
//   }
// }
// $rAverage = round($rTotal/$total);
// $gAverage = round($gTotal/$total);
// $bAverage = round($bTotal/$total);
// //示例：
// echo $rAverage."-".$gAverage."-".$bAverage;


//正则匹配html标签
// $sum = array();
// for($i = 0; $i < 7; $i ++){
// 	$data = file_get_contents("https://movie.douban.com/top250?start=".($i*25)."&filter=");
// 	$preg = '/<span class="rating_num" property="v:average">(.*)<\/span>/';
// 	preg_match_all($preg, $data, $matchOne);
// 	foreach ($matchOne[1] as $key => $value) {
// 		$sum[]= ($value);
// 	}
// }
// $s = 0;
// for($i = 0; $i < 166; $i ++){
// 	$s += $sum[$i];
// }
// var_dump($s);
// 
// 
// 
// 
// $data = fopen("b.txt", "r");
// while(!feof($data)){
// 	$line = fgets($data);
// 	$b = explode(" ", $line);
// 	$left[] = intval($b[0]);
// 	$right[] = intval($b[1]);
// }

// foreach ($left as $key => $value) {
// 	$a[] = $value;
// 	while (!in_array($right[$key], $a)) {
// 		$a[] = $right[$key];
// 		$key = array_search($right[$key], $left);
// 	}
// }
// var_dump($a[0]);


// $i = 0;
// $j = 0;
// $b = array("price" => array(),"amount"=>array());
// $data = fopen("a.txt", "r");
// while(!feof($data)){
// 	$line = fgets($data);
// 	$a = explode(" ", $line);
// 	switch ($a[0]) {
// 		case 'up':
// 			if ($k = array_search(intval($a[2]), $b["price"])) {
// 				$b["amount"][$k] += intval($a[1]);
// 				break;
// 			}
// 			$b['price'][] = intval($a[2]);
// 			$b['amount'][] = intval($a[1]);
// 			break;
// 		case 'down':
// 			if ($k = array_search(intval($a[2]), $b["price"])) {
// 				$b["amount"][$k] -= intval($a[1]);
// 				break;
// 			}
// 			$b['price'][] = intval($a[2]);
// 			$b['amount'][] = intval($a[1]);
// 			break;
// 		case 'query':
// 			$j = 0;
// 			foreach ($b['price'] as $key => $value) {

// 				if($value >= intval($a[1]) && $value <= intval($a[2])){
// 					$j += $b['amount'][$key];
// 				}

// 			}
// 			$i += $j;
// 			break;
// 	}
// }

// var_dump(count($b['price']));
// var_dump(count($b['amount']));
// var_dump($i);

// $url = "http://www.qlcoder.com/task/4/solve";
// $data = json_encode(array("answer"=>"restful","_token"=>"4QUMV5tuLskiYFspl45IGgcI8wMbwhAmos81cpbY"));
// var_dump(curl_post($url,$data));
//curl实现post请求
	