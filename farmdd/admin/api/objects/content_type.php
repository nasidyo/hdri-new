<?php
class ContentType
{

  private $conn;
  private $table_name = "content_type_MK";

  public $id;
  public $ctype_title;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {

    $query = "SELECT * FROM " . $this->table_name . " ";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function readById()
  {

    $query = "SELECT * FROM " . $this->table_name . " WHERE ctype_title=:ctype_title";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":ctype_title", $this->id);

    $stmt->execute();

    return $stmt;
  }

  function create()
  {

    $query = "INSERT INTO
                " . $this->table_name . " (ctype_title)
            VALUES
                (?)";

    $params = array($this->ctype_title);

    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);

    if ($stmt->rowCount()) {
      return true;
    }

    return false;
  }

  function update()
  {

    // query to insert record
    $query = "UPDATE
                " . $this->table_name . "
            SET
            ctype_title= ? WHERE ctype_id= ?";
    $stmt = $this->conn->prepare($query);

    $params = array($this->ctype_title, $this->id);
    $stmt->execute($params);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function delete()
  {
    try {
      $query = "DELETE FROM " . $this->table_name . " WHERE ctype_id= ?";

      $stmt = $this->conn->prepare($query);

      $params = array($this->id);
      $stmt->execute($params);

      if ($stmt->execute()) {
        return true;
      }
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage() . '<br />';
      return false;
    }
  }
}
