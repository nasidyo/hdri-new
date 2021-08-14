<?php
class Person_TD {
    function get_all() {
        $sql = "SELECT * FROM Person_TD";
        return Database::select($sql);
    }

    function get_by_area( $idArea ) {
        $sql = "SELECT * FROM Person_TD ";
        $sql.= "WHERE Area_idArea = $idArea";
        return Database::select($sql);
    }
}