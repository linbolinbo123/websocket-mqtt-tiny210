<?php
//批量实体转义
function deepspecialchars($data){
	//写法一：
	/*
	if(is_array($data)) {
		//$data是数组，递归，并收集返回的值，形成一个新数组
		//写法一：
		foreach ($data as $key => $value) {
			$data[$key] = deepspecialchars($value);
		}
		return $data;
	}else {
		//单个变量
		return htmlspecialchars($data);
	}
	*/
	//写法二：array_map();
	return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
}
function deepslashes($data){
	return is_array($data) ? array_map('deepslashes', $data) : addslashes($data);
}
?>