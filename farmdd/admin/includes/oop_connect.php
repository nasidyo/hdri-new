<?php 
    class DbConnect {
        private $host = 'db01.hrdi.or.th';
        private $dbName = 'HRDI_Farmer';
        private $user = 'farmer';
        private $pass = 'F95uRw';
        
        public function connect() {
            try {
                $conn = new PDO('sqlsrv:Server='.$this->host. ';Database=' . $this->dbName, $this->user, $this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch(PDOException $e) {
                echo 'Databases Error: '. $e->getMessage();
            }
        }
    }
?>