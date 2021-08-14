<?php 

    class files {
        private $id;
        private $name;
        private $type;
        private $size;
        private $uploadedDate;
        public $dbConn;

        function setId($id) { $this->id = $id; }
        function getId() { return $this->id; }
        function setName($name) { $this->name = $name; }
        function getName() { return $this->name; }
        function setType($type) { $this->type = $type; }
        function getType() { return $this->type; }
        function setSize($size) { $this->size = $size; }
        function getSize() { return $this->size; }
        function setUploadedDate($uploadedDate) { $this->uploadedDate = $uploadedDate; }
        function getUploadedDate() { return $this->uploadedDate; }

        function __construct() {
            require '../includes/oop_connect.php';
            $db = new DbConnect;
            $this->dbConn = $db->connect();
        }

        public function insert() {
            $stmt = $this->dbConn->prepare("insert into files values(null, :name, :type, :size, :udate)");
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':size', $this->size);
            $stmt->bindParam(':udate', $this->uploadedDate);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getAllImages() {
            $query = "SELECT * FROM files";
            $stmt = $this->dbConn->prepare($query);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $images;
        }
    }

?>