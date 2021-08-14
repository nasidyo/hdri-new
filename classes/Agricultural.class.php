<?php
class Agricultural {
    function get_all() {
        $sql = "SELECT * FROM Agri_TD AS agtd ";
        $sql.= "LEFT JOIN TypeOfStand AS tos ON (tos.idTypeOfStand = agtd.TypeOfStand_idTypeOfStand) ";
        $sql.= "LEFT JOIN TypeOfArgi_TD AS toa ON (toa.idTypeOfArgi = agtd.TypeOfArgi_idTypeOfArgi) ";
        $sql.= "LEFT JOIN GrowLocate_TD AS gltd ON (gltd.idGrowLocate = agtd.GrowLocate_idGrowLocate) ";
        $sql.= "LEFT JOIN CountUnit AS cu ON (cu.idCountUnit = agtd.unit_id) ";
        $sql.= "ORDER BY agtd.idAgri DESC";
        return (new Database)->select($sql);
    }

    function get_by_id( $id ) {
        $sql = "SELECT * FROM Agri_TD AS agtd ";
        $sql.= "LEFT JOIN TypeOfStand AS tos ON (tos.idTypeOfStand = agtd.TypeOfStand_idTypeOfStand) ";
        $sql.= "LEFT JOIN TypeOfArgi_TD AS toa ON (toa.idTypeOfArgi = agtd.TypeOfArgi_idTypeOfArgi) ";
        $sql.= "LEFT JOIN GrowLocate_TD AS gltd ON (gltd.idGrowLocate = agtd.GrowLocate_idGrowLocate) ";
        $sql.= "LEFT JOIN CountUnit AS cu ON (cu.idCountUnit = agtd.unit_id) ";
        $sql.= "WHERE idAgri = ?";
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function get_by_type( $idTypeOfArgi ) {
        $sql = "SELECT * FROM Agri_TD ";
        $sql.= "WHERE TypeOfArgi_idTypeOfArgi = {$idTypeOfArgi}";
        return (new Database)->select($sql);
    }

    function insert( $params ) {
        $all = self::get_all();
        $idAgri = array( ($all[0]['idAgri'] + 1) );
        if( !$idAgri ) {
            $idAgri = 1;
        }
        $params = array_merge($idAgri, $params);
        $fields = array('idAgri', 'nameArgi', 'TypeOfStand_idTypeOfStand', 'TypeOfArgi_idTypeOfArgi', 'GrowLocate_idGrowLocate', 'unit_id', 'speciesArgi');
        (new Database)->insert('Agri_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('nameArgi', 'TypeOfStand_idTypeOfStand', 'TypeOfArgi_idTypeOfArgi', 'GrowLocate_idGrowLocate', 'unit_id', 'speciesArgi');
        $where = 'idAgri';
        (new Database)->update('Agri_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete('Agri_TD', 'idAgri', $params);
    }
}