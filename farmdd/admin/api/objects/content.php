<?php
class Content
{

  // database connection and table name
  private $conn;
  private $table_name = "content_MK";

  // object properties
  public $id;
  public $content_title;
  public $content_writer;
  public $content_img;
  public $content_body;
  public $content_time;
  public $content_type;
  public $content_publish;
  public $content_firstpage;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  function read()
  {

    $query = "SELECT * FROM " . $this->table_name . " 
    INNER JOIN content_type_MK ON content_MK.content_type = content_type_MK.ctype_id ORDER BY content_id ASC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function getContentFirstPage()
  {

    $query = "SELECT * FROM " . $this->table_name . " INNER JOIN content_type_MK ON content_MK.content_type = content_type_MK.ctype_id 
    WHERE content_firstpage = 1 And content_publish = 1 ORDER BY content_id ASC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
  }

  function readById()
  {

    $query = "SELECT * FROM " . $this->table_name . " WHERE content_id=:content_id";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":content_id", $this->id);

    $stmt->execute();

    return $stmt;
  }

  function create()
  {

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
              (content_title, content_img, content_writer, content_body, 
              content_time, content_type, content_publish, content_firstpage)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?)";

    $params = array($this->content_title, $this->content_img, $this->content_writer,
    $this->content_body, $this->content_time, $this->content_type, $this->content_publish, $this->content_firstpage);

    $stmt = $this->conn->prepare($query);
    
    if ($stmt->execute($params)) {
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
                content_title= ?, content_img= ?, content_writer= ?, 
                content_type= ?, content_body= ?, content_time= ?,
                content_publish= ?, content_firstpage= ? WHERE content_id= ?";

    $stmt = $this->conn->prepare($query);

    $params = array($this->content_title, $this->content_img, $this->content_writer,
    $this->content_type, $this->content_body, $this->content_time,
    $this->content_publish, $this->content_firstpage, $this->id);
    $stmt->execute($params);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function delete() 
  {
    $query = "DELETE FROM " . $this->table_name. " WHERE content_id= ?";

    $stmt = $this->conn->prepare($query);

    $stmt = $this->conn->prepare($query);
    $params = array($this->id);
    $stmt->execute($params);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
