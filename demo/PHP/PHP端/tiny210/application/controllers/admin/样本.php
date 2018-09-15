<?php
//商品分类模块控制器
class CategoryController extends BaseController{
	//显示添加分类页面
	public function addAction(){
		//1.获取所有分类
		
		//2.加载页面
		include CUR_VIEW_PATH . "cat_add.html";
	}
	//分类入库方法
	public function insertAction(){
		//1.收集表单数据
		
		//导入辅助函数
		
		//2.验证和处理
		
		//3.调用模型，完成入库操作，并给出提示
		
	}
	//显示分类的方法
	public function indexAction(){
		//1.获取所有分类信息
		
		//2.载入视图
		include CUR_VIEW_PATH . "cat_list.html";
	}
	//显示修改分类页面
	public function editAction(){
		//1.获取cat_id,获取本条数据的内容
		
		//2.加载编辑页面
		include CUR_VIEW_PATH . "cat_edit.html";
	}
	//更新分类入库方法
	public function updateAction(){
		//1.获取表单数据
		
		//导入辅助函数
		
		//2.验证和处理
		
		//3.调用模型，进行更新操作，并提示
		
	}
	//删除分类方法
	public function deleteAction(){
		//1.获取要删除分类的id
		
		//2.调用模型，并判断删除的分类是有后代分类，若有便删除失败
		
		//3.调用模型，进行删除操作，并提示
		
	}
}
?>