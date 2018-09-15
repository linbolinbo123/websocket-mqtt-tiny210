<?php
$username = $_POST['username'];
$password = $_POST['password'];
// var_dump($username);
// var_dump($password);
// exit();
$db_host = "localhost";
$db_user = "root";
$db_pwd = "root";
$db_name = "yao";
$link = @mysql_connect($db_host,$db_user,$db_pwd);
// var_dump($link);
// exit();
if($link){
	if(mysql_select_db($db_name,$link)){
		mysql_query("set names utf8");
		$sql = "SELECT * FROM admin WHERE username='$username' AND password=$password";
		$result = mysql_query($sql);
		
		if($result) {
			header("location:One for all1.html");
		}else{
			header("location:tishi.html");

		}
	}else{
		exit('选择数据库失败');
	}
}else {
	exit('链接数据库失败');
}

?>