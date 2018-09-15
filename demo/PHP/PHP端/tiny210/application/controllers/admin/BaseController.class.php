<?php
//后台基础控制器
class BaseController extends Controller {
	//构造方法
	public function __construct() {
		$this->checkLogin();
	}
	//验证用户是否登录
	public function checkLogin(){
		if(!isset($_SESSION['admin'])) {
			$this->jump('index.php?p=admin&c=login&a=login','请先登录');
		}
	}
}
?>