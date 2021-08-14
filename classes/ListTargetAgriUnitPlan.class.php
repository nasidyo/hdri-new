<?php
class ListTargetAgriUnitPlan {
    function get_all() {
        $sql = 'SELECT * FROM list_taget_agri_unit_plan AS lta ';
        $sql.= 'LEFT JOIN Agri_TD AS a ON (a.idAgri = lta.idAgri) ';
        $sql.= 'LEFT JOIN TypeOfTarget AS cu ON (cu.idTypeOfTarget = lta.taget_unit) ';
        $sql.= 'ORDER BY lta.unit_plan_id DESC';
        return (new Database)->select($sql);
    }

    function get_by_id( $id ) {
        $sql = 'SELECT * FROM list_taget_agri_unit_plan AS lta ';
        $sql.= 'LEFT JOIN Agri_TD AS a ON (a.idAgri = lta.idAgri) ';
        $sql.= 'LEFT JOIN TypeOfTarget AS cu ON (cu.idTypeOfTarget = lta.taget_unit) ';
        $sql.= 'WHERE unit_plan_id = ?';
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $unit_plan_id = array( ($all[0]['unit_plan_id'] + 1) );
        if( !$unit_plan_id ) {
            $unit_plan_id = 1;
        }
        $params = array_merge($unit_plan_id, $params);
        $fields = array('unit_plan_id', 'idAgri', 'taget_unit');
        (new Database)->insert('list_taget_agri_unit_plan', $fields, $params);
    }

    function update( $params ) {
        $fields = array('idAgri', 'taget_unit');
        $where = 'unit_plan_id';
        (new Database)->update('list_taget_agri_unit_plan', $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete('list_taget_agri_unit_plan', 'unit_plan_id', $params);
    }
}