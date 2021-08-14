<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueapp_content">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">จัดการเนื้อหา</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">จัดการเนื้อหา</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <div class="col-md-3 ml-3 mb-3">
        <a :href="addurl" class="btn btn-success">เพิ่มเนื้อหา</a>
      </div>
      <div class="container text-center" style="overflow-x:auto;">
        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>

        <b-table class="col-lg-12" striped hover id="my-table" :items="contents" :per-page="perPage" :current-page="currentPage" :fields="fields" small>
          <template #cell(index)="data">
            {{ (data.index + 1) }}
          </template>
          <template #cell(publish)="row">
            <i v-if="row.item.contentPublish === '1'" class="fas fa-check-circle fa-lg text-success"></i>
            <i v-if="row.item.contentPublish === '0'" class="fas fa-times-circle fa-lg text-danger"></i>
          </template>
          <template #cell(firstpage)="row">
            <i v-if="row.item.contentFirstPage === '1'" class="fas fa-check-circle fa-lg text-success"></i>
            <i v-if="row.item.contentFirstPage === '0'" class="fas fa-times-circle fa-lg text-danger"></i>
          </template>
          <template #cell(actionsEdit)="row">
            <b-button size="md" @click="editContent(row.item, row.index, $event.target)" variant="primary" class="mr-1">
              <i class="fas fa-edit"></i>
            </b-button>
          </template>
          <template #cell(actionsDelete)="row">
            <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
              <i class="fas fa-trash"></i>
            </b-button>
          </template>
        </b-table>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php' ?>
  <script>
    var app = new Vue({
      el: '#vueapp_content',
      data: {
        addurl: '',
        params: null,
        perPage: 12,
        currentPage: 1,
        fields: [{
          key: 'index',
          label: 'ลำดับ',
        }, {
          key: 'publish',
          label: 'เผยแพร่',
        }, {
          key: 'firstpage',
          label: 'หน้าแรก',
        }, {
          key: 'contentTitle',
          sortable: true,
          label: 'หัวข้อบทความ',
        }, {
          key: 'contentWriter',
          sortable: true,
          label: 'ผู้เขียน'
        }, {
          key: 'contentTime',
          sortable: true,
          label: 'วันที่สร้าง'
        }, {
          key: 'actionsEdit',
          label: 'แก้ไข'
        }, {
          key: 'actionsDelete',
          label: 'ลบ'
        }],
        contents: [],
      },
      computed: {
        rows() {
          return this.contents.length
        }
      },
      methods: {
        getData() {
          axios.get('api/content/getContent.php')
            .then((response) => {
              if (this.params === "ข่าวประชาสัมพันธ์") {
                this.contents = response.data.content.filter(e => e.contentTypeTitle === 'ข่าวประชาสัมพันธ์');
              }

              if (this.params === "แนะนำผลผลิต") {
                this.contents = response.data.content.filter(e => e.contentTypeTitle === 'แนะนำผลผลิต');
              }

              this.contents.map((e, i) => {
                let year = e.contentTime.substring(0, 4);
                let month = e.contentTime.substring(5, 7);
                let day = e.contentTime.substring(8, 10);
                let date = new Date(year, month, day);
                const result = date.toLocaleDateString('th-Th', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric',
                })
                e.contentTime = result;
              })

              this.contents.reverse();
              console.log(this.contents);
            })
            .catch((error) => {
              console.log(error);
            });
        },
        editContent(item, index, button) {
          console.log(item.contentId);
          window.location = `edit_content.php?contentId=${item.contentId}`;
        },
        deleteContent(item, index, button) {
          Swal.fire({
            title: 'ต้องการลบบทความ ?',
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
              formData.append('contentId', item.contentId)
              formData.append('contentImg', item.contentImg)
              axios({
                  method: 'post',
                  url: 'api/content/postDeleteContent.php',
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
                      title: 'ลบบทความสำเร็จ',
                      showConfirmButton: false,
                      timer: 1500
                    }).then(() => {
                      window.location.reload();
                    })
                  }
                })
                .catch(function(err) {
                  if (err.status = 503) {
                    Swal.fire({
                      icon: 'error',
                      title: 'ไม่สามารถลบรูปภาพได้',
                      showConfirmButton: true,
                      allowOutsideClick: false,
                    })
                  }
                });
            }
          });

        }
      },
      mounted() {
        let urlParams = new URLSearchParams(window.location.search);
        this.params = urlParams.get('contentType');
        this.addurl = `add_content.php?contentType=${this.params}`;
        this.getData();
      },
    })
  </script>
</body>

</html>