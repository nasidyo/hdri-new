<?php
class ListVillageLevel_TD {
    function get_all() {
        $sql = "SELECT * FROM list_vill_level_TD AS lvltd ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = lvltd.idArea) ";
        $sql.= "ORDER BY lvltd.list_vill_level_id DESC";
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = "SELECT * FROM list_vill_level_TD AS lvltd ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = lvltd.idArea) ";
        $sql.= "WHERE list_vill_level_id = ?";
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $list_vill_level_id = array( ($all[0]['list_vill_level_id'] + 1) );
        if( !$list_vill_level_id ) {
            $list_vill_level_id = 1;
        }
        $params = array_merge($list_vill_level_id, $params);
        $fields = array('list_vill_level_id', 'idArea', 'idGroupVillage', 'level');
        Database::insert('list_vill_level_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('idArea', 'idGroupVillage', 'level');
        $where = 'list_vill_level_id';
        Database::update('list_vill_level_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('list_vill_level_TD', 'list_vill_level_id', $params);
    }
}