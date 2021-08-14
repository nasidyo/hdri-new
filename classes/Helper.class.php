<?php
class Helper {
    function dropdown_values( $data ) {
        $str = '';
        foreach( $data AS $row ) {
            $str.= '<option value=""></option>';
        }
    }
}