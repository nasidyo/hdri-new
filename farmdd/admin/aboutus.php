<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueapp_aboutus">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">จัดการเมนูเกี่ยวกับเรา</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">จัดการเมนูเกี่ยวกับเรา</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <div class="container text-center" style="overflow-x:auto;">
        <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table"></b-pagination>

        <b-table class="col-lg-12" striped hover id="my-table" :items="abouts" :per-page="perPage" :current-page="currentPage" :fields="fields" small>
          <template #cell(index)="data">
            {{ (data.index + 1) }}
          </template>
          <template #cell(actions)="row">
            <b-button size="md" @click="editContent(row.item, row.index, $event.target)" variant="info" class="mr-1">
              <i class="fas fa-edit"></i>
            </b-button>
          </template>
        </b-table>
      </div>
    </div>
  </div>
  
  <?php include 'includes/footer.php' ?>
  <script>
    var app = new Vue({
      el: '#vueapp_aboutus',
      data: {
        perPage: 9,
        currentPage: 1,
        fields: [{
          key: 'index',
          label: 'ลำดับ',
        }, {
          key: 'aboutTitle',
          label: 'หัวข้อ',
        }, {
          key: 'actions',
          label: 'แก้ไข'
        }],
        abouts: [],
      },
      computed: {
        rows() {
          return this.abouts.length
        }
      },
      methods: {
        getData() {
          axios.get('api/aboutus/getAboutUs.php')
            .then((response) => {
              this.abouts = response.data.aboutus;
              console.log('getAboutus', this.abouts);
            })
            .catch((error) => {
              console.log(error);
            });
        },
        editContent(item, index, button) {
          console.log(item.id);
          window.location = `edit_aboutus.php?id=${item.id}`;
        },
      },
      mounted() {
        this.getData();
      },
    })
  </script>
</body>

</html>