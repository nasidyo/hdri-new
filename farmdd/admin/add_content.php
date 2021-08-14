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
              <h1 class="m-0 text-dark">เพิ่มเนื้อหา</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item"><a href="content.php">จัดการเนื้อหา</a></li>
                <li class="breadcrumb-item active">เพิ่มเนื้อหา</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="col-md-9 mx-auto">
          <!-- <form method="post" enctype="multipart/form-data"> -->
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-archive"></i></span>
              </div>
              <input type="text" name="title" class="form-control" placeholder="ชื่อเรื่อง" aria-label="Title" aria-describedby="basic-addon1" v-model="content.contentTitle">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
              </div>
              <input v-model="content.contentWriter" type="text" name="author" class="form-control" placeholder="ผู้เขียน" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
          <div class="form-group mb-1">
            <label for="selectType">ประเภทบทความ</label>
          </div>
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-folder-open"></i></span>
              </div>
              <select class="form-control" id="selectType" @change="selectTypeChange($event.target.value)">
                <option v-for="item in contentsType" :value="item.cTypeId" selected> {{ item.cTypeTitle }}</option>
              </select>
            </div>
          </div>
          <div class="form-group text-center border-primary" id="preview">
            <img class="img-fluid" v-if="url" :src="url" />
          </div>
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-image"></i></span>
              </div>
              <div class="custom-file">
                <input @change="onFileChange" type="file" ref="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="img">รูปภาพหน้าปก</label>
              </div>
            </div>
          </div>
          <div class="form-group mb-0">
            <label for="isPublish">แผยแพร่บทความ</label>
          </div>
          <div class="form-group">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-upload"></i></span>
              </div>
              <select class="form-control" id="isPublish" @change="selectPublishChange($event.target.value)">
                <option :value="1"> ใช่ </option>
                <option :value="0"> ไม่ </option>
              </select>
            </div>
          </div>
          <div class="form-group" v-if="isShowFirstPage">
            <b-form-checkbox id="checkbox-1" v-model="content.contentFirstPage" name="checkbox-1" value="1" unchecked-value="0">
              แสดงบทความในหน้าแรก
            </b-form-checkbox>
          </div>
          <div class="form-group">
            <textarea name="editor1"></textarea>
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
  var app = new Vue({
    el: '#vueapp',
    data: {
      params: null,
      isShowFirstPage: true,
      url: null,
      selectedFile: null,
      contentsType: [],
      content: {
        contentTitle: '',
        contentTitleImg: null,
        contentWriter: '',
        contentCategory: null,
        contentPublish: '1',
        contentFirstPage: '',
        contentBody: '',
      },
    },
    mounted: function() {
      let urlParams = new URLSearchParams(window.location.search);
      this.params = urlParams.get('contentType');
      if (this.params === 'ข่าวประชาสัมพันธ์') {
        this.content.contentCategory = '9';
        this.content.contentFirstPage = '1';
        this.isShowFirstPage = false;
      } else {
        this.content.contentCategory = '10';
      }
      this.getData();
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
      CKEDITOR.replace('editor1');
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
    },
    methods: {
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
      selectPublishChange(isPublish) {
        console.log(isPublish);
        this.content.contentPublish = isPublish;
      },
      onFileChange(e) {
        const file = e.target.files[0];
        this.url = URL.createObjectURL(file);
        this.content.contentTitleImg = e.target.files[0]
      },
      getData() {
        axios.get('api/content/type/getContentType.php')
          .then((response) => {
            this.contentsType = response.data.content;
            this.contentsType = response.data.content.filter(e => e.cTypeTitle === this.params);
          })
          .catch((error) => {
            console.log(error);
          });
      },
      addContent() {
        this.content.contentBody = CKEDITOR.instances.editor1.getData()

        console.log(this.content);
        if (this.isEmpty(this.content.contentTitle)) {
          this.errAlert('กรุณากรอกชื่อเนื้อหา');
          return;
        }

        if (this.isEmpty(this.content.contentWriter)) {
          this.errAlert('กรุณากรอกชื่อผู้เขียน');
          return;
        }

        if (this.isEmpty(this.content.contentBody)) {
          this.errAlert('กรุณากรอกเนื้อหา');
          return;
        }

        if (this.isEmpty(this.content.contentTitleImg) || this.content.contentTitleImg === null) {
          this.errAlert('กรุณาเพิ่มรูปหน้าปก');
          return;
        }

        var formData = new FormData();
        console.log(this.params);
        formData.append('contentTitle', this.content.contentTitle)
        formData.append('contentWriter', this.content.contentWriter)
        formData.append('contentType', this.content.contentCategory)
        formData.append('contentPublish', Number(this.content.contentPublish))
        formData.append('contentBody', this.content.contentBody)
        formData.append('contentImg', this.content.contentTitleImg)
        formData.append('contentFirstPage', this.content.contentFirstPage)
        var contentForm = {};
        formData.forEach(function(value, key) {
          console.log(value);
          contentForm[key] = value;
        });

        axios({
            method: 'post',
            url: 'api/content/postAddContent.php',
            data: formData,
            config: {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }
          })
          .then(function(response) {
            console.log(this.params);
            console.log(response);
            if (response.data !== null) {
              Swal.fire({
                icon: 'success',
                title: response.data.message,
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
      }
    },
  })
</script>

</html>