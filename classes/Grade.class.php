<?php
class Grade {
    function get_all() {
        $sql = "SELECT * FROM Grade";
        return (new Database)->select($sql);
    }
}