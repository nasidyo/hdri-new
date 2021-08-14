<?php
class Person {
    function get_all() {
        $sql = "SELECT * FROM Person";
        return Database::select($sql);
    }
}