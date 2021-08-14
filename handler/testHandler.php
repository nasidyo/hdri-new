<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST)){

      var_dump($_FILES["fileToUpload"]);
       /* if(isset($_FILES["fileToUpload"]["type"])){
            $pathImage='../img/Activity';
            $allowTypes = array('jpg','png','jpeg','gif');
            $images_arr = array();
            $temp = $_FILES["fileToUpload"]["name"];
            $newfilename =  'test_'.$temp;
            $targetFilePath = $pathImage."/".$newfilename;
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFilePath);

        }*/
    }
}
?>
