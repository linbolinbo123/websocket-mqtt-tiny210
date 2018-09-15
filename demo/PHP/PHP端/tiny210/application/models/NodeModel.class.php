<?php
//admin模型
class NodeModel extends Model {
    //获取全部的数据
    function getTemps(){
        $sql = "SELECT id,photosensitive,time FROM {$this->table} ORDER BY time DESC LIMIT 10";
        return $this->db->getAll($sql);
    }
}
?>