<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueSlideShow">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">จัดการ SlideShow</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">จัดการ SlideShow</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="container text-center" style="overflow-x:auto;">
            <b-table class="col-lg-12" striped hover id="my-table" :items="slideShowImg" :fields="fields">
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(slideImg)="row">
                <b-img class="imgTable" :src="row.item.imgTitle" width="150" height="150" thumbnail></b-img>
              </template>
              <template #cell(actionsEdit)="row">
                <label>
                  <div class="mr-1 btn btn-primary" v-if="!isLoading">
                    <i class="fas fa-edit mr-2"></i>เปลี่ยนรูปภาพ
                  </div>
                  <div v-if="isLoading && row.index === imgIndex" class="d-flex justify-content-center mb-3">
                    <b-spinner variant="primary" style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
                  </div>
                  <input style="display:none;" type="file" @change="onFileChange(row.item, row.index, $event.target)" accept="image/jpeg, image/png, image/gif"></input>
                </label>
              </template>
            </b-table>
          </div>
        </div>
      </section>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
<script>
  var app = new Vue({
    el: '#vueSlideShow',
    data() {
      return {
        imgIndex: null,
        isLoading: false,
        slideImg: null,
        slideShowImg: [],
        fields: [{
          key: 'index',
          label: 'ลำดับ',
        }, {
          key: 'slideImg',
          label: 'รูปภาพ',
        }, {
          key: 'imgName',
          label: 'ชื่อรูปภาพ',
        }, {
          key: 'actionsEdit',
          label: 'แก้ไข'
        }, ]
      }
    },
    computed: {

    },
    methods: {
      onFileChange(item, index, button) {
        this.isLoading = true;
        const file = button.files[0];
        const slideImgId = index + 1;
        this.imgIndex = index;
        this.slideImg = file;
        if (this.slideImg !== null) {
          if (this.slideImg.size > 8000000) {
          this.isLoading = false;
            Swal
              .fire({
                icon: "info",
                title: "ไม่สามารถเพิ่มรูปภาพที่มีขนาดเกิน 8MB",
                showConfirmButton: true,
                allowOutSideClick: false,
              })
              .then(() => {
                this.getSlideShowImg();
              });
          }
          let formData = new FormData();
          formData.append('img', this.slideImg);
          formData.append('slideImgId', slideImgId);
          axios.post('api/slideshow/postAddSlideShow.php', formData).then((res) => {
            if (res.data === "True") {
              this.isLoading = false;
              Swal
                .fire({
                  icon: "success",
                  title: "แก้ไขรูปภาพสำเร็จ",
                  showConfirmButton: false,
                  timer: 1000,
                })
                .then(() => {
                  this.getSlideShowImg();
                });
            } else {
              this.isLoading = false;
              Swal
                .fire({
                  icon: "error",
                  title: "เกิดข้อผิดพลาด",
                  showConfirmButton: false,
                  timer: 1000,
                })
                .then(() => {
                  this.getSlideShowImg();
                });
            }
          });
        }
      },
      changeImg(item, index, button) {
        console.log(this.slideImg);
      },
      getSlideShowImg() {
        axios.get('api/slideshow/getAllSlideShow.php').then((res) => {
          this.slideShowImg = res.data.slideShowImg
        }).catch((err) => {
          console.log(err);
        });
      },
    },
    mounted() {
      this.getSlideShowImg();
    },
  });
</script>

</html>