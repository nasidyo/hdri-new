<?php
class CustomerMarket {
    function get_all() {        
        $sql = "SELECT * FROM CustomerMarket_TD AS cm ";
        $sql.= "LEFT JOIN Customer_TD AS c ON (c.idCustomer = cm.Customer_idCustomer) ";
        $sql.= "LEFT JOIN Market_TD AS m ON (m.idMarket = cm.Market_idMarket) ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = cm.Area_idArea) ";
        $sql.= "ORDER BY cm.idCustomerMarket DESC";
        return (new Database)->select($sql);
    }

    function get_by_id( $id ) {
        $sql = "SELECT * FROM CustomerMarket_TD AS cm ";
        $sql.= "LEFT JOIN Customer_TD AS c ON (c.idCustomer = cm.Customer_idCustomer) ";
        $sql.= "LEFT JOIN Market_TD AS m ON (m.idMarket = cm.Market_idMarket) ";
        $sql.= "LEFT JOIN Area AS a ON (a.idArea = cm.Area_idArea) ";
        $sql.= "WHERE idCustomerMarket = ?";
        $params = array($id);
        return (new Database)->select_with_params($sql, $params);
    }

    function insert( $params ) {
        $fields = array("Customer_idCustomer", "Market_idMarket", "Area_idArea");
        (new Database)->insert("CustomerMarket_TD", $fields, $params);
    }

    function update( $params ) {
        $fields = array("Customer_idCustomer", "Market_idMarket", "Area_idArea");
        $where = "idCustomerMarket";
        (new Database)->update("CustomerMarket_TD", $fields, $where, $params);
    }

    function delete( $params ) {
        (new Database)->delete("CustomerMarket_TD", "idCustomerMarket", $params);
    }

    function get_markets_by_area( $idArea ) {        
        $sql = "SELECT * FROM CustomerMarket_TD AS cm ";
        $sql.= "LEFT JOIN Market_TD AS m ON (m.idMarket = cm.Market_idMarket) ";
        $sql.= "WHERE cm.Area_idArea = $idArea";
        return (new Database)->select($sql);
    }

    function get_customers_by_market( $idMarket ) {        
        $sql = "SELECT * FROM CustomerMarket_TD AS cm ";
        $sql.= "LEFT JOIN Customer AS c ON (c.idCustomer = cm.Customer_idCustomer) ";
        $sql.= "WHERE cm.Market_idMarket = $idMarket";
        return (new Database)->select($sql);
    }
}