<?php 
require_once('../includes/connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $select_stmt = $db->prepare('SELECT * FROM files WHERE id = :id');
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    chmod("img/" . $row["name"], 755);
    unlink("img/" . $row['name']);

    $delete_stmt = $db->prepare('DELETE FROM files WHERE id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();

    header("Location: index.php?CKEditor=editor1&CKEditorFuncNum=3&langCode=en");
}
?>