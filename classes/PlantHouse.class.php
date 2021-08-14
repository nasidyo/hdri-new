<?php
class PlantHouse {
    function get_all() {        
        $sql = 'SELECT * FROM PlantHouse_TD AS a ';
        $sql.= 'LEFT JOIN Area AS b ON (b.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Land_TD c ON (c.idLand = a.idLand) ';
        $sql.= 'ORDER BY a.plantHouse_Id DESC';
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM PlantHouse_TD AS a ';
        $sql.= 'LEFT JOIN Area AS b ON (b.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Land_TD c ON (c.idLand = a.idLand) ';
        $sql.= 'WHERE a.plantHouse_Id = ?';
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $plantHouse_Id = array( ($all[0]['plantHouse_Id'] + 1) );
        if( !$plantHouse_Id ) {
            $plantHouse_Id = 1;
        }
        $params = array_merge($plantHouse_Id, $params);
        $fields = array('plantHouse_Id', 'Area_idArea', 'idLand', 'houseNumber');
        Database::insert('PlantHouse_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('Area_idArea', 'idLand', 'houseNumber');
        $where = 'plantHouse_Id';
        Database::update('PlantHouse_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('PlantHouse_TD', 'plantHouse_Id', $params);
    }
}