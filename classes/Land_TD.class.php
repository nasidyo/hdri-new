<?php
class Land_TD {
    function get_all() {
        $sql = "SELECT * FROM Land_TD";
        return Database::select($sql);
    }
}