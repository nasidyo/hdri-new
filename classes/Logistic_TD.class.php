<?php
class Logistic_TD {
    function get_all() {
        $sql = "SELECT * FROM Logistic_TD AS a ";
        $sql.= 'ORDER BY a.logistic_id DESC';
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM Logistic_TD AS a ';
        $sql.= 'WHERE a.logistic_id = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $logistic_id = array( ($all[0]['logistic_id'] + 1) );
        echo $logistic_id;
        if( !$logistic_id ) {
            $logistic_id = 1;
        }
        $params = array_merge($logistic_id, $params);
        $fields = array('logistic_id', 'logistic_name');
        Database::insert('Logistic_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('logistic_name');
        $where = 'logistic_id';
        Database::update('Logistic_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('Logistic_TD', 'logistic_id', $params);
    }
}