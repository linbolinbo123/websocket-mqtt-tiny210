<?php
	//核心启动类
	class Framework {
		//run方法
		public static function run() {
			//echo "hello,world";
			self::init();
			self::autoload();
			self::dispatch();
		}
		//初始化方法
		private static function init() {
			//路径常量
			define("DS", DIRECTORY_SEPARATOR);
			define("ROOT", getcwd() . DS);
			define("APP_PATH", ROOT . "application" . DS);
			define("FRAMEWORK_PATH", ROOT . "framework" . DS);
			define("PUBLIC_PATH", ROOT . "public" . DS);
			define("CONFIG_PATH", APP_PATH . "config" . DS);
			define("CONTROLLER_PATH", APP_PATH . "controllers" .DS);
			define("MODEL_PATH", APP_PATH . "models" . DS);
			define("VIEW_PATH", APP_PATH . "views" . DS);
			define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
			define("DB_PATH", FRAMEWORK_PATH . "databases" . DS);
			define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
			define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
			define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);

			define("PLATFORM", isset($_GET['p']) ? $_GET['p'] : "home");
			define("CONTROLLER", isset($_GET['c']) ? ucfirst($_GET['c']) : "Index");
			define("ACTION", isset($_GET['a']) ? $_GET['a'] : "index");
			define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
			define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);
			//加载核心类
			include CORE_PATH . "Controller.class.php";
			include CORE_PATH . "Model.class.php";
			//载入Mysql类
			include DB_PATH ."Mysql.class.php";
			//载入配置文件
			$GLOBALS['config'] = include CONFIG_PATH . "config.php";
			//开启SESSION
			session_start();
		}
		//路由分发,实例化对象调用方法
		private static function dispatch() {
			$controller_name = CONTROLLER . "Controller";
			$action_name = ACTION . "Action";
			//实例化对象
			$controller = new $controller_name();
			//调用方法
			$controller->$action_name();
		}
		//自动载入
		//此处只加载application中的controller和model
		private static function autoload() {
			spl_autoload_register(array(__CLASS__,'load'));
		}
		public static function load($classname){
			if(substr($classname, -10) == 'Controller'){
				//控制器
				include CUR_CONTROLLER_PATH . "{$classname}.class.php";
			}elseif (substr($classname, -5) == 'Model') {
				//模型
				include MODEL_PATH . "{$classname}.class.php";
			}else{
				//略
			}
		}
	}
?>