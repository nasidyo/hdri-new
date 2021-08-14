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
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
  <div class="container py-5" id="vue_upload">
    <!-- For demo purpose -->
    <header class="text-white text-center">
      <h1 class="display-4">เพิ่มรูปภาพ</h1>
      <img class="mt-2" src="https://res.cloudinary.com/mhmd/image/upload/v1564991372/image_pxlho1.svg" alt="" width="150" class="mb-4">
    </header>

    <div class="row py-4">
      <div class="col-lg-6 mx-auto">
        <!-- Upload image input-->
        <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
          <input id="upload" type="file" name="file" ref="file" @change="onFileChange" class="form-control border-0">
          <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label>
          <div class="input-group-append">
            <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
          </div>
        </div>
        <!-- Uploaded image area-->
        <div class="row text-center">
          <button class="btn btn-primary mx-auto" @click="uploadImage">Upload</button>
        </div>
        <div class="image-area mt-4"><img id="preview" v-if="url" :src="url" class="img-fluid rounded shadow-sm mx-auto d-block"></div>
      </div>
    </div>

    <div class="row align-items-center">
      <div class="col-md-4" v-for="item in images">
        <figure>
          <img @click=selectImage(item.name) class="img-fluid" :src="item.name" alt="item.name">
        </figure>
      </div>
    </div>
  </div>
  <script src="https://unpkg.com/vue@latest/dist/vue.js"></script>
  <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="https: //unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    var app = new Vue({
      el: '#vue_upload',
      data: {
        url: null,
        uploadData: null,
        images: [],
      },
      methods: {
        onFileChange(e) {
          const file = e.target.files[0];
          this.url = URL.createObjectURL(file);
          this.uploadData = e.target.files[0]
        },
        uploadImage() {
          console.log('Upload');
          var formData = new FormData();
          formData.append('uploadImg', this.uploadData);
          var contentForm = {};
          formData.forEach(function(value, key) {
            console.log(value);
            contentForm[key] = value;
          });
          axios({
              method: 'post',
              url: '../api/uploadFiles/postUploadImage.php',
              data: formData,
              config: {
                headers: {
                  'Content-Type': 'multipart/form-data'
                }
              }
            })
            .then(function(response) {
              console.log(response);
              if (response.status = 201) {
                Swal.fire({
                  icon: 'success',
                  title: 'อัพโหลดรูปสำเร็จ',
                  showConfirmButton: false,
                  timer: 1500
                }).then(() => {
                  window.location.reload();
                })
              }
            })
            .catch(function(err) {
              if (err.status = 423) {
                Swal.fire({
                  icon: 'error',
                  title: err.message,
                  showConfirmButton: true,
                  allowOutsideClick: false,
                })
              }
            });
        },
        getAllImage() {
          axios.get('../api/uploadFiles/getAllImage.php')
            .then((response) => {
              console.log(response);
              this.images = response.data.images;
              console.log(this.images);
            })
            .catch((error) => {
              console.log(error);
            });
        },
        getUrlParam(paramName) {
          var reParam = new RegExp('(?:[\?&]|&)' + paramName + '=([^&]+)', 'i');
          var match = window.location.search.match(reParam);

          return (match && match.length > 1) ? match[1] : null;
        },
        selectImage(imageName) {
          console.log(imageName);
          let funcNum = this.getUrlParam('CKEditorFuncNum');
          let path = "https://farmtd.hrdi.or.th/farmdd/admin/upload/"
          path += imageName;
          window.opener.CKEDITOR.tools.callFunction(funcNum, path);
          window.close();
        },
      }, // End Method
      created() {
        this.getAllImage();
      },
    })
  </script>
  <!-- <script type="text/javascript">
    var CKEditorFuncNum = "<?php // echo $_REQUEST['CKEditorFuncNum']; 
                            ?>";
    var url = "http://<?php // echo $_SERVER['SERVER_NAME']; 
                      ?>farmdd/admin/upload/img/";
    console.log(url);

    function selectImage(imgName) {
      url += imgName;
      window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, url);
      window.close();
    }
  </script> -->
</body>
<style>
  /*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*
*/
  figure {
    margin: 16px 40px !important;
  }

  .img-fluid {
    max-width: 100%;
    height: auto;
  }

  #upload {
    opacity: 0;
  }

  #upload-label {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
  }

  .image-area {
    border: 2px dashed rgba(255, 255, 255, 0.7);
    padding: 1rem;
    position: relative;
  }

  .image-area::before {
    content: 'Uploaded image result';
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.8rem;
    z-index: 1;
  }

  .image-area img {
    z-index: 2;
    position: relative;
  }

  /*
*
* ==========================================
* FOR DEMO PURPOSES
* ==========================================
*
*/
  body {
    min-height: 100vh;
    background-color: #757f9a;
    background-image: linear-gradient(147deg, #757f9a 0%, #d7dde8 100%);
  }
</style>

</html>