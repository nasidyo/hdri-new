<?php
class GroupVillage {
    function get_all() {
        $sql = "SELECT * FROM GroupVillage";
        return (new Database)->select($sql);
    }

    function get_by_id($id) {
        $params = array($id);
        $sql = "SELECT * FROM GroupVillage WHERE idGroupVillage = ?";
        return (new Database)->select_with_params($sql, $params);
    }

    function get_by_area($idArea) {
        $sql = "SELECT * FROM GroupVillage WHERE idArea = {$idArea}";
        return (new Database)->select($sql);
    }
}