<?php
class Area {
    function get_all() {
        $sql = "SELECT * FROM Area WHERE target_area_type_id in (3,10,5) ";
        return (new Database)->select($sql);
    }
}