 <?php
 include "phpMQTT.class.php";
 // 发送给订阅号信息,创建socket,无sam队列
 // $server = "10.34.185.193";     // 服务代理地址(mqtt服务端地址)
 // $port = 1883;                     // 通信端口
 // $username = "";                   // 用户名(如果需要)
 // $password = "";                   // 密码(如果需要
 // $client_id = "clientx9293670xxctr"; // 设置你的连接客户端id
 // $mqtt = new phpMqtt($server, $port, $client_id); //实例化MQTT类
 // if ($mqtt->connect(true, NULL, $username, $password)) { 
 //    //如果创建链接成功
 //     $mqtt->publish("nihao", "setr=3xxxxxxxxx", 0); 
 //     // 发送到 xxx3809293670ctr 的主题 一个信息 内容为 setr=3xxxxxxxxx Qos 为 0 
 //     $mqtt->close();    //发送后关闭链接
 //     echo "success!";
 // } else {
 //     echo "Time out!\n"; 
 // }

//链接数据库
function insertMysql($data) {
	//设置数据库参数
	$db_host = "localhost";
	$db_user = "root";
	$db_pwd = "root";
	$db_name = "light";
	$d = $data;
	// echo $d['photosensitive'];
	// exit();
	$photosensitive_value = $d['photosensitive'];
	$time_value = $d['time'];
	// echo $photosensitive_value,$time_value;
	// exit();
	//PHP链接MySQL服务器
	$link = @mysql_connect($db_host,$db_user,$db_pwd);
	if(!$link) {
		echo "链接数据库失败".mysql_error();
		exit();
	}
	if(mysql_select_db($db_name)) {
		mysql_query("set charset utf8");
		$sql = "insert into ts_photosensitive(photosensitive,time) values ($photosensitive_value,
			$time_value)";

		$result = mysql_query($sql,$link);
		if($result) {
			echo "insert success!";
		}
	}else {
		echo "选择数据库失败！";
	}
	mysql_close($link);
	// exit();
}



$server = "192.168.137.2";     // 服务代理地址(mqtt服务端地址)
$port = 1883;                     // 通信端口
$username = "";                   // 用户名(如果需要)
$password = "";                   // 密码(如果需要
$client_id = "clientx9293670xxctr"; // 设置你的连接客户端id

$mqtt = new phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) { //链接不成功再重复执行监听连接
    exit(1);
}

$topics['light'] = array("qos" => 0, "function" => "procmsg");
// 订阅主题为 SN69143809293670state qos为0



        //写一个死循环
while(1) {
	// 订阅主题为 data qos为0
    $mqtt->subscribe($topics, 0);
    //死循环监听
    while(!($msg = $mqtt->proc())){

    }
    //打印消息

    $data = handleMsg($msg);
    // echo $data['photosensitive'];
    // exit();
            
    insertMysql($data);

    $mqtt->close();
}






//对$msg进行处理
    function handleMsg($msg){
        
        //将字符串转换成数组形式
        //$res_temp = explode(',', $msg);
        $res_tmp = json_decode($msg, TRUE);
//        $res['node_num'] = $res_tmp['id'];
        $res['photosensitive'] = $res_tmp['photosensitive'];
        $res['time'] = time();
//        var_dump($res);
//        exit;
        return $res;
    }

// function procmsg($topic, $msg){ //信息回调函数 打印信息
//         echo "Msg Recieved: " . date("r") . "\n";
//         echo "Topic: {$topic}\n\n";
//         echo "\t$msg\n\n";
//         $xxx = json_decode($msg);
//         var_dump($xxxxxx->aa);
//         die;
// }