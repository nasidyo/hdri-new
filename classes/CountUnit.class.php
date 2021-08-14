<?php
class CountUnit {
    function get_all() {
        $sql = "SELECT * FROM CountUnit";
        return (new Database)->select($sql);
    }
}