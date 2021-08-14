<?php
require 'includes.php';

if( isset( $_POST['action'] ) ) {
    $action = $_POST['action'];

    // if( 'selectMarketByArea' == $action ) {
    //     $str = '';
    //     $idArea = $_POST['idArea'];
    //     $results = CustomerMarket::get_markets_by_area( $idArea );
    //     print_r( $results );
    //     foreach( $results AS $row ) {
    //         $str.= '<option value="'.$row["idMarket"].'">'.$row["nameMarket"].'</option>';
    //     }
    //     die( Helper::dropdown_values( $results ) );
    // }
    // if( 'selectCustomerByMarket' == $action ) {
    //     $str = '';
    //     $idMarket = $_POST['idMarket'];
    //     $results = CustomerMarket::get_customers_by_market( $idMarket );
    //     print_r( $results );
    //     foreach( $results AS $row ) {
    //         $str.= '<option value="'.$row["idCustomer"].'">'.$row["c_name"].'</option>';
    //     }
    //     die( Helper::dropdown_values( $results ) );
    // }

    // if( 'selectPersonByArea' == $action ) {
    //     $str = '';
    //     $idArea = $_POST['idArea'];
    //     // $results = Person_TD::get_by_area( $idArea );
    //     $results = RegisterAgri_TD::get_persone_by_area( $idArea );
    //     foreach( $results AS $row ) {
    //         $str.= '<option value="'.$row["idPerson"].'">'.$row["firstName"].' '.$row["lastName"].'</option>';
    //     }
    //     die( $str );
    // }

    if( 'selectGroupVillageByArea' == $action ) {
        $str = '';
        $idArea = $_POST['idArea'];
        $results = GroupVillage::get_by_area( $idArea );
        foreach( $results AS $row ) {
            $str.= '<option value="'.$row["idGroupVillage"].'">'.$row["nameGroupVillage"].'</option>';
        }
        die( $str );
    }

    // if( 'selectAgriByType' == $action ) {
    //     $str = '';
    //     $idTypeOfArgi = $_POST['idTypeOfArgi'];
    //     $results = Agricultural::get_by_type( $idTypeOfArgi );
    //     foreach( $results AS $row ) {
    //         $str.= '<option value="'.$row["idAgri"].'">'.$row["nameArgi"].'</option>';
    //     }
    //     die( $str );
    // }
}