<?php
class TypeOfArgi {
    function get_all() {
        $sql = "SELECT * FROM TypeOfArgi_TD";
        return (new Database)->select($sql);
    }
}