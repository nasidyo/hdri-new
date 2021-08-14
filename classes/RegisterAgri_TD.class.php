<?php
class RegisterAgri_TD {
    function get_all() {
        $sql = "SELECT * FROM RegisterAgri_TD AS ratd ";
        $sql.= "LEFT JOIN Person AS p ON (p.idPerson = ratd.idPerson) ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = ratd.idArea) ";
        $sql.= "LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ratd.idAgri) ";
        $sql.= "ORDER BY ratd.regisAgri_id DESC";
        return Database::select($sql);
    }

    function get_by_id( $id ) {
        $sql = "SELECT * FROM RegisterAgri_TD AS ratd ";
        $sql.= "LEFT JOIN Person AS p ON (p.idPerson = ratd.idPerson) ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = ratd.idArea) ";
        $sql.= "LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ratd.idAgri) ";
        $sql.= "WHERE regisAgri_id = ?";
        $params = array($id);
        return Database::select_with_params($sql, $params);
    }

    function get_persone_by_area( $idArea ) {
        $sql = "SELECT * FROM RegisterAgri_TD AS ratd ";
        $sql.= "LEFT JOIN Person AS p ON (p.idPerson = ratd.idPerson) ";
        $sql.= "WHERE ratd.idArea = {$idArea}";
        return Database::select($sql);
    }

    function insert( $params ) {
        $all = self::get_all();
        $regisAgri_id = array( ($all[0]['regisAgri_id'] + 1) );
        if( !$regisAgri_id ) {
            $regisAgri_id = 1;
        }
        $params = array_merge($regisAgri_id, $params);
        $fields = array('regisAgri_id', 'idPerson', 'idArea', 'idAgri', 'register_year');
        Database::insert('RegisterAgri_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('idPerson', 'idArea', 'idAgri', 'register_year');
        $where = 'regisAgri_id';
        Database::update('RegisterAgri_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        Database::delete('RegisterAgri_TD', 'regisAgri_id', $params);
    }
}