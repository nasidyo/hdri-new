<?php
class GrowLocate_TD {
    function get_all() {
        $sql = "SELECT * FROM GrowLocate_TD";
        return (new Database)->select($sql);
    }
}