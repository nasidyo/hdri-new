<?php
class LandDetail {
    function get_all() {
        $sql = 'SELECT * FROM Land_Detail AS lta ';
        $sql.= 'LEFT JOIN Person_TD AS a ON (a.idPerson = lta.person_id) ';
        $sql.= 'ORDER BY lta.land_detail_id DESC';
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM Land_Detail AS lta ';
        $sql.= 'LEFT JOIN Person_TD AS a ON (a.idPerson = lta.person_id) ';
        $sql.= 'WHERE land_detail_id = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $land_detail_id = array( ($all[0]['land_detail_id'] + 1) );
        if( !$land_detail_id ) {
            $land_detail_id = 1;
        }
        $params = array_merge($land_detail_id, $params);
        $fields = array('land_detail_id', 'person_id', 'land_no', 'x', 'y', 'z', 'basin_quality_class', 'forest_area_classified', 'forest_type', 'forest_name', 'unit1', 'unit2', 'unit3', 'unit4');
        Database::insert('Land_Detail', $fields, $params);
    }

    function update( $params ) {
        $fields = array('person_id', 'land_no', 'x', 'y', 'z', 'basin_quality_class', 'forest_area_classified', 'forest_type', 'forest_name', 'unit1', 'unit2', 'unit3', 'unit4');
        $where = 'land_detail_id';
        Database::update('Land_Detail', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('Land_Detail', 'land_detail_id', $params);
    }
}