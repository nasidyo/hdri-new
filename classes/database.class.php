<?php

class Database {
    function getConnection() {
        $conn =null;
        $connectionInfo = array("Database"                  => _DB_NAME_, 
                                "UID"                       => _DB_USER_, 
                                "PWD"                       => _DB_PASS_, 
                                "MultipleActiveResultSets"  => true,
                                "CharacterSet"              => "UTF-8");
        $conn = sqlsrv_connect( _DB_HOST_, $connectionInfo);
        return $conn;
    }

    static function select($sql) {
        $db = new Database();
        $conn=  $db->getConnection();
        
        // echo $sql;
        $stmt = sqlsrv_query( $conn, $sql );
        $data = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            array_push($data, $row);
        }
        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    echo "code: ".$error[ 'code']."<br />";
                    echo "message: ".$error[ 'message']."<br />";
                }
            }
        }
        sqlsrv_free_stmt( $stmt);
        return $data;
    }

    static function select_with_params( $sql, $params ) {
        $db = new Database();
        $conn=  $db->getConnection();
        
        $stmt = sqlsrv_query( $conn, $sql, $params );
        $data = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    echo "code: ".$error[ 'code']."<br />";
                    echo "message: ".$error[ 'message']."<br />";
                }
            }
        }
        sqlsrv_free_stmt( $stmt);
        return $data;
    }

    function insert( $table, $fields, $params ) {
        $db = new Database();
        $conn=  $db->getConnection();
        
        $values = '';
        for($i = 1; $i <= count($fields); $i++) {
            if( $i != count($fields) ) {
                $values.= '?, ';
            } else {
                $values.= '?';
            }
        }
        $fields = implode(",", $fields);
        $sql = "INSERT INTO {$table} ({$fields}) VALUES({$values})";
        $stmt = sqlsrv_query($conn, $sql, $params);
        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    echo "code: ".$error[ 'code']."<br />";
                    echo "message: ".$error[ 'message']."<br />";
                }
            }
        }
        sqlsrv_free_stmt( $stmt);
    }

    function update( $table, $fields, $where, $params ) {
        $db = new Database();
        $conn=  $db->getConnection();

        $fields_str = '';
        $i = 1;
        foreach($fields AS $field) {
            $fields_str.= $field.' = ?';
            if( $i != count($fields) ) {
                $fields_str.= ', ';
            }
            $i++;
        }
        $sql = "UPDATE {$table} SET {$fields_str} ";
        $sql.= "WHERE {$where} = ?";
        // echo $sql;
        // print_r( $params );
        $stmt = sqlsrv_query( $conn, $sql, $params );
        sqlsrv_free_stmt( $stmt);
    }

    function delete( $table, $where, $params ) {
        $db = new Database();
        $conn=  $db->getConnection();

        $sql = "DELETE FROM {$table} WHERE {$where} = ?";
        $stmt = sqlsrv_query( $conn, $sql, $params );
        sqlsrv_free_stmt( $stmt);
    }
}