<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="vueapp_member">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">จัดการสินค้า</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">จัดการสินค้า</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div @click="filterTypeOfArgi(item.idTypeOfArgi)" class="col-md-4" v-for="item in typeOfArgi" :key="item.idTypeOfArgi" style="cursor: pointer;">
              <div class="info-box mb-3">
                <span v-if="item.idTypeOfArgi == type" class='info-box-icon bg-primary elevation-1'><i class="fas fa-shopping-basket"></i></span>
                <span v-else class='info-box-icon bg-success elevation-1'><i class="fas fa-shopping-basket"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">{{ item.nameTypeOfArgiMk }}</span>
                  <span class="info-box-number">{{ item.idTypeOfArgi === '1' ? `(${countType.first})` : 
                        item.idTypeOfArgi === '2' ? `(${countType.second})` : 
                        item.idTypeOfArgi === '3' ? `(${countType.third})` : 
                        item.idTypeOfArgi === '4' ? `(${countType.fourth})` : 
                        item.idTypeOfArgi === '5' ? `(${countType.fifth})` : 
                        item.idTypeOfArgi === '6' ? `(${countType.sixth})` :
                        item.idTypeOfArgi === '7' ? `(${countType.seventh})` :
                        item.idTypeOfArgi === '8' ? `(${countType.eigth})` :
                        item.idTypeOfArgi === '9' ? `(${countType.ninth})` : '0'
                  }}</span>
                </div>
              </div>
            </div>
          </div>
          <!-- Info boxes -->

          <b-container fluid v-if="!showSellerType">
            <b-row class="mb-3" cols="12">
              <b-col md="4">
                <a href="addProduct.php" type="button" class="btn btn-success mb-3">เพิ่มสินค้า</a>
                <a href="product.php" type="button" class="btn btn-warning mb-3">แสดงสินค้าทั้งหมด</a>  
              </b-col>
              <b-col md="4" class="ml-auto">
                <b-form-group id="input-group-3" v-if="!showSellerType">
                  <label label-for="input-3">ประเภทผู้ขาย</label>
                  <b-form-select id="input-3" v-model="sellerTypeId" :options="sellerTypeOptions" @change="filterProductBySellerAll(sellerTypeId)"></b-form-select>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row class="mb-3" cols="12">
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchProductNameAll($event.target.value)" type="text" placeholder="ค้นหาจากชื่อสินค้า"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          <b-container fluid v-if="showSellerType">
            <b-row class="mb-3" cols="12">
              <b-col md="4">
                <a href="addProduct.php" type="button" class="btn btn-success mb-3">เพิ่มสินค้า</a>
                <a href="product.php" type="button" class="btn btn-warning mb-3">แสดงสินค้าทั้งหมด</a>
              </b-col>
              <b-col md="4" class="ml-auto">
                <b-form-group id="input-group-3" v-if="showSellerType">
                  <label label-for="input-3">ประเภทผู้ขาย</label>
                  <b-form-select id="input-3" v-model="sellerTypeId" :options="sellerTypeOptions" @change="filterProductBySeller(sellerTypeId)"></b-form-select>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row class="mb-3" cols="12">
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchProductName($event.target.value)" type="text" placeholder="ค้นหาจากชื่อสินค้า"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          <div class="row">
            <!-- Product Table -->
            <div class="container text-center" style="overflow-x:auto;">
              <b-table class="col-lg-12" :busy="isBusy" hover id="my-table" :items="productMk" :per-page="perPage" :current-page="currentPage" :fields="productFields" small>
                <template #table-busy>
                  <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                  </div>
                </template>
                <template #cell(index)="data">
                  {{ (data.index + 1) }}
                </template>
                <template #cell(titleImg)="row">
                  <td>
                    <b-img :src="row.item.titleImg" width="150" height="150" thumbnail></b-img>
                  </td>
                </template>
                <template #cell(name)="row">
                  {{ `${row.item.firstName} ${row.item.lastName}` }}
                </template>
                <template #cell(productPrice)="row">
                  {{ row.item.priceBegin === row.item.priceEnd ? `฿${row.item.priceEnd}` : 
                      `฿${row.item.priceBegin} - ฿${row.item.priceEnd}` }} / {{ row.item.nameUnit}}
                </template>
                <template #cell(suggestSta)="row">
                  <b-button v-if="row.item.suggestSta === '1'" size="md" @click="changeSuggest(row.item, row.index, $event.target)" variant="success" class="mr-1">
                    <i class="fas fa-tags"></i>
                  </b-button>
                  <b-button v-if="row.item.suggestSta === '0'" size="md" @click="changeSuggest(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                    <i class="fas fa-tags"></i>
                  </b-button>
                </template>
                <template #cell(publish)="row">
                  <b-button v-if="row.item.publish === '1'" size="md" @click="changePublish(row.item, row.index, $event.target)" variant="success" class="mr-1">
                    <i class="fas fa-upload"></i>
                  </b-button>
                  <b-button v-if="row.item.publish === '0'" size="md" @click="changePublish(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                    <i class="fas fa-upload"></i>
                  </b-button>
                </template>
                <template #cell(actionsEdit)="row">
                  <b-button size="md" @click="editProduct(row.item, row.index, $event.target)" variant="primary" class="mr-1">
                    <i class="fas fa-edit"></i>
                  </b-button>
                </template>
                <template #cell(groupName)="row">
                  {{ row.item.groupName || '-' }}
                </template>
                <template #cell(actionsDelete)="row">
                  <b-button size="md" @click="deleteProduct(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                    <i class="fas fa-trash"></i>
                  </b-button>
                </template>
              </b-table>
              <div class="container" v-if="checkProductSize">
                <h3>...ไม่พบข้อมูล</h3>
              </div>
              <b-pagination @click="toggleBusy" v-model="currentPage" :total-rows="productRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
            </div>
            <!-- End Product Table -->
          </div>
        </div>
      </section>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
<script>
  var app = new Vue({
    el: '#vueapp_member',
    data: {
      isBusy: false,
      countType: {
        first: 0,
        second: 0,
        third: 0,
        fourth: 0,
        fifth: 0,
        sixth: 0,
        seventh: 0,
        eigth: 0,
        ninth: 0
      },
      sellerTypeId: null,
      idTypeOfSeller: null,
      typeOfArgi: [],
      productMk: [],
      productMkClone: [],
      sellerType: [],
      sellerTypeOptions: [],
      perPage: 12,
      productFields: [{
        key: 'index',
        label: 'ลำดับ',
      }, {
        key: 'titleImg',
        label: 'รูปสินค้า',
      }, {
        key: 'idAgri',
        label: 'ชื่อสินค้า',
        sortable: true,
      }, {
        key: 'name',
        label: 'ชื่อเกษตรกร / กลุ่ม',
      }, {
        key: 'productPrice',
        label: 'ราคา',
      }, {
        key: 'nameTypeOfArgiMk',
        label: 'ประเภทสินค้า'
      }, {
        key: 'nameTypeOfSeller',
        label: 'ประเภทผู้ขาย',
      }, {
        key: 'suggestSta',
        label: 'แนะนำสินค้า'
      }, {
        key: 'publish',
        label: 'เผยแพร่'
      }, {
        key: 'actionsEdit',
        label: 'แก้ไข'
      }, {
        key: 'actionsDelete',
        label: 'ลบ'
      }],
      type: null,
      showSellerType: false,
      currentPage: 1,
      baseUrl: "https://farmtd.hrdi.or.th/farmdd/admin/api/",
    },
    computed: {
      productRows() {
        return this.productMk.length
      },
      checkProductSize: function() {
        if (this.productMk.length === 0) {
          return true;
        }
      },
    },
    methods: {
      searchProductNameAll(productName) {
        this.productMk = [...this.productMkClone];
        if (productName !== '') {
          this.productMk = this.productMk.filter((product) => {
            return product.idAgri.includes(productName)
          })
        }
      },
      searchProductName(productName) {
        this.productMk = [...this.productMkClone];
        if (productName !== '' && this.idTypeOfSeller !== null) {
          this.productMk = this.productMk.filter((product) => {
            return product.idAgri.includes(productName) && product.idTypeOfSellerMk === this.idTypeOfSeller
          })
        } else if (productName !== '' && this.idTypeOfSeller === null) {
          console.log('Here');
          this.productMk = this.productMk.filter((product) => {
            return product.idAgri.includes(productName) && product.idTypeOfArgi === this.type
          })
        } else {
          this.productMk = [...this.productMkClone];
          this.productMk = this.productMk.filter((product) => {
            return product.idTypeOfArgi === this.type
          })
        }
      },
      changeSuggest(item, index, button) {
        if (item.suggestSta === '1') {
          Swal.fire({
            title: 'ต้องการยกเลิกการแนะนำสินค้า ?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
          }).then((result) => {
            if (result.isConfirmed) {
              const userData = new FormData();
              userData.append('idProductOfMemberMk', item.idProductOfMemberMk);
              axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postUpdateNoSuggestSta.php', userData).then((res) => {
                Swal.fire({
                  icon: 'success',
                  title: 'แก้ไขสถานะสินค้าสำเร็จ',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              }).catch((err) => {
                Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              })
            }
          });
        } else {
          Swal.fire({
            title: 'ต้องการแนะนำสินค้า ?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
          }).then((result) => {
            if (result.isConfirmed) {
              const userData = new FormData();
              userData.append('idProductOfMemberMk', item.idProductOfMemberMk);
              axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postUpdateSta.php', userData).then((res) => {
                Swal.fire({
                  icon: 'success',
                  title: 'แก้ไขสถานะสินค้าสำเร็จ',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              }).catch((err) => {
                Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              })
            }
          });
        }

      },
      changePublish(item, index, button) {
        if (item.publish === '1') {
          Swal.fire({
            title: 'ต้องการยกเลิกการเผยแพร่ ?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
          }).then((result) => {
            if (result.isConfirmed) {
              const userData = new FormData();
              userData.append('idProductOfMemberMk', item.idProductOfMemberMk);
              axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postUpdateNoPublish.php', userData).then((res) => {
                Swal.fire({
                  icon: 'success',
                  title: 'แก้ไขสถานะการแสดงสินค้าสำเร็จ',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              }).catch((err) => {
                Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              })
            }
          });
        } else {
          Swal.fire({
            title: 'ต้องการเผยแพร่สินค้า ?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
          }).then((result) => {
            if (result.isConfirmed) {
              const userData = new FormData();
              userData.append('idProductOfMemberMk', item.idProductOfMemberMk);
              axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postUpdatePublish.php', userData).then((res) => {
                Swal.fire({
                  icon: 'success',
                  title: 'แก้ไขสถานะการแสดงสินค้าสำเร็จ',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              }).catch((err) => {
                Swal.fire({
                  icon: 'error',
                  title: 'เกิดข้อผิดพลาด',
                  showConfirmButton: false,
                  timer: 1500
                }).then((result) => {
                  window.location.reload();
                })
              })
            }
          });
        }


      },
      deleteProduct(item, index, event) {
        console.log(item.idProductOfMemberMk);
        Swal.fire({
          title: 'ต้องการลบสินค้า ?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ยืนยัน',
          cancelButtonText: 'ยกเลิก',
        }).then((result) => {
          if (result.isConfirmed) {
            const userData = new FormData();
            userData.append('idProductOfMemberMk', item.idProductOfMemberMk);

            axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postDeleteProduct.php', userData).then((res) => {
              Swal.fire({
                icon: 'success',
                title: 'ลบสินค้าสำเร็จ',
                showConfirmButton: false,
                timer: 1500
              }).then((result) => {
                window.location.reload();
              })
            }).catch((err) => {
              Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                showConfirmButton: false,
                timer: 1500
              }).then((result) => {
                window.location.reload();
              })
            })
          }
        });
      },
      filterProductBySeller(idTypeOfSeller) {
        this.idTypeOfSeller = idTypeOfSeller;
        this.productMk = [...this.productMkClone];

        if (idTypeOfSeller === '0') {
            this.productMk = this.productMk.filter((e, i) => {
            return parseInt(this.type) === parseInt(e.idTypeOfArgi);
          });
        } else {
          this.productMk = this.productMk.filter((e, i) => {
            console.log(e.idTypeOfArgi);
            // console.log(e.idTypeOfSellerMk, idTypeOfSeller);
            return parseInt(e.idTypeOfSellerMk) === parseInt(idTypeOfSeller) && parseInt(this.type) === parseInt(e.idTypeOfArgi);
          });
        }
      },
      filterTypeOfArgi(type) {
        this.sellerTypeId = null;
        this.showSellerType = true;
        // this.getTypeOfSeller();
        this.type = type;
        this.productMk = [...this.productMkClone];
        this.productMk = this.productMk.filter((e, i) => {
          return parseInt(e.idTypeOfArgi) === parseInt(type);
        });
      },
      getTypeOfArgi() {
        axios
          .get(`${this.baseUrl}product/getTypeArgi.php`)
          .then((response) => {
            if (response.data.typeOfArgi !== 0) {
              this.typeOfArgi = response.data.typeOfArgi;
              this.typeOfArgi = this.typeOfArgi.filter((e) => {
                return e.nameTypeOfArgiMk !== null;
              });

              console.log("typeOfArgi", this.typeOfArgi);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      },
      editProduct(item, index, button) {
        window.location.href = `editProduct.php?idProductOfMemberMk=${item.idProductOfMemberMk}`
      },
      toggleBusy() {
        this.isBusy = !this.isBusy
      },
      getAllProduct() {
        axios.get(`${this.baseUrl}product/getAllProductAdmin.php`).then((res) => {
          if (res.data.productMk !== 0) {
            this.productMk = res.data.productMk.reverse();
            this.productMkClone = this.productMk;
            this.productMkClone.reverse();
            this.productMk.map((e, i) => {
              switch (e.idTypeOfArgi) {
                case "1":
                  this.countType.first++;
                  break;
                case "2":
                  this.countType.second++;
                  break;
                case "3":
                  this.countType.third++;
                  break;
                case "4":
                  this.countType.fourth++;
                  break;
                case "5":
                  this.countType.fifth++;
                  break;
                case "6":
                  this.countType.sixth++;
                  break;
                case "7":
                  this.countType.seventh++;
                  break;
                case "8":
                  this.countType.eigth++;
                  break;
                case "9":
                  this.countType.ninth++;
                  break;
              }
            });
          }
          console.log('productMk', this.productMk);
        }).catch((err) => {
          console.log(err);
        })
      },
      getTypeOfSeller() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getTypeOfSeller.php').then((res) => {
          if (res.data.sellerType.length > 0) {
            this.sellerType = res.data.sellerType;
            this.sellerTypeOptions = this.sellerType.map(e => ({
              value: e.idTypeOfSellerMK,
              text: e.nameTypeOfSeller
            }));
            this.sellerTypeOptions.unshift({
              value: '0',
              text: 'แสดงทั้งหมด'
            })
          }
          console.log('getAllTypeOfSeller', this.sellerType);
        }).catch((err) => {
          console.log(err);
        })
      },
      filterProductBySellerAll(idTypeOfSeller) {
        this.idTypeOfSeller = idTypeOfSeller;
        this.productMk = [...this.productMkClone];

        if (idTypeOfSeller === '0') {
          this.productMk = [...this.productMkClone];
            return 
        } else {
          this.productMk = this.productMk.filter((e, i) => {
            console.log(e.idTypeOfArgi);
            return parseInt(e.idTypeOfSellerMk) === parseInt(idTypeOfSeller);
          });
        }
      }
    },
    mounted() {
      this.getAllProduct();
      this.getTypeOfArgi();
      this.getTypeOfSeller();
    },
  })
</script>

</html>