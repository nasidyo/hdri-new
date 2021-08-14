<?php
class MainBasin {
    function get_all() {
        $sql = "SELECT * FROM MainBasin";
        return (new Database)->select($sql);
    }
}