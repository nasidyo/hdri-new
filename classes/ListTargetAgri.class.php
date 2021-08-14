<?php
class ListTargetAgri {
    function get_all() {
        $sql = 'SELECT * FROM list_taget_agri AS ltag ';
        $sql.= 'LEFT JOIN Area AS a ON (a.idArea = ltag.area_id) ';
        $sql.= 'LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ltag.agri_id) ';
        $sql.= 'LEFT JOIN TypeOfArgi AS toa ON (toa.idTypeOfArgi = ltag.TypeOfArgi_idTypeOfArgi) ';
        $sql.= 'LEFT JOIN Grade AS g ON (g.idGrade = ltag.grade) ';
        $sql.= 'ORDER BY ltag.list_taget_agri_id DESC';
        return (new Database)->select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM list_taget_agri AS ltag ';
        $sql.= 'LEFT JOIN Area AS a ON (a.idArea = ltag.area_id) ';
        $sql.= 'LEFT JOIN Agri_TD AS agtd ON (agtd.idAgri = ltag.agri_id) ';
        $sql.= 'LEFT JOIN TypeOfArgi AS toa ON (toa.idTypeOfArgi = ltag.TypeOfArgi_idTypeOfArgi) ';
        $sql.= 'LEFT JOIN Grade AS g ON (g.idGrade = ltag.grade) ';
        $sql.= 'WHERE list_taget_agri_id = ?';
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $list_taget_agri_id = array( ($all[0]['list_taget_agri_id'] + 1) );
        if( !$list_taget_agri_id ) {
            $list_taget_agri_id = 1;
        }
        $params = array_merge($list_taget_agri_id, $params);
        $fields = array('list_taget_agri_id', 'area_id', 'agri_id', 'TypeOfArgi_idTypeOfArgi', 'grade');
        (new Database)->insert('list_taget_agri', $fields, $params);
    }

    function update( $params ) {
        $fields = array('area_id', 'agri_id', 'TypeOfArgi_idTypeOfArgi', 'grade');
        $where = 'list_taget_agri_id';
        (new Database)->update('list_taget_agri', $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete('list_taget_agri', 'list_taget_agri_id', $params);
    }
}