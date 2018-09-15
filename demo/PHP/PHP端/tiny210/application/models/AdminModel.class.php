<?php
//admin模型
class AdminModel extends Model {
	//验证用户名密码
	public function checkUser($username,$password){
		$sql = "SELECT * FROM {$this->table} WHERE admin_name='$username' AND 
		password='$password' LIMIT 1";
		return $this->db->getRow($sql);
	}
	//获取所用用户信息
	public function getAdmins(){
		$sql = "SELECT * FROM cz_admin";
		return $this->db->getAll("$sql");
	}
}
?>