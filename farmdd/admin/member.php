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
              <h1 class="m-0 text-dark">จัดการสมาชิก</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">จัดการสมาชิก</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ countMember.normal }}</h3>
                  <p>สถาชิกทั่วไป</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a type="button" @click="showUserTable('Normal')" class="small-box-footer">จัดการข้อมูล</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{ countMember.buyer }}</h3>

                  <p>สมาชิกผู้ซื้อ</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a type="button" @click="showUserTable('Buyer')" class="small-box-footer">จัดการข้อมูล</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ countMember.seller }}</h3>
                  <p>สมาชิกผู้ขาย</p>
                </div>
                <div class="icon">
                  <i class="fas fa-shopping-basket"></i>
                </div>
                <a type="button" @click="showUserTable('Seller')" class="small-box-footer">จัดการข้อมูล</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3>{{ countMember.normal + countMember.buyer + countMember.seller }}</h3>
                  <p>สมาชิกทั้งหมด</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a type="button" @click="showUserTable('All')" class="small-box-footer">จัดการข้อมูล</a>
              </div>
            </div>
          </div>

          <!-- Info boxes -->
          <!-- <div class="row">
            <div class="col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">ยืนยันแล้ว</span>
                  <span class="info-box-number"> {{ countMember.verify }} </span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">ยังไม่ได้ยืนยัน</span>
                  <span class="info-box-number"> {{ countMember.unVerify }} </span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">สมาชิกทั้งหมด</span>
                  <span class="info-box-number"> {{ countMember.normal + countMember.buyer + countMember.seller }} </span>
                </div>
              </div>
            </div>
          </div> -->
          <!-- Info boxes -->

          <!-- Expand Menu -->
          <b-container fluid v-if="showTable.all">
            <b-row class="mb-3">
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchMemberName($event.target.value, 'All')" type="text" placeholder="ค้นหาจากชื่อสมาชิก"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          <b-container fluid v-if="showTable.normal">
            <b-row class="mb-3">
              <b-col align-self="start" class="mr-auto" md="4">
                <a href="addBuyerMember.php?memberType=Normal" type="button" class="btn btn-success">เพิ่มสมาชิกทั่วไป</a>
              </b-col>
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchMemberName($event.target.value, 'Normal')" type="text" placeholder="ค้นหาจากชื่อสมาชิกทั่วไป"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          <b-container fluid v-if="showTable.buyer">
            <b-row class="mb-3">
              <b-col align-self="start" class="mr-auto" md="4">
                <a href="addBuyerMember.php?memberType=Buyer" type="button" class="btn btn-success">เพิ่มสมาชิกผู้ซื้อ</a>
              </b-col>
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchMemberName($event.target.value, 'Buyer')" type="text" placeholder="ค้นหาจากชื่อผู้ซื้อ"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          <b-container fluid v-if="showTable.seller">
            <b-row class="mb-3" cols="12">
              <b-col md="4">
                <a href="addSellerMember.php?memberType=Seller" type="button" class="btn btn-success">เพิ่มสมาชิกผู้ขาย</a>
              </b-col>
              <b-col md="4" class="ml-auto">
                <b-form-group id="input-group-3">
                  <label label-for="input-3">ประเภทผู้ขาย</label>
                  <b-form-select id="input-3" v-model="sellerArea" :options="areaOptions" @change="filterSellerByArea(sellerArea)"></b-form-select>
                </b-form-group>
              </b-col>
            </b-row>
            <b-row class="mb-3" cols="12">
              <b-col md="4" class="ml-auto">
                <b-input-group class="mb-2">
                  <b-form-input @keyup="searchMemberName($event.target.value, 'Seller')" type="text" placeholder="ค้นหาจากชื่อผู้ขาย"></b-form-input>
                  <b-input-group-prepend is-text>
                    <i class="fas fa-search"></i>
                  </b-input-group-prepend>
                </b-input-group>
              </b-col>
            </b-row>
          </b-container>

          </b-row>
          <!-- End Expand Menu -->

          <!-- Buyer Table -->
          <div class="container text-center" style="overflow-x:auto;" v-if="showTable.buyer">
            <b-row class="p-2">
              <h2>สมาชิกผู้ซื้อ</h2>
            </b-row>
            <b-table class="col-lg-12" :busy="isBusy" hover id="my-table" :items="buyerUser" :per-page="perPage" :current-page="currentPage" :fields="buyerFields" small>
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(buyerImg)="row">
                <b-img class="imgTable" :src="row.item.buyerImg" width="150" height="150" thumbnail></b-img>
              </template>
              <template #cell(statusOfMember)="row">
                <i v-if="row.item.statusOfMember === '1'" class="fas fa-check-circle fa-lg text-success"></i>
                <i v-if="row.item.statusOfMember === '0'" class="fas fa-times-circle fa-lg text-danger"></i>
              </template>
              <template #cell(typeOfMember)="row">
                {{ row.item.typeOfMember === 'Buyer' ? 'ผู้ซื้อ' : ''}}
              </template>
              <template #cell(confirmMember)="row">
                <b-button v-if="row.item.statusOfMember === '1'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="success" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
                <b-button v-else="row.item.statusOfMember === '0'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
              </template>
              <template #cell(actionsEdit)="row">
                <b-button size="md" @click="editBuyerMember(row.item, row.index, $event.target, 'Buyer')" variant="primary" class="mr-1">
                  <i class="fas fa-edit"></i>
                </b-button>
              </template>
              <template #cell(actionsDelete)="row">
                <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                  <i class="fas fa-trash"></i>
                </b-button>
              </template>
            </b-table>
            <b-pagination v-model="currentPage" :total-rows="buyerRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
          </div>
          <!-- End Buyer Table -->

          <!-- Normal Table -->
          <div class="container text-center" style="overflow-x:auto;" v-if="showTable.normal">
            <b-row class="p-2">
              <h2>สมาชิกทั่วไป</h2>
            </b-row>
            <b-table class="col-lg-12" hover id="my-table" :items="normalUser" :per-page="perPage" :current-page="currentPage" :fields="normalFields" small>
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(buyerImg)="row">
                <b-img class="imgTable" :src="row.item.buyerImg" width="150" height="150" fluid thumbnail></b-img>
              </template>
              <template #cell(statusOfMember)="row">
                <i v-if="row.item.statusOfMember === '1'" class="fas fa-check-circle fa-lg text-success"></i>
                <i v-if="row.item.statusOfMember === '0'" class="fas fa-times-circle fa-lg text-danger"></i>
              </template>
              <template #cell(confirmMember)="row">
                <b-button v-if="row.item.statusOfMember === '1'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="success" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
                <b-button v-else="row.item.statusOfMember === '0'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
              </template>
              <template #cell(typeOfMember)="row">
                {{ row.item.typeOfMember === 'Normal' ? 'ทั่วไป' : ''}}
              </template>
              <template #cell(actionsEdit)="row">
                <b-button size="md" @click="editBuyerMember(row.item, row.index, $event.target, 'Normal')" variant="primary" class="mr-1">
                  <i class="fas fa-edit"></i>
                </b-button>
              </template>
              <template #cell(actionsDelete)="row">
                <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                  <i class="fas fa-trash"></i>
                </b-button>
              </template>
            </b-table>
            <b-pagination v-model="currentPage" :total-rows="buyerRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
          </div>
          <!-- End Normal Table -->

          <!-- Seller Table -->
          <div class="container text-center" style="overflow-x:auto;" v-if="showTable.seller">
            <b-row class="p-2">
              <h2>สมาชิกผู้ขาย</h2>
            </b-row>
            <b-table class="col-lg-12" hover id="my-table" :items="sellerUser" :per-page="perPage" :current-page="currentPage" :fields="sellerFields" small>
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(idCard)="row">
                {{ (row.idCard || '-') }}
              </template>
              <template #cell(sellerImg)="row">
                <b-img class="imgTable" :src="row.item.sellerImg" width="150" height="150" fluid thumbnail></b-img>
              </template>
              <template #cell(statusOfMember)="row">
                <i v-if="row.item.statusOfMember === '1'" class="fas fa-check-circle fa-lg text-success"></i>
                <i v-if="row.item.statusOfMember === '0'" class="fas fa-times-circle fa-lg text-danger"></i>
              </template>
              <template #cell(nameOfMember)="row">
                {{ row.item.nameTypeOfSeller[0].nameTypeOfSeller }}
              </template>
              <template #cell(sellerProduct)="row">
                <b-button size="md" @click="productMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-shopping-basket"></i>
                </b-button>
              </template>
              <template #cell(confirmMember)="row">
                <b-button v-if="row.item.statusOfMember === '1'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="success" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
                <b-button v-else="row.item.statusOfMember === '0'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
              </template>
              <template #cell(actionsEdit)="row">
                <b-button size="md" @click="editSellerMember(row.item, row.index, $event.target)" variant="primary" class="mr-1">
                  <i class="fas fa-edit"></i>
                </b-button>
              </template>
              <template #cell(actionsDelete)="row">
                <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                  <i class="fas fa-trash"></i>
                </b-button>
              </template>
            </b-table>
            <b-pagination v-model="currentPage" :total-rows="sellerRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
          </div>
          <!-- End Seller Table -->

          <div class="row mt-3" v-if="showTable.product">
            <div class="col-md-3 mb-3">
              <a @click="addProduct()" type="button" class="btn btn-success text-white">เพิ่มสินค้า</a>
            </div>
            <div class="col-md-9 mb-3">
              <h4>สินค้าของกลุ่ม {{ groupName }}</h4>
            </div>
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
                  <b-button size="md" @click="editProduct(row.item, row.index, $event.target, 'SellerPage')" variant="primary" class="mr-1">
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

          <!-- All User -->
          <div class="container text-center" style="overflow-x:auto;" v-if="showTable.all">
            <b-row class="p-2">
              <h2>สมาชิกทั้งหมด</h2>
            </b-row>
            <b-table class="col-lg-12" :busy="isBusy" hover id="my-table" :items="allUser" :per-page="perPage" :current-page="currentPage" :fields="allUserFields">
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(memberImg)="row">
                <b-img class="imgTable" :src="row.item.memberImg" width="150" height="150" thumbnail></b-img>
              </template>
              <template #cell(memberName)="row">
                {{ `${row.item.firstName} ${row.item.lastName}` }}
              </template>
              <template #cell(idCard)="row">
                {{ row.item.idCard || '-' }}
              </template>
              <template #cell(confirmMember)="row">
                <b-button v-if="row.item.statusOfMember === '1'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="success" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
                <b-button v-else="row.item.statusOfMember === '0'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
              </template>
              <template #cell(typeOfMember)="row">
                {{ row.item.typeOfMember === 'Buyer' ? 'ผู้ซื้อ' : row.item.typeOfMember === 'Normal' ? 'ทั่วไป' : 'ผู้ขาย' }}
              </template>
              <template #cell(actionsEdit)="row">
                <b-button size="md" @click="editAllMember(row.item, row.index, $event.target, 'All')" variant="primary" class="mr-1">
                  <i class="fas fa-edit"></i>
                </b-button>
              </template>
              <template #cell(actionsDelete)="row">
                <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                  <i class="fas fa-trash"></i>
                </b-button>
              </template>
            </b-table>
            <b-pagination v-model="currentPage" :total-rows="allUserRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
          </div>
          <!-- End All User -->

          <!-- Index User -->
          <div class="container text-center" style="overflow-x:auto;" v-if="showTable.index">
            <b-row class="p-2">
              <h2>สมาชิกที่ยังไม่ได้รับการยืนยัน</h2>
            </b-row>
            <b-table class="col-lg-12" :busy="isBusy" hover id="my-table" :items="indexUser" :per-page="perPage" :current-page="currentPage" :fields="allUserFields">
              <template #cell(index)="data">
                {{ (data.index + 1) }}
              </template>
              <template #cell(memberImg)="row">
                <b-img class="imgTable" :src="row.item.memberImg" width="150" height="150" thumbnail></b-img>
              </template>
              <template #cell(memberName)="row">
                {{ `${row.item.firstName} ${row.item.lastName}` }}
              </template>
              <template #cell(idCard)="row">
                {{ row.item.idCard || '-' }}
              </template>
              <template #cell(confirmMember)="row">
                <b-button v-if="row.item.statusOfMember === '0'" size="md" @click="confirmMember(row.item, row.index, $event.target)" variant="warning" class="mr-1">
                  <i class="fas fa-user-check"></i>
                </b-button>
              </template>
              <template #cell(typeOfMember)="row">
                {{ row.item.typeOfMember === 'Buyer' ? 'ผู้ซื้อ' : row.item.typeOfMember === 'Normal' ? 'ทั่วไป' : 'ผู้ขาย' }}
              </template>
              <template #cell(actionsEdit)="row">
                <b-button size="md" @click="editAllMember(row.item, row.index, $event.target, 'All')" variant="primary" class="mr-1">
                  <i class="fas fa-edit"></i>
                </b-button>
              </template>
              <template #cell(actionsDelete)="row">
                <b-button size="md" @click="deleteContent(row.item, row.index, $event.target)" variant="danger" class="mr-1">
                  <i class="fas fa-trash"></i>
                </b-button>
              </template>
            </b-table>
            <b-pagination v-model="currentPage" :total-rows="indexUserRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
          </div>
          <!-- End Index User -->

        </div>
      </section>
    </div>
    <?php include 'includes/footer.php' ?>
</body>
<script>
  var app = new Vue({
    el: '#vueapp_member',
    data: {
      sellerArea: "",
      cloneSellerMember: [],
      cloneBuyerMember: [],
      cloneNormalMember: [],
      cloneAllUser: [],
      areaOptions: [],
      isBusy: false,
      perPage: 12,
      currentPage: 1,
      buyerUser: [],
      sellerUser: [],
      normalUser: [],
      indexUser: [],
      sellerType: [],
      userInfo: [],
      showTable: {
        buyer: false,
        normal: false,
        seller: false,
        product: false,
        all: false,
        index: false,
      },
      countMember: {
        normal: null,
        buyer: null,
        seller: null,
        total: null,
        verify: null,
        unVerify: null,
      },
      buyerFields: [{
        key: 'index',
        label: 'ลำดับ',
      }, {
        key: 'buyerImg',
        label: 'รูปสมาชิก',
      }, {
        key: 'firstName',
        label: 'ชื่อ',
      }, {
        key: 'lastName',
        label: 'นามสกุล',
      }, {
        key: 'idCard',
        label: 'เลขบัตรประชาชน',
      }, {
        key: 'phoneNumber',
        label: 'หมายเลขโทรศัพท์'
      }, {
        key: 'typeOfMember',
        label: 'ประเภทสมาชิก'
      }, {
        key: 'confirmMember',
        label: 'ยืนยัน'
      }, {
        key: 'actionsEdit',
        label: 'แก้ไข'
      }, {
        key: 'actionsDelete',
        label: 'ลบ'
      }],
      normalFields: [{
        key: 'index',
        label: 'ลำดับ',
      }, {
        key: 'buyerImg',
        label: 'รูปสมาชิก',
      }, {
        key: 'firstName',
        label: 'ชื่อ',
      }, {
        key: 'lastName',
        label: 'นามสกุล',
      }, {
        key: 'idCard',
        label: 'เลขบัตรประชาชน',
      }, {
        key: 'phoneNumber',
        label: 'หมายเลขโทรศัพท์'
      }, {
        key: 'typeOfMember',
        label: 'ประเภทสมาชิก'
      }, {
        key: 'confirmMember',
        label: 'ยืนยัน'
      }, {
        key: 'actionsEdit',
        label: 'แก้ไข'
      }, {
        key: 'actionsDelete',
        label: 'ลบ'
      }],
      sellerFields: [{
        key: 'index',
        label: 'ลำดับ',
      }, {
        key: 'sellerImg',
        label: 'รูปสมาชิก',
      }, {
        key: 'firstName',
        label: 'ชื่อ',
      }, {
        key: 'lastName',
        label: 'นามสกุล',
      }, {
        key: 'idCard',
        label: 'เลขบัตรประชาชน',
      }, {
        key: 'phoneNumber',
        label: 'หมายเลขโทรศัพท์'
      }, {
        key: 'nameOfMember',
        label: 'ประเภทสมาชิก'
      }, {
        key: 'sellerProduct',
        label: 'สินค้า'
      }, {
        key: 'confirmMember',
        label: 'สถานะ'
      }, {
        key: 'actionsEdit',
        label: 'แก้ไข'
      }, {
        key: 'actionsDelete',
        label: 'ลบ'
      }],
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
        key: 'groupName',
        label: 'ชื่อองค์กร',
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
      allUserFields: [{
        key: 'index',
        label: 'ลำดับ',
      }, {
        key: 'memberImg',
        label: 'รูปภาพ',
      }, {
        key: 'memberName',
        label: 'ชื่อ'
      }, {
        key: 'idCard',
        label: 'เลขบัตรประชาชน'
      }, {
        key: 'phoneNumber',
        label: 'เบอร์โทรศัพท์'
      }, {
        key: 'typeOfMember',
        label: 'ประเภทสมาชิก'
      }, {
        key: 'confirmMember',
        label: 'ยืนยัน'
      }, {
        key: 'actionsEdit',
        label: 'แก้ไข'
      }, {
        key: 'actionsDelete',
        label: 'ลบ'
      }],
      productMk: [],
      idSeller: null,
      groupName: "",
      allUser: [],
    },
    computed: {
      buyerRows() {
        return this.buyerUser.length
      },
      sellerRows() {
        return this.sellerUser.length
      },
      productRows() {
        return this.productMk.length
      },
      allUserRows() {
        return this.allUser.length
      },
      indexUserRows() {
        return this.indexUser.length
      },
      checkProductSize: function() {
        if (this.productMk.length === 0) {
          return true;
        }
      },
    },
    methods: {
      filterSellerByArea(area) {
        this.sellerUser = [...this.cloneSellerMember];
        if (area !== '') {
          if (area === 'ทั้งหมด') {
            this.sellerUser = [...this.cloneSellerMember];
          } else {
            this.sellerUser = this.sellerUser.filter((seller) => {
              return seller.areaName === area
            });
          }
        }
      },
      searchMemberName(e, memberType) {
        if (memberType === 'Buyer') {
          this.buyerUser = [...this.cloneBuyerMember];
          if (e !== '') {
            this.buyerUser = this.buyerUser.filter((buyer) => {
              return buyer.firstName.includes(e);
            });
          }
        }

        if (memberType === 'Normal') {
          this.normalUser = [...this.cloneNormalMember];
          if (e !== '') {
            this.normalUser = this.normalUser.filter((normal) => {
              return normal.firstName.includes(e);
            });
          }
        }

        if (memberType === 'Seller') {
          this.sellerUser = [...this.cloneSellerMember];

          if (e !== '' && this.sellerArea !== '' && this.sellerArea !== 'ทั้งหมด') {
            console.log('1');
            this.sellerUser = this.sellerUser.filter((seller) => {
              return seller.firstName.includes(e) && seller.areaName === this.sellerArea;
            });
          }

          if (e === '' && this.sellerArea !== '' && this.sellerArea !== 'ทั้งหมด') {
            console.log('2');
            this.sellerUser = this.sellerUser.filter((seller) => {
              return seller.areaName === this.sellerArea;
            });
          } else {
            this.sellerUser = this.sellerUser.filter((seller) => {
              return seller.firstName.includes(e)
            });
          }

        }


        if (memberType === 'All') {
          this.allUser = [...this.cloneBuyerMember, ...this.cloneNormalMember, ...this.cloneSellerMember];
          if (e !== '') {
            this.allUser = this.allUser.filter((all) => {
              let fullName = `${all.firstName} ${all.lastName}`
              return fullName.includes(e);
            });
          } 
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
      editProduct(item, index, button) {
        window.location.href = `editProduct.php?idProductOfMemberMk=${item.idProductOfMemberMk}&idSellerMember=${item.idSellerMember}`
      },
      addProduct() {
        window.location.href = `addProduct.php?idSellerMember=${this.idSeller}`
      },
      toggleBusy() {
        this.isBusy = !this.isBusy
      },
      productMember(item, index, button) {
        this.idSeller = item.idSellerMember;
        const idSeller = new FormData();
        idSeller.append('idSellerMemberMk', item.idSellerMember);
        axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getProductBySeller.php', idSeller).then((res) => {
          this.productMk = res.data.productMk;
          if (this.groupName = this.productMk[0].groupName !== "") {
            this.groupName = this.productMk[0].groupName;
          } 
          this.showTable = {
              buyer: false,
              normal: false,
              seller: false,
              product: true,
            },
            console.log('productMk', this.productMk);
        }).catch((err) => {
          Swal.fire({
            icon: 'warning',
            title: 'สมาชิกยังไม่มีสินค้า',
            showConfirmButton: true,
          }).then((result) => {
            return
          })
        })
      },
      backProductMember(idSellerMember) {
        const idSeller = new FormData();
        idSeller.append('idSellerMemberMk', idSellerMember);
        axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getProductBySeller.php', idSeller).then((res) => {
          this.productMk = res.data.productMk;
          if (this.groupName = this.productMk[0].groupName !== "") {
            this.groupName = this.productMk[0].groupName;
          }
          this.showTable = {
              buyer: false,
              normal: false,
              index: false,
              seller: false,
              product: true,
            },
            console.log('productMk', this.productMk);
        }).catch((err) => {
          console.log(err);
        })
      },
      deleteContent(item, index, button) {
        Swal.fire({
          title: 'ต้องการลบสมาชิก ?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ยืนยัน',
          cancelButtonText: 'ยกเลิก',
        }).then((result) => {
          if (result.isConfirmed) {
            const userData = new FormData();
            userData.append('username', item.username);

            if (item.typeOfMember === 'Seller') {
              userData.append('table', 'SellerMember_MK');
            }

            if (item.typeOfMember === 'Normal' || item.typeOfMember === 'Buyer') {
              userData.append('table', 'BuyerMember_MK');
            }

            axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/member/postDeleteMember.php', userData).then((res) => {
              Swal.fire({
                icon: 'success',
                title: 'ลบสมาชิกสำเร็จ',
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
      showUserTable(userType) {
        isBusy = true;
        console.log(userType);
        if (userType === 'Buyer') {
          this.showTable = {
            buyer: true,
            normal: false,
            seller: false,
            all: false
          }
          isBusy = false;
        }

        if (userType === 'Normal') {
          this.showTable = {
            buyer: false,
            normal: true,
            seller: false,
            all: false
          }
        }

        if (userType === 'Seller') {
          this.showTable = {
            buyer: false,
            normal: false,
            seller: true,
            all: false
          }
        }

        if (userType === 'All') {
          this.showTable = {
            buyer: false,
            normal: false,
            seller: false,
            all: true
          }
        }
      },
      confirmMember(item, index, button) {
        if (item.statusOfMember === '1') {
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
              if (item.typeOfMember === 'Buyer' || 'Normal') {
                var updateSta = new FormData();
                updateSta.append('username', item.username);
                updateSta.append('table', 'BuyerMember_MK');
              }

              if (item.typeOfMember === 'Seller') {
                var updateSta = new FormData();
                updateSta.append('username', item.username);
                updateSta.append('sellerId', item.idSellerMember);
                updateSta.append('status', 'update');
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
          if (item.typeOfMember === 'Buyer' || item.typeOfMember === 'Normal') {
            var confirmData = new FormData();
            confirmData.append("username", item.username);
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
            confirmData.append("username", item.username);
            confirmData.append("status", 'add');
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
                      <span class="font-weight-bold">ประเภทสมาชิก</span> ${this.userInfo.typeOfMember === 'Seller' ? 'ผู้ขาย' : '-'}
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
      editAllMember(item, index, button) {
        if (item.typeOfMember === 'Buyer' || item.typeOfMember === 'Normal') {
          window.location.href = `editBuyerMember.php?username=${item.username}&memberType=${item.typeOfMember}`
        }

        if (item.typeOfMember === 'Seller') {
          window.location.href = `editSellerMember.php?username=${item.username}`
        }
      },
      editBuyerMember(item, index, button, type) {
        console.log(type);
        window.location.href = `editBuyerMember.php?username=${item.username}&memberType=${type}&idMember=${item.idBuyerMember}`
      },
      editSellerMember(item, index, button) {
        window.location.href = `editSellerMember.php?username=${item.username}&idMember=${item.idSellerMember}`
      },
      getAllBuyerMember() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getAllBuyerMember.php').then((res) => {
          if (res.data.buyerUser.length > 0) {
            this.allUser = res.data.buyerUser.map((e) => ({
              idMember: e.idBuyerMember,
              firstName: e.firstName,
              lastName: e.lastName,
              typeOfMember: e.typeOfMember,
              idCard: e.idCard,
              phoneNumber: e.phoneNumber,
              username: e.username,
              memberImg: `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${e.buyerImg}`,
              statusOfMember: e.statusOfMember,
            }));
            console.log('allUserOnBuyer', this.allUser);
            this.cloneAllUser = this.allUser;
            this.buyerUser = res.data.buyerUser;
            this.buyerUser.map((e, index) => {
              e.typeOfMember === 'Buyer' ? this.countMember.buyer++ : '';
              e.typeOfMember === 'Normal' ? this.countMember.normal++ : '';
              e.statusOfMember === '0' ? this.countMember.unVerify++ : this.countMember.verify++;
              e.buyerImg = `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${e.buyerImg}`;
            });
            this.normalUser = this.buyerUser.filter((e, index) => {
              return e.typeOfMember === 'Normal';
            })
            this.buyerUser = this.buyerUser.filter((e) => {
              return e.typeOfMember === 'Buyer';
            })
          }
          console.log('getAllBuyerMember', this.buyerUser);
          console.log('cloneAllUser', this.cloneAllUser);
          this.cloneBuyerMember = this.buyerUser;
          this.cloneNormalMember = this.normalUser;
        }).then(res => {
          this.getAllSellerMember();
        })
      },
      getAllSellerMember() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getAllSellerMember.php').then((res) => {
          if (res.data.sellerUser.length > 0) {
            let seller = [];
            this.areaOptions = res.data.sellerUser;
            this.areaOptions = this.areaOptions.filter((thing, index, self) => self.findIndex(t => t.areaName === thing.areaName && t.areaName === thing.areaName) === index)
            console.log('areaOptions', this.areaOptions);
            this.areaOptions = this.areaOptions.map((e) => ({
              value: e.areaName,
              text: e.areaName
            }));
            this.areaOptions.unshift({
              value: 'ทั้งหมด',
              text: 'ทั้งหมด'
            })
            seller = res.data.sellerUser.map((e) => ({
              idMember: e.idSellerMember,
              firstName: e.firstName,
              lastName: e.lastName,
              typeOfMember: e.typeOfMember,
              idCard: e.idCard,
              phoneNumber: e.phoneNumber,
              username: e.username,
              statusOfMember: e.statusOfMember,
              memberImg: `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${e.sellerImg}`
            }));
            this.allUser = [...this.allUser, ...seller];
            this.allUser.sort((a, b) => {
              return a.statusOfMember - b.statusOfMember;
            });
            this.indexUser = [...this.allUser];
            this.indexUser = this.indexUser.filter(e => {
              return e.statusOfMember === '0';
            })
            console.log('allUserOnSeller', this.allUser);
            this.sellerUser = res.data.sellerUser;
            this.sellerUser.map((e, index) => {
              e.typeOfMember === 'Seller' ? this.countMember.seller++ : '';
              e.statusOfMember === '0' ? this.countMember.unVerify++ : this.countMember.verify++;
              e.sellerImg = `https://farmtd.hrdi.or.th/farmdd/admin/upload/profile/${e.sellerImg}`;
            })
          }
          this.getAllTypeOfSeller();
          console.log('getAllSellerMember', this.sellerUser);
        }).catch((err) => {
          console.log(err);
        })
      },
      getAllTypeOfSeller() {
        axios.get('https://farmtd.hrdi.or.th/farmdd/admin/api/member/getTypeOfSeller.php').then((res) => {
          if (res.data.sellerType.length > 0) {
            this.sellerType = res.data.sellerType;
            this.sellerUser = this.sellerUser.map(res => Object.assign(res, {
              nameTypeOfSeller: this.sellerType.filter(ele => ele.idTypeOfSellerMK === res.idTypeOfSeller_MK)
            }))
          }
          console.log('getAllTypeOfSeller', this.sellerType);
          console.log('getAllSellerMember2', this.sellerUser);
          this.cloneSellerMember = this.sellerUser;
        }).catch((err) => {
          console.log(err);
        })
      },
    },
    mounted() {
      this.getAllBuyerMember();
      this.showTable.index = true
      switch (localStorage.table) {
        case ('Buyer'):
          this.showTable = {
            buyer: true,
            index: false
          }
          localStorage.table = '';
          break;
        case ('Normal'):
          this.showTable = {
            normal: true,
            index: false
          }
          localStorage.table = '';
          break;
        case ('Product'):
          this.backProductMember(localStorage.idSellerMember);
          localStorage.table = '';
          localStorage.idSellerMember = '';
          break;
        case ('Seller'):
          this.showTable = {
            seller: true,
            index: false
          }
          localStorage.table = '';
          break;
      }
    },
  })
</script>

</html>