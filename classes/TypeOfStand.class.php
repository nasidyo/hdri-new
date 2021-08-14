<?php
class TypeOfStand {
    function get_all() {
        $sql = "SELECT * FROM TypeOfStand";
        return Database::select($sql);
    }
}