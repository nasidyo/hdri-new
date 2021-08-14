<?php 

if(isset($_FILES['file']) and !$_FILES['file']['error']){
  move_uploaded_file($_FILES['file']['tmp_name'], realpath(dirname(__FILE__))."/" . $_POST['file_name']);
}