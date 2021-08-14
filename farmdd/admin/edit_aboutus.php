<?php include 'includes/header.php' ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueapp">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">แก้ไขเกี่ยวกับเรา</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="aboutus.php">จัดการเมนูเกี่ยวกับเรา</a></li>
                <li class="breadcrumb-item active">แก้ไขเกี่ยวกับเรา</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="co-lg-12 mx-auto">
          <!-- <form method="post" enctype="multipart/form-data"> -->
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-archive"></i></span>
              </div>
              <input type="text" name="title" class="form-control" placeholder="ชื่อเรื่อง" aria-label="Title" aria-describedby="basic-addon1" v-model="aboutContent.aboutTitle">
            </div>
          </div>

          <div class="form-group">
            <textarea name="editor1">
            {{ aboutContent.aboutBody }}
            </textarea>
          </div>

          <div class="form-group">
            <button @click="addContent()" class="btn btn-success btn-block">ยืนยัน</button>
          </div>
          <!-- </form> -->
        </div>
      </section>
      <!-- /.content -->
    </div>
    <?php include 'includes/footer.php' ?>
</body>
<script>
  var router = new VueRouter({
    mode: 'history',
    routes: []
  });

  var app = new Vue({
    el: '#vueapp',
    data: {
      isShowContentFirstPage: true,
      selectedFile: null,
      contentsType: [],
      contentFromId: {},
      aboutContent: {
        id: '',
        aboutTitle: '',
        aboutBody: null,
      },
    },
    mounted: function() {
      var url_string = window.location.href
      var urlS = new URL(url_string);
      var id = urlS.searchParams.get("id");
      axios.get(`api/aboutus/getAboutUsById.php?id=${id}`)
        .then((response) => {
          this.aboutContent = {
            id: response.data.aboutus[0].id,
            aboutTitle: response.data.aboutus[0].aboutTitle,
            aboutBody: response.data.aboutus[0].aboutBody,
          }
          console.log('getAboutUsById', this.aboutContent);
        }).then((res) => {

          CKEDITOR.replace('editor1');
          CKEDITOR.on('instanceReady', function(ev) {
            ev.editor.dataProcessor.htmlFilter.addRules({
              elements: {
                img: function(el) {
                  console.log(el);
                  el.addClass('img-responsive');

                  var style = el.attributes.style;

                  if (style) {
                    // Get the width from the style.
                    var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec(style),
                      width = match && match[1];

                    // Get the height from the style.
                    match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);
                    var height = match && match[1];

                    // Replace the width
                    if (width) {
                      el.attributes.style = el.attributes.style.replace(/(?:^|\s)width\s*:\s*(\d+)px;?/i, '');
                      el.attributes.width = width;
                    }

                    // Replace the height
                    if (height) {
                      el.attributes.style = el.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');
                      el.attributes.height = height;
                    }
                  }

                  // Remove the style tag if it is empty
                  if (!el.attributes.style)
                    delete el.attributes.style;
                }
              }
            });
          });
          CKEDITOR.on('dialogDefinition', function(e) {
            dialogName = e.data.name;
            dialogDefinition = e.data.definition;
            console.log(dialogDefinition);
            if (dialogName == 'image') {
              dialogDefinition.removeContents('Link');
              dialogDefinition.removeContents('advanced');
              var tabContent = dialogDefinition.getContents('info');
              tabContent.remove('');
            }
          });

        })
        .catch((error) => {
          console.log(error);
        });
    },

    methods: {
      getData() {
        console.log(this.$route.query);
      },
      isEmpty(str) {
        return (!str || str.length === 0);
      },
      errAlert(msg) {
        Swal.fire({
          icon: 'info',
          title: msg,
          showConfirmButton: true,
          allowOutsideClick: false,
        });
      },
      addContent() {
        console.log(this.content);
        this.aboutContent.aboutBody = CKEDITOR.instances.editor1.getData()

        if (this.isEmpty(this.aboutContent.aboutTitle)) {
          this.errAlert('กรุณากรอกหัวข้อ');
          return;
        }

        if (this.isEmpty(this.aboutContent.aboutBody)) {
          this.errAlert('กรุณากรอกเนื้อหา');
          return;
        }

        var formData = new FormData();
        formData.append('id', this.aboutContent.id)
        formData.append('aboutTitle', this.aboutContent.aboutTitle)
        formData.append('aboutBody', this.aboutContent.aboutBody)
        var contentForm = {};
        formData.forEach(function(value, key) {
          console.log(value);
          contentForm[key] = value;
        });

        axios({
            method: 'post',
            url: 'api/aboutus/postUpdateAboutus.php',
            data: formData,
            config: {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          })
          .then(function(response) {
            if (response.status = 201) {
              console.log(response);
              Swal.fire({
                icon: 'success',
                title: 'แก้ไขเนื้อหาสำเร็จ',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location = "edit_aboutus.php?id=1";
              })
            }
          })
          .catch(function(err) {
            console.log(err);
            if (err.status = 423) {
              Swal.fire({
                icon: 'error',
                title: 'มีรูปนี้อยู่แล้ว',
                showConfirmButton: true,
                allowOutsideClick: false,
              })
            }
          });
      }
    }
  })
</script>

</html>