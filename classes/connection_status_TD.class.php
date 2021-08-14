<?php
class connection_status_TD {
    function get_all() {
        $sql = "SELECT * FROM connection_status_TD AS a ";
        $sql.= 'ORDER BY a.conn_status_id DESC';
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM connection_status_TD AS a ';
        $sql.= 'WHERE a.conn_status_id = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $conn_status_id = array( ($all[0]['conn_status_id'] + 1) );
        if( !$conn_status_id ) {
            $conn_status_id = 1;
        }
        $params = array_merge($conn_status_id, $params);
        $fields = array('conn_status_id', 'conn_status_name');
        Database::insert('connection_status_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('conn_status_name');
        $where = 'conn_status_id';
        Database::update('connection_status_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('connection_status_TD', 'conn_status_id', $params);
    }
}