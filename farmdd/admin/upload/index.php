<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="dist/img/title_logo.png" type="image/png">
  <title>Upload Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="../ckeditor/ckeditor.js"></script>
</head>
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<body>
  <div class="container">
    <?php
    require 'files.php';
    $file = new files;
    if (isset($_POST['submit'])) {
      $file->setName($_FILES['file']['name']);
      $file->setType($_FILES['file']['type']);
      $file->setSize($_FILES['file']['size']);
      $file->setUploadedDate(date('d-m-y'));
      $loc = "img/" . $_FILES['file']['name'];
      if ($file->insert()) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $loc)) {
          echo "Photo Saved..!!!";
        } else {
          "Upload Failed..";
        }
      } else {
        echo "Insert Failed";
      }
    }
    ?>
    <div class="row">
      <div class="col-md-10 col-md-offset-1 mt-3">
        <h1>เลือกรูปภาพ</h1>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group ml-2">
          <label for="file">Select Files</label>
          <input type="file" id="file" name="file" />
          <p class="help-block">กรุณาเลือกรูปที่ต้องการอัพโหลด</p>
        </div>
        <div class="footer ml-2 mb-3">
          <button type="submit" name="submit" class="btn btn-primary">อัพโหลดรูปภาพ</button>
          <a href="?CKEditor=editor1&CKEditorFuncNum=3&langCode=en&action=delete" class="btn btn-danger">แสดงปุ่มลบรูปภาพ</a>
        </div>
      </form>
    </div>
    <div class="row">
      <?php
      $action = "";
      isset($_GET["action"]) ? $action = $_GET["action"] : $action = "";
      $images = $file->getAllImages();
      foreach ($images as $image) {
        echo '<div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-img-top text-center">
                                <a href="javascript:selectImage(\'' . $image['name'] . '\')"
                                class="thumbnail">
                                <img src="img/' . $image['name'] . '" width="250" height="250">
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">' . $image['name'] . '</h5>
                            </div>';
        if ($action == "delete") {
          echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-<?php echo ' . $image['id'] . ' ?>"><i class="fas fa-trash"></i></button>';
        }
        echo        '</div> 
                        </div>';
        echo '<div class="modal fade" id="exampleModal-<?php echo ' . $image['id'] . ' ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบข้อมูล</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ต้องการที่จะลบหรือไม่
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <a href="files_delete.php?id=' . $image['id'] . '" class="btn btn-danger">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>';
      }
      ?>
    </div>

  </div>
  <?php include '../includes/footer.php' ?>
</body>
<script type="text/javascript">
  var CKEditorFuncNum = "<?php echo $_REQUEST['CKEditorFuncNum']; ?>";
  console.log(CKEditorFuncNum);
  var url = "http://<?php echo $_SERVER['SERVER_NAME']; ?>farmdd/admin/upload/img/";
  console.log(url);
  function selectImage(imgName) {
    url += imgName;
    window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url);
    window.close();
  }
</script>

</html>