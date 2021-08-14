<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueapp_contentType">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">ประเภทบทความ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">ประเภทบทความ</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <div class="col-md-3 ml-3 mb-3">
        <button data-toggle="modal" data-target="#addTypeForm" class="btn btn-success">เพิ่มประเภทบทความ</button>
      </div>
      <div class="container text-center" style="overflow-x:auto;">
        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>

        <b-table class="col-lg-12" striped hover id="my-table" :items="contents" :per-page="perPage" :current-page="currentPage" :fields="fields" small>
          <template #cell(index)="row">
            {{ row.index + 1 }}
          </template>
          <template #cell(actions)="row">
            <b-button size="md" data-toggle="modal" data-target="#editTypeForm" @click="passTypeData(row.item, row.index, $event.target)" variant="info" class="mr-1">
              <i class="fas fa-edit"></i>
            </b-button>
            <b-button size="md" @click="deleteContentType(row.item, row.index, $event.target)" variant="danger" class="mr-1">
              <i class="fas fa-trash"></i>
            </b-button>
          </template>
        </b-table>
      </div>

      <!-- <table class="table tables-striped table-bordered table-hover">
          <thead class="text-light table-borderless" style="background-color:#333333;">
            <tr>
              <td>ลำดับ</td>
              <td>ชื่อประเภทบทความ</td>
              <td>แก้ไข</td>
              <td>ลบ</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(content, index) in contents">
              <td>{{ index + 1 }}</td>
              <td>{{ content.cTypeTitle }}</td>
              <td><button @click="passTypeData(content.cTypeId, content.cTypeTitle)" data-toggle="modal" data-target="#editTypeForm" class="btn btn-info btn-block" type="button" class="btn btn-info btn-block"><i class="fas fa-edit"></button></td>
              <td><button @click="deleteContentType(content.cTypeId)" type="button" class="btn btn-danger btn-block"><i class="fas fa-trash"></button></td>
            </tr>
          </tbody>
        </table>
      -->
      <!-- Add ContentType Form Modal !-->
      <div class="modal fade" id="addTypeForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="exampleModalLabel">เพิ่มประเภทบทความ</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="type">ประเภทบทความ</label>
                <small v-if="isTextEmtyp" id="emailHelp" class="form-text text-danger">* กรุณากรอกประเภทบทความ</small>
                <input type="text" class="form-control" id="contentType" aria-describedby="typeHelp" placeholder="กรอกประเภทบทความ..." v-model="contentType">
              </div>
              <div class="modal-footer border-top-0 d-flex justify-content-center">
                <button @click="addContentType" class="btn btn-success">ยืนยัน</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit ContentType Form Modal !-->
      <div class="modal fade" id="editTypeForm" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header border-bottom-0">
              <h5 class="modal-title" id="editModalLabel">แก้ไขประเภทบทความ</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="type">ประเภทบทความ</label>
                <small v-if="isTextEmtyp" id="contentHelp" class="form-text text-danger">* กรุณากรอกประเภทบทความ</small>
                <input type="text" class="form-control" id="contentTypeUpdate" aria-describedby="typeHelp" placeholder="กรอกประเภทบทความ..." v-model="editType.cTypeTitle">
              </div>
              <div class="modal-footer border-top-0 d-flex justify-content-center">
                <button @click="editContentType" class="btn btn-success">ยืนยัน</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      var app = new Vue({
        el: '#vueapp_contentType',
        data: {
          perPage: 9,
          currentPage: 1,
          contents: [],
          contentType: '',
          isTextEmtyp: false,
          editFormShow: false,
          editType: {
            cTypeId: '',
            cTypeTitle: '',
          },
          fields: [{
              key: 'index',
              label: 'ลำดับ',
            },
            {
              key: 'cTypeId',
              sortable: true,
              label: 'รหัสประเภทบทความ'
            }, {
              key: 'cTypeTitle',
              sortable: true,
              label: 'ประเภทบทความ'
            }, {
              key: 'actions',
              label: 'Actions'
            }
          ],
        },
        computed: {
          rows() {
            return this.contents.length
          }
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
          passTypeData(item, index, button) {
            console.log(item);
            this.editType = {
              cTypeId: item.cTypeId,
              cTypeTitle: item.cTypeTitle
            }
          },
          addContentType() {
            if (this.isEmpty(this.contentType)) {
              this.isTextEmtyp = true;
              return;
            } else {
              this.isTextEmtyp = false;
            }

            if (this.contentType != '') {
              var formData = new FormData();
              formData.append('contentType', this.contentType)
              var contentTypeForm = {};
              formData.forEach(function(value, key) {
                console.log(value);
                contentTypeForm[key] = value;
              });
              axios({
                  method: 'post',
                  url: 'api/content/type/postAddContentType.php',
                  data: formData,
                  config: {
                    headers: {
                      'Cache-Control': 'no-cache',
                      'Content-Type': 'multipart/form-data'
                    }
                  }
                })
                .then(function(response) {
                  console.log(response);
                  if (response.status = 201) {
                    Swal.fire({
                      icon: 'success',
                      title: response.data.message,
                      showConfirmButton: false,
                      timer: 1500
                    }).then(() => {
                      window.location.reload(true);
                    })
                  }
                })
                .catch(function(err) {
                  if (err.status = 503) {
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
          editContentType() {
            console.log('Test');
            console.log(this.editType.cTypeTitle);
            if (this.isEmpty(this.editType.cTypeTitle)) {
              this.isTextEmtyp = true;
              return;
            } else {
              this.isTextEmtyp = false;
            }

            if (this.editType.cTypeTitle != '') {
              var formData = new FormData();
              formData.append('cTypeId', this.editType.cTypeId);
              formData.append('cTypeTitle', this.editType.cTypeTitle);
              var contentTypeForm = {};
              formData.forEach(function(value, key) {
                console.log(value);
                contentTypeForm[key] = value;
              });
              axios({
                  method: 'post',
                  url: 'api/content/type/postEditContentType.php',
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
                      title: response.data.message,
                      showConfirmButton: false,
                      timer: 1500
                    }).then(() => {
                      window.location = "content_type.php";
                    })
                  }
                })
                .catch(function(err) {
                  if (err.status = 503) {
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
          getData() {
            axios.get('api/content/type/getContentType.php')
              .then((response) => {
                this.contents = response.data.content;
                console.log(this.contents);
              })
              .catch((error) => {
                console.log(error);
              });
          },
          deleteContentType(item, index, button) {
            console.log(item);
            Swal.fire({
              title: 'ต้องการลบประเภทบทความ ?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              allowOutsideClick: false,
              cancelButtonColor: '#d33',
              confirmButtonText: 'ยืนยัน',
              cancelButtonText: 'ยกเลิก',
            }).then((result) => {
              if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('cTypeId', item.cTypeId)
                axios({
                    method: 'post',
                    url: 'api/content/type/postDeleteContentType.php',
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
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                      }).then(() => {
                        window.location.reload();
                      })
                    }
                  })
                  .catch(function(err) {
                    if (err) {
                      console.log(err);
                      Swal.fire({
                        icon: 'error',
                        title: 'ไม่สามารถลบได้เนื่องจากมีบทความที่มีประเภทนี้อยู่',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                      })
                    }
                  });
              }
            })
          }
        },
        mounted() {
          this.getData();
        },
      })
    </script>
    <?php include 'includes/footer.php' ?>
</body>

</html>