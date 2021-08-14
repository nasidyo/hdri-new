<?php 
    $db_host = "localhost";
    $db_user = "tamtunon_fitnessplus";
    $db_password = "tatexty1425";
    $db_name = "tamtunon_fitnessplus";

    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Error ".$e->getMessage();
    }
?>