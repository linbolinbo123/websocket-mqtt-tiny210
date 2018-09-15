<?php
/**
* 后台首页控制器
*/
class IndexController extends BaseController
{
	
	public function indexAction()
	{
		//echo "admin.....index...";
		//载入视图
		include CUR_VIEW_PATH . "index.html";
	}

	public function topAction(){
		include CUR_VIEW_PATH . "top.html";
	}

	public function menuAction(){
		include CUR_VIEW_PATH . "menu.html";
	}

	public function dragAction(){
		include CUR_VIEW_PATH . "drag.html";
	}

	public function mainAction(){
		
		include CUR_VIEW_PATH . "main.html";
	}
	//生成验证码
	public function codeAction() {
		//引入验证码类
		$this->library('Captcha');
		//创建验证码对象
		$captcha = new Captcha();
		//调用方法
		$captcha->generateCode();
	}
}
?>