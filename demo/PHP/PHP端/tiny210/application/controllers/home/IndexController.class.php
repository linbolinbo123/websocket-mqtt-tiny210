<?php
//前台首页控制器
class IndexController {
	public function indexAction(){
		//获取所有分类
		$categoryModel = new CategoryModel('category');
		$cats = $categoryModel->frontCats();
		
		//获取推荐商品
		$goodModel = new GoodModel('goods');
		$goods = $goodModel->getBestGoods();
		// echo "<pre>";
		// var_dump($goods);
		// exit();
		include CUR_VIEW_PATH . "index.html";
	}
}

?>