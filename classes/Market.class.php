<?php
class Market {
    function get_all() {
        $sql = "SELECT * FROM Market_TD";
        return (new Database)->select($sql);
    }

    function get_by( $where ) {
        $sql = "SELECT * FROM Market_TD WHERE $where";
        return (new Database)->select($sql);
    }
}