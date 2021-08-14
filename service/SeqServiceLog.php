
<?php 
    Class SeqService {
        public function get($seq_name){
            $sql  ="SELECT  NEXT VALUE FOR ".$seq_name." as id   ";
       
            $seq=0;
         
            $db = new Database();
            $conn=  $db->getConnection();
            $stmt = sqlsrv_query($conn, $sql);
           
            if( $stmt === false) {
                die( print_r( sqlsrv_errors(), true) );
            }
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {  
                $seq=$row['id'];
               return $seq;
            }
            sqlsrv_close($conn);
         }
    }
?>