<?php
class Customer {
    function get_all() {
        $sql = "SELECT * FROM Customer_TD";
        return (new Database)->select($sql);
    }
}