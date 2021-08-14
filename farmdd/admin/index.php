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
              <h1 class="m-0 text-dark">สรุปภาพรวม</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">สรุปภาพรวม</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ todayRegister }}</h3>
                  <p>สมาชิกใหม่วันนี้</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{ todayProduct }}</h3>
                  <p>สินค้าใหม่วันนี้</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-basket"></i>
                </div>
              </div>
            </div>
          </div>

          <div class="row text-center">
            <div class="col-lg-6 mx-auto mt-3">
              <h3>รายการสมาชิกแต่ละประเภท</h3>
              <canvas id="userBarChart" width="800" height="450"></canvas>
            </div>
            <div class="col-lg-6 mx-auto">
              <h3>รายการสินค้าแต่ละหมวด</h3>
              <canvas id="barChart" width="800" height="450"></canvas>
            </div>
          </div>

          <div class="row text-center">
            <div class="col-lg-6 mx-auto my-3">
              <h3>เปรียบเทียบการเข้าใช้งานจำแนกตามวัตถุประสงค์</h3>
              <canvas id="buyerTypeChart"></canvas>
            </div>
            <div class="col-lg-6 mx-auto my-3">
              <h3>เปรียบเทียบช่องทางการเข้าถึงเว็บไซต์</h3>
              <canvas id="buyerTypeChartVisit"></canvas>
            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header border-0">
              <h3 class="card-title">สมาชิกใหม่</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-striped table-valign-middle">
                <thead>
                  <tr>
                    <th>ชื่อสมาชิก</th>
                    <th>ยืนยันสมาชิก</th>
                    <th>ประเภทสมาชิก</th>
                    <th>เวลาที่สมัคร</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in allUser" :key="index">
                    <td @click="UserLink()">
                      <img :src="item.memberImg" alt="Product 1" class="img-circle img-size-32 mr-2">
                      {{ `${item.firstName} ${item.lastName}` }}
                    </td>
                    <td class="text-center">
                      <b-button v-if="item.statusOfMember === '1'" size="md" @click="confirmMember(item.statusOfMember, item.username, item.typeOfMember)" variant="success" class="mr-1">
                        <i class="fas fa-user-check"></i>
                      </b-button>
                      <b-button v-else="item.statusOfMember === '0'" size="md" @click="confirmMember(item.statusOfMember, item.username, item.typeOfMember)" variant="warning" class="mr-1">
                        <i class="fas fa-user-check"></i>
                      </b-button>
                    </td>
                    <td class="text-center">{{ item.typeOfMember === 'Buyer' ? 'ผู้ซื้อ' : item.typeOfMember === 'Normal' ? 'ทั่วไป' : 'ผู้ขาย' }}</td>
                    <td>
                      {{ item.registerDate }}
                    </td>
                </tbody>
              </table>
            </div>
            <div class="card-footer text-center">
              <a href="member.php" class="uppercase">ดูสมาชิกทั้งหมด</a>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">สินค้าใหม่ล่าสุด</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="(item, index) in allProduct" :key="index">
                  <div class="product-img">
                    <img :src="item.titleImg" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a class="product-title">{{ item.idAgri }}
                      <span class="badge badge-success float-right">{{ `฿${item.priceBegin} - ฿${item.priceEnd}`}}</span></a>
                    <span class="product-description">
                      ประเภท {{ item.nameTypeOfArgiMk }} สายพันธุ์ {{ item.speciesArgi || '-' }}
                    </span>
                  </div>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="product.php" class="uppercase">ดูสินค้าทั้งหมด</a>
            </div>
            <!-- /.card-footer -->
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
      productMk: [],
      productType: [],
      typeOfArgi: [],
      sellerUser: [],
      allProduct: [],
      allUser: [],
      allBuyerUser: [],
      todayRegister: 0,
      todayProduct: 0,
    },
    computed: {

    },
    methods: {
      confirmMember(statusOfMember, username, typeOfMember) {
        if (statusOfMember === '1') {
          Swal.fire({
            title: 'ต้องการยกเลิกสถานะสมาชิก ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
          }).then((result) => {
            if (result.isConfirmed) {
              if (typeOfMember === 'Buyer' || 'Normal') {
                var updateSta = new FormData();
                updateSta.append('username', username);
                updateSta.append('table', 'BuyerMember_MK');
              }

              if (typeOfMember === 'Seller') {
                var updateSta = new FormData();
                updateSta.append('username', username);
                updateSta.append('table', 'SellerMember_MK');
              }

              axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postUpdateMemberSta.php', updateSta).then((res) => {
                if (res.data === 'True') {
                  Swal.fire({
                    icon: 'success',
                    title: 'แก้ไขสถานะสมาชิกสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                  }).then((result) => {
                    window.location.reload();
                  })
                }
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
          })
        } else {
          if (typeOfMember === 'Buyer' || typeOfMember === 'Normal') {
            var confirmData = new FormData();
            confirmData.append("username", username);
            confirmData.append("table", 'BuyerMember_MK');
            axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postFindUserInfo.php', confirmData).then((res) => {
              this.userInfo = [];
              if (res.data.buyerUser[0] != null) {
                this.userInfo = res.data.buyerUser[0]
                console.log('userInfo', this.userInfo);
                Swal.fire({
                  title: 'ยืนยันการสมัครสมาชิก',
                  html: `
                  <div class="row mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ชื่อ</span> ${this.userInfo.prefixNameTh} ${this.userInfo.firstName} ${this.userInfo.lastName}
                    <div class="col">
                  </div>
                  <div class="row mx-auto mt-2">
                    <div class="col">
                      <span class="font-weight-bold">หมายเลขบัตรประชาชน ${this.userInfo.idCard}</span> | <span class="font-weight-bold">เบอร์โทรศัพท์</span> ${this.userInfo.phoneNumber}
                    <div class="col">
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">เพศ</span> ${this.userInfo.gender} | <span class="font-weight-bold">อีเมล</span> ${this.userInfo.email}
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">บ้านเลขที่</span> ${this.userInfo.address} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">หมู่</span> ${this.userInfo.moo ? this.userInfo.moo : '-'} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ถนน</span> ${this.userInfo.road ? this.userInfo.road : '-'}
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">จังหวัด</span> ${this.userInfo.provinceName} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">อำเภอ</span> ${this.userInfo.amphurName}
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ตำบล</span> ${this.userInfo.tambolName}
                    </div>
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">lineID</span> ${this.userInfo.lineID ? this.userInfo.lineID : '-'} | <span class="font-weight-bold">Facebook</span> ${this.userInfo.facebookName ? this.userInfo.facebookName : '-'} 
                    </div>
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ประเภทสมาชิก</span> ${this.userInfo.typeOfMember === 'Buyer' ? 'ผู้ซื้อ' : this.userInfo.typeOfMember === 'Normal' ? 'ทั่วไป' : 'ผู้ขาย'} 
                    </div>
                  </div>
                `,
                  imageUrl: `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${this.userInfo.buyerImg}`,
                  imageWidth: 150,
                  imageHeight: 150,
                  width: '800px',
                  imageAlt: 'User image',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'ยืนยันสมาชิก',
                  cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                  if (result.isConfirmed) {
                    Swal.fire(
                      axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postUpdateUserSta.php', confirmData).then((res) => {
                        if (res.data === 'True') {
                          Swal.fire({
                            icon: 'success',
                            title: 'ยืนยันสถานะสมาชิกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                          }).then((result) => {
                            window.location.reload();
                          })
                        }
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
                    )
                  }
                })
              }
            });
          } else {
            console.log('Seller');
            var confirmData = new FormData();
            confirmData.append("username", username);
            confirmData.append("table", 'SellerMember_MK');
            axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postFindSellerInfo.php', confirmData).then((res) => {
              this.userInfo = [];
              console.log(res);
              if (res.data.sellerUser[0] != null) {
                this.userInfo = res.data.sellerUser[0]
                console.log('userInfo', this.userInfo);
                Swal.fire({
                  title: 'ยืนยันการสมัครสมาชิก',
                  html: `
                  <div class="row pa-5 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ชื่อ</span> ${this.userInfo.prefixNameTh} ${this.userInfo.firstName} ${this.userInfo.lastName}
                    <div class="col">
                  </div>
                  <div class="row mx-auto mt-2">
                    <div class="col">
                      <span class="font-weight-bold">หมายเลขบัตรประชาชน</span> ${this.userInfo.idCard} | <span class="font-weight-bold">เบอร์โทรศัพท์</span> ${this.userInfo.phoneNumber}
                    <div class="col">
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">เพศ</span> ${this.userInfo.gender} | <span class="font-weight-bold">อีเมล</span> ${this.userInfo.email}
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">บ้านเลขที่</span> ${this.userInfo.address} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">หมู่</span> ${this.userInfo.moo ? this.userInfo.moo : '-'} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ถนน</span> ${this.userInfo.road ? this.userInfo.road : '-'}
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">จังหวัด</span> ${this.userInfo.provinceName} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">อำเภอ</span> ${this.userInfo.amphurName}
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ตำบล</span> ${this.userInfo.tambolName}
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ลักษณะการจำหน่ายสินค้า</span> ${this.userInfo.nameTypeOfSeller} 
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ชื่อศูนย์</span> ${this.userInfo.areaName} 
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ชื่อกลุ่ม</span> ${this.userInfo.groupName ? this.userInfo.groupName : '-'} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ชื่อร้าน</span> ${this.userInfo.shopName ? this.userInfo.shopName : '-'} 
                    </div>
                    <div class="col">
                      <span class="font-weight-bold">ชื่อตราสินค้า</span> ${this.userInfo.brandName ? this.userInfo.brandName : '-'} 
                    </div>
                  </div>
                  <div class="row mt-3 mb-3 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ชนิดสินค้าที่ต้องการจำหน่าย</span> ${this.userInfo.productType} 
                    </div>
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">lineID</span> ${this.userInfo.lineID ? this.userInfo.lineID : '-'} | <span class="font-weight-bold">Facebook</span> ${this.userInfo.facebookName ? this.userInfo.facebookName : '-'} 
                    </div>
                  </div>
                  <div class="row mt-2 mx-auto">
                    <div class="col">
                      <span class="font-weight-bold">ประเภทสมาชิก</span> ${this.userInfo.typeOfMember}
                    </div>
                  </div>
                `,
                  imageUrl: `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${this.userInfo.sellerImg}`,
                  imageWidth: 200,
                  imageHeight: 200,
                  width: '800px',
                  imageAlt: 'User image',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'ยืนยันสมาชิก',
                  cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                  if (result.isConfirmed) {
                    Swal.fire(
                      axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postUpdateUserSta.php', confirmData).then((res) => {
                        if (res.data === 'True') {
                          Swal.fire({
                            icon: 'success',
                            title: 'ยืนยันสถานะสมาชิกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                          }).then((result) => {
                            window.location.reload();
                          })
                        }
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
                    )
                  }
                })
              }
            });
          }
        }
      },
      buyerSatisticVisit(allBuyerUser) {
        let buyerTypeVisit = [];
        buyerTypeVisit = allBuyerUser.map((e) => ({
          typeOfMember: e.typeOfMember,
          questionOfObjective: e.questionOfObjective,
          questionOfVisit: e.questionOfVisit,
          countType: null
        })).filter((j) => j.typeOfMember === 'Buyer');
        buyerTypeVisit.map((e) => {
          if (e.questionOfVisit !== 'ค้นหาจาก Google' && e.questionOfVisit !== 'เข้ามาในเว็บไซต์ของสถาบันวิจัยและพัฒนาพื้นที่สูง' && e.questionOfVisit !== 'เพื่อน / คนรู้จักแนะนำ') {
            e.questionOfVisit = 'อื่น ๆ'
          }
        })

        let normalTypeVisit = [];
        normalTypeVisit = allBuyerUser.map((e) => ({
          typeOfMember: e.typeOfMember,
          questionOfObjective: e.questionOfObjective,
          questionOfVisit: e.questionOfVisit,
          countType: null
        })).filter((j) => j.typeOfMember === 'Normal');
        normalTypeVisit.map((e) => {
          if (e.questionOfVisit !== 'ค้นหาจาก Google' && e.questionOfVisit !== 'เข้ามาในเว็บไซต์ของสถาบันวิจัยและพัฒนาพื้นที่สูง' && e.questionOfVisit !== 'เพื่อน / คนรู้จักแนะนำ') {
            e.questionOfVisit = 'อื่น ๆ'
          }
        })

        let label = [];
        let countBuyerVisit = [];
        let countNormalVisit = [];
        let countType = [];

        label = allBuyerUser.filter((thing, index, self) => self.findIndex(t => t.questionOfVisit === thing.questionOfVisit) === index)

        label.map((e, index) => {
          console.log(e.questionOfVisit);
          if (e.questionOfVisit !== 'ค้นหาจาก Google' && e.questionOfVisit !== 'เข้ามาในเว็บไซต์ของสถาบันวิจัยและพัฒนาพื้นที่สูง' && e.questionOfVisit !== 'เพื่อน / คนรู้จักแนะนำ') {
            e.questionOfVisit = 'อื่น ๆ'
          }
        })

        label = label.filter((thing, index, self) => self.findIndex(t => t.questionOfVisit === thing.questionOfVisit) === index)

        countBuyerVisit = label.map((e) => ({
          questionOfVisit: e.questionOfVisit,
          countType: null
        }))

        countNormalVisit = label.map((e) => ({
          questionOfVisit: e.questionOfVisit,
          countType: null
        }))


        countBuyerVisit.map((e) => {
          buyerTypeVisit.map((j) => {
            if (e.questionOfVisit === j.questionOfVisit) {
              e.countType++;
            }
          })
        })

        countNormalVisit.map((e) => {
          normalTypeVisit.map((j) => {
            if (e.questionOfVisit === j.questionOfVisit) {
              e.countType++;
            }
          })
        })

        countBuyerVisit = countBuyerVisit.map(e => e.countType);
        countNormalVisit = countNormalVisit.map(e => e.countType);
        label = label.map(e => e.questionOfVisit);
        this.buyerTypeChartVisit(label, countBuyerVisit, countNormalVisit);
      },
      buyerSatistic(allBuyerUser) {
        console.log('allBuyerUser', allBuyerUser);

        let buyerType = [];
        buyerType = allBuyerUser.map((e) => ({
          typeOfMember: e.typeOfMember,
          questionOfObjective: e.questionOfObjective,
          questionOfVisit: e.questionOfVisit,
          countType: null
        })).filter((j) => j.typeOfMember === 'Buyer');
        buyerType.map((e) => {
          if (e.questionOfObjective !== 'เข้ามาเยี่ยมชม' && e.questionOfObjective !== 'เข้ามาซื้อผลผลิต' && e.questionOfObjective !== 'เข้ามาอ่าน ติดตามข้อมูลข่าวสาร') {
            e.questionOfObjective = 'อื่น ๆ'
          }
        })

        let normalType = [];
        normalType = allBuyerUser.map((e) => ({
          typeOfMember: e.typeOfMember,
          questionOfObjective: e.questionOfObjective,
          questionOfVisit: e.questionOfVisit,
          countType: null
        })).filter((j) => j.typeOfMember === 'Normal');
        normalType.map((e) => {
          if (e.questionOfObjective !== 'เข้ามาเยี่ยมชม' && e.questionOfObjective !== 'เข้ามาซื้อผลผลิต' && e.questionOfObjective !== 'เข้ามาอ่าน ติดตามข้อมูลข่าวสาร') {
            e.questionOfObjective = 'อื่น ๆ'
          }
        })

        let label = [];
        let countBuyer = [];
        let countNormal = [];
        let countType = [];
        label = allBuyerUser.filter((thing, index, self) => self.findIndex(t => t.questionOfObjective === thing.questionOfObjective) === index)
        label.map((e, index) => {
          console.log(e.questionOfObjective);
          if (e.questionOfObjective !== 'เข้ามาเยี่ยมชม' && e.questionOfObjective !== 'เข้ามาซื้อผลผลิต' && e.questionOfObjective !== 'เข้ามาอ่าน ติดตามข้อมูลข่าวสาร') {
            e.questionOfObjective = 'อื่น ๆ'
          }
        })
        label = label.filter((thing, index, self) => self.findIndex(t => t.questionOfObjective === thing.questionOfObjective) === index)

        countBuyer = label.map((e) => ({
          questionOfObjective: e.questionOfObjective,
          countType: null
        }))

        countNormal = label.map((e) => ({
          questionOfObjective: e.questionOfObjective,
          countType: null
        }))

        countBuyer.map((e) => {
          buyerType.map((j) => {
            if (e.questionOfObjective === j.questionOfObjective) {
              e.countType++;
            }
          })
        })

        countNormal.map((e) => {
          normalType.map((j) => {
            if (e.questionOfObjective === j.questionOfObjective) {
              e.countType++;
            }
          })
        })

        countBuyer = countBuyer.map(e => e.countType);
        countNormal = countNormal.map(e => e.countType);
        label = label.map(e => e.questionOfObjective);
        console.log('countType', countType);
        console.log('countBuyer', countBuyer);
        console.log('buyerType', buyerType);
        console.log('label', label);

        this.buyerTypeChart(label, countBuyer, countNormal);
      },
      getAllProduct() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getAllProductAdmin.php').then((res) => {
          this.productMk = res.data.productMk;
          this.allProduct = [...res.data.productMk];
          this.allProduct.sort((a, b) => new Date(b.addDate) - new Date(a.addDate));
          this.allProduct.map((e) => {
            const date = new Date(e.addDate);
            e.addDate = date.toLocaleDateString('th-TH', {
              year: 'numeric',
              month: 'long',
              day: 'numeric',
              hour: 'numeric',
              minute: 'numeric',
              second: 'numeric',
            })
          })
          this.allProduct.length = 5;
          console.log('allProduct', this.allProduct);
          console.log('productMk', this.productMk);
        }).then(() => {
          this.getTypeOfArgi();
        }).catch((err) => {
          console.log(err);
        })
      },
      getTypeOfArgi() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getTypeArgi.php').then((res) => {
          this.typeOfArgi = res.data.typeOfArgi.filter(e => {
            return e.nameTypeOfArgiMk !== null;
          })

          this.productType = this.productMk.filter((thing, index, self) => self.findIndex(t => t.nameTypeOfArgiMk === thing.nameTypeOfArgiMk && t.nameTypeOfArgiMk === thing.nameTypeOfArgiMk) === index)
          let countProduct = [];
          countProduct = this.productType.map((e) => ({
            nameTypeOfArgiMk: e.nameTypeOfArgiMk,
            countType: null
          }));

          this.productMk.map((e) => {
            countProduct.map((j) => {
              if (j.nameTypeOfArgiMk === e.nameTypeOfArgiMk) {
                j.countType++;
              }
            })
          })

          countProduct = countProduct.map(e => e.countType);

          this.productType = this.productType.map(e => e.nameTypeOfArgiMk);

          this.productBarChart(this.productType, countProduct);

          console.log('productType', this.productType);
        }).catch((err) => {
          console.log(err);
        })
      },
      getAllSellerMember() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getAllSellerMember.php').then((res) => {
          this.sellerUser = res.data.sellerUser;
          console.log('sellerUser', this.sellerUser);
        }).then(() => {
          axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getAllBuyerMember.php').then((buyerUserRes) => {
            this.allBuyerUser = buyerUserRes.data.buyerUser;
            this.buyerSatistic(this.allBuyerUser);
            this.buyerSatisticVisit(this.allBuyerUser);
            this.allUser = [...this.sellerUser, ...buyerUserRes.data.buyerUser];
            this.allUser.sort((a, b) => new Date(b.registerDate) - new Date(a.registerDate));
            this.allUser.length = 5;
            this.allUser.map((e) => {
              const date = new Date(e.registerDate);
              e.registerDate = date.toLocaleDateString('th-TH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
              })
            })
            let buyer = buyerUserRes.data.buyerUser;
            let buyerCounter = 0;
            let normalCounter = 0;
            let sellerCounter = this.sellerUser.length;
            buyer.map(e => {
              if (e.typeOfMember === 'Buyer') {
                buyerCounter++;
              } else {
                normalCounter++;
              }
            });
            let userArr = [normalCounter, buyerCounter, sellerCounter];
            this.userBarChart(userArr);
            console.log('allUser', this.allUser);
            this.sellerUser.sort((a, b) => new Date(b.registerDate) - new Date(a.registerDate));
          }).catch((err) => {
            console.log(err);
          });
        });
      },
      todaySeller() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getTodaySeller.php').then((res) => {
          this.todayRegister += res.data.sellerUser.length;
        }).then(() => {
          axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getTodayBuyer.php').then((res) => {
            this.todayRegister += res.data.buyerUser.length;
          })
        });
      },
      getAllTodayProduct() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getAllTodayProduct.php').then((res) => {
          this.todayProduct += res.data.productMk.length;
        }).catch((err) => {
          console.log(err);
        })
      },
      // Bar
      buyerTypeChartVisit(label, buyerType, NormalType) {
        const barChart = {
          labels: label,
          datasets: [{
              label: "ผู้ซื้อ",
              backgroundColor: ["#3e95cd"],
              data: buyerType,
            },
            {
              label: "ทั่วไป",
              backgroundColor: ["#8e5ea2"],
              data: NormalType,
            }
          ]
        };

        const barChartOption = {
          tooltips: {
            enabled: true
          },
          hover: {
            animationDuration: 1
          },
        };

        const ctx = document.getElementById('buyerTypeChartVisit').getContext('2d');
        const createBarChart = new Chart(ctx, {
          type: 'bar',
          data: barChart,
          options: barChartOption
        });
      },
      buyerTypeChart(label, buyerType, NormalType) {
        const barChart = {
          labels: label,
          datasets: [{
              label: "ผู้ซื้อ",
              backgroundColor: ["#3e95cd"],
              data: buyerType,
            },
            {
              label: "ทั่วไป",
              backgroundColor: ["#8e5ea2"],
              data: NormalType,
            }
          ]
        };

        const barChartOption = {
          tooltips: {
            enabled: true
          },
          hover: {
            animationDuration: 1
          },
        };

        const ctx = document.getElementById('buyerTypeChart').getContext('2d');
        const createBarChart = new Chart(ctx, {
          type: 'bar',
          data: barChart,
          options: barChartOption
        });
      },
      productBarChart(productType, countProduct) {
        const barChart = {
          labels: productType,
          datasets: [{
            label: "จำนวนสินค้า",
            backgroundColor: ["#0275d8"],
            data: countProduct
          }]
        };

        const barChartOption = {
          tooltips: {
            enabled: true
          },
          hover: {
            animationDuration: 1
          },
        };

        const ctx = document.getElementById('barChart').getContext('2d');
        const createBarChart = new Chart(ctx, {
          type: 'bar',
          data: barChart,
          options: barChartOption
        });

      },
      userBarChart(userArr) {
        const barChart = {
          labels: ["ทั่วไป", "ผู้ซื้อ", "ผู้ขาย"],
          datasets: [{
            label: "จำนวนสมาชิก",
            backgroundColor: ["#f0ad4e"],
            data: userArr
          }]
        };

        const barChartOption = {
          tooltips: {
            enabled: true
          },
          hover: {
            animationDuration: 1
          },
        };

        const ctx = document.getElementById('userBarChart').getContext('2d');
        const createBarChart = new Chart(ctx, {
          type: 'bar',
          data: barChart,
          options: barChartOption
        });

      },
      // End Bar
    },
    mounted() {
      this.getAllProduct();
      this.getAllSellerMember();
      this.todaySeller();
      this.getAllTodayProduct();
    }
  });
</script>

</html>