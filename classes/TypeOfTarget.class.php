<?php
class TypeOfTarget {
    function get_all() {
        $sql = "SELECT * FROM TypeOfTarget";
        return (new Database)->select($sql);
    }
}