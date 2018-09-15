<?php
//用户登录模块
class LoginController extends Controller {
	//显示用户登录界面
	public function loginAction(){
		include CUR_VIEW_PATH . "login.html";
	}
	//验证用户登录
	public function signinAction(){
		//1.获取表单数据
		$username = $_POST['username'];
		$username = addslashes($username);
		$password = md5($_POST['password']);
		//2.验证表单数据
		//首先检验验证码
		$captcha = trim($_POST['captcha']);
		if(strtolower($captcha) != $_SESSION['captcha']){
			$this->jump('index.php?p=admin&c=login&a=login','验证码错误');
		}
		//其次验证用户名密码
		if($username == '') {
			$this->jump('index.php?p=admin&c=login&a=login','用户名不能为空');
		}
		if($password == '') {
			$this->jump('index.php?p=admin&c=login&a=login','密码不能为空');
		}
		//3.调用模型完成对用户数据的检查，并给出提示信息
		$adminModel = new AdminModel('admin');
		$user = $adminModel->checkUser($username,$password);
		if(!empty($user)){
			//登录成功先保存标识符
			$_SESSION['admin'] = $user;
			$this->jump('index.php?p=admin&c=index&a=index','',0);
		}else{
			$this->jump('index.php?p=admin&c=login&a=login','用户名或密码错误');
		}
	}
	//退出登录
	public function logoutAction(){
		session_destroy();
		$this->jump('index.php?p=admin&c=login&a=login','',0);
	}
	//生成验证码
	public function captchaAction(){
		//导入工具包
		$this->library('captcha');
		//实例化对象
		$captcha = new captcha();
		//调用生成函数
		$captcha->generateCode();
		//保存到session中
		$_SESSION['captcha'] = $captcha->getCode();
	}
}
?>