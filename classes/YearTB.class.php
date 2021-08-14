<?php
class YearTB {
    function get_all() {        
        $sql = 'SELECT * FROM YearTB AS a ';
        $sql.= 'ORDER BY a.idYearTB DESC';
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM YearTB AS a ';
        $sql.= 'WHERE a.idYearTB = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $fields = array('idYearTB', 'nameYear', 'dateStart', 'dateStop', 'defaultYear');
        Database::insert('YearTB', $fields, $params);
    }

    function update( $params ) {
        $fields = array('nameYear', 'dateStart', 'dateStop', 'defaultYear');
        $where = 'idYearTB';
        Database::update('YearTB', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('YearTB', 'idYearTB', $params);
    }
}