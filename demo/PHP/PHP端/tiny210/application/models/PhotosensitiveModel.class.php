<?php
//admin模型
class PhotosensitiveModel extends Model {
    //获取全部的数据
    function getPhotosensitives(){
        $sql = "SELECT * FROM {$this->table} ORDER BY time DESC LIMIT 8";
        return $this->db->getAll($sql);
    }
}
?>