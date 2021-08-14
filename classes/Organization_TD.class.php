<?php
class Organization_TD {
    static function get_all() {        
        $sql = 'SELECT * FROM Organization_TD AS a ';
        $sql.= 'LEFT JOIN Area AS b ON (b.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Person_TD AS c ON (c.idPerson = a.person_id) ';
        $sql.= 'LEFT JOIN position_TD d ON (d.position_id = a.position_id) ';
        $sql.= 'ORDER BY a.organization_id DESC';
        return Database::select($sql);
    }

    static function get_by_id( $id ) {
        $sql = 'SELECT * FROM Organization_TD AS a ';
        $sql.= 'LEFT JOIN Area AS b ON (b.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Person_TD AS c ON (c.idPerson = a.person_id) ';
        $sql.= 'LEFT JOIN position_TD d ON (d.position_id = a.position_id) ';
        $sql.= 'WHERE a.organization_id = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $organization_id = array( ($all[0]['organization_id'] + 1) );
        if( !$organization_id ) {
            $organization_id = 1;
        }
        $params = array_merge($organization_id, $params);
        $fields = array('organization_id', 'Area_idArea', 'person_id', 'position_id', 'year');
        Database::insert('Organization_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('Area_idArea', 'person_id', 'position_id', 'year');
        $where = 'organization_id';
        Database::update('Organization_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('Organization_TD', 'organization_id', $params);
    }
}