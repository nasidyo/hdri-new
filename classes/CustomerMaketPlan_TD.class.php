<?php
class CustomerMaketPlan_TD {
    static function get_all() {        
        $sql = 'SELECT * FROM CustomerMaketPlan_TD AS a ';
        $sql.= 'LEFT JOIN Customer AS b ON (b.idCustomer = a.Customer_idCustomer) ';
        $sql.= 'LEFT JOIN Area c ON (c.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Agri_TD d ON (d.idAgri = a.Agri_idAgri) ';
        $sql.= 'LEFT JOIN CountUnit e ON (e.idCountUnit = a.unit_id) ';
        $sql.= 'LEFT JOIN TypeOfStand f ON (f.idTypeOfStand = a.TypeOfStand_idTypeOfStand) ';
        $sql.= 'LEFT JOIN Logistic_TD g ON (g.logistic_id = a.Logistic_idLogistic) ';
        $sql.= 'LEFT JOIN connection_status_TD h ON (h.conn_status_id = a.conn_status_id) ';
        $sql.= 'ORDER BY a.idCustomerMaketplan DESC';
        return (new Database)->select($sql);
    }

    static function get_by_id( $id ) {
        $sql = 'SELECT * FROM CustomerMaketPlan_TD AS a ';
        $sql.= 'LEFT JOIN Customer_TD AS b ON (b.idCustomer = a.Customer_idCustomer) ';
        $sql.= 'LEFT JOIN Area c ON (c.idArea = a.Area_idArea) ';
        $sql.= 'LEFT JOIN Agri_TD d ON (d.idAgri = a.Agri_idAgri) ';
        $sql.= 'LEFT JOIN CountUnit e ON (e.idCountUnit = a.unit_id) ';
        $sql.= 'LEFT JOIN TypeOfStand f ON (f.idTypeOfStand = a.TypeOfStand_idTypeOfStand) ';
        $sql.= 'LEFT JOIN Logistic_TD g ON (g.logistic_id = a.Logistic_idLogistic) ';
        $sql.= 'LEFT JOIN connection_status_TD h ON (h.conn_status_id = a.conn_status_id) ';
        $sql.= 'WHERE a.idCustomerMaketplan = ?';
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function insert( $params ) {
        $all = self::get_all();
        $idCustomerMaketplan = array( ($all[0]['idCustomerMaketplan'] + 1) );
        if( !$idCustomerMaketplan ) {
            $idCustomerMaketplan = 1;
        }
        $params = array_merge($idCustomerMaketplan, $params);
        $fields = array('idCustomerMaketplan', 'Customer_idCustomer', 'Area_idArea', 'plan_Year', 'Agri_idAgri', 'agri_weekplan_amount', 'unit_id', 
                        'agri_spect', 'TypeOfStand_idTypeOfStand', 'Logistic_idLogistic', 'Refund_period', 'conn_status_id', 'update_date');
        (new Database)->insert('CustomerMaketPlan_TD', $fields, $params);
    }

    function update( $params ) {
        $fields = array('Customer_idCustomer', 'Area_idArea', 'plan_Year', 'Agri_idAgri', 'agri_weekplan_amount', 'unit_id', 
                        'agri_spect', 'TypeOfStand_idTypeOfStand', 'Logistic_idLogistic', 'Refund_period', 'conn_status_id', 'update_date');
        $where = 'idCustomerMaketplan';
        (new Database)->update('CustomerMaketPlan_TD', $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete('CustomerMaketPlan_TD', 'idCustomerMaketplan', $params);
    }
}