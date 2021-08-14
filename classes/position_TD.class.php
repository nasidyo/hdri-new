<?php
class position_TD {
    static function get_all() {        
        $sql = 'SELECT * FROM position_TD AS a ';
        $sql.= 'ORDER BY a.position_id DESC';
        return (new Database)->select($sql);
    }

    static function get_by_id( $id ) {
        $sql = 'SELECT * FROM position_TD AS a ';
        $sql.= 'WHERE a.position_id = ?';
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $position_id = array( ($all[0]['position_id'] + 1) );
        if( !$position_id ) {
            $position_id = 1;
        }
        $params = array_merge($position_id, $params);
        $fields = array('position_id', 'position_name');
        (new Database)->insert('position_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('position_name');
        $where = 'position_id';
        (new Database)->update('position_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete('position_TD', 'position_id', $params);
    }
}