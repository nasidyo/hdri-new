<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="buyerRegister">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">เพิ่มสมาชิกผู้ขาย</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">เพิ่มสมาชิกผู้ขาย</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-sm-2">
              <b-button type="button" block style="background: #546E7A" @click="back()">ย้อนกลับ</b-button>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="col-lg-8 mx-auto">
          <b-card header="เพิ่มสมาชิกผู้ขาย" header-text-variant="white" header-tag="header" header-bg-variant="success">
            <b-card-text>
              <b-row>
                <b-col>
                  <label label-for="input-3">คำนำหน้า<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.prefix" :options="prefix" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-live">ชื่อเกษตรกร / กลุ่ม<span class="text-danger">*</span></label>
                  <b-form-input id="input-live" v-model="sellerForm.firstName" :state="nameState" placeholder="ชื่อเกษตรกร / กลุ่ม"></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    กรุณากรอกชื่อ
                  </b-form-invalid-feedback>
                </b-col>
                <b-col>
                  <label for="input-lastname">นามสกุล</label>
                  <b-form-input id="input-lastname" v-model="sellerForm.lastName" :state="lastNameState" placeholder="นามสกุล"></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    กรุณากรอกนามสกุล
                  </b-form-invalid-feedback>
                </b-col>
              </b-row>

              <b-row>
                <label for="input-gender">เพศ<span class="text-danger">*</span></label>
                <b-form-group>
                  <b-form-radio-group id="radio-group-1" v-model="sellerForm.gender" :options="genderOption" name="gender-options"></b-form-radio-group>
                </b-form-group>
              </b-row>

              <b-row>
                <b-form-group>
                  <b-container class="text-center" fluid id="preview">
                    <img v-if="url" fluid width="250" height="250" :src="url" />
                  </b-container>
                  <b-form-file class="mt-3" @change="onFileChange" accept="image/jpeg, image/png, image/gif"></b-form-file>
                </b-form-group>
              </b-row>

              <b-row>
                <b-form-group>
                  <label for="input-username">Username<span class="text-danger">*</span></label>
                  <b-form-input id="input-username" @keyup="checkUsername(sellerForm.username)" v-model="sellerForm.username" :state="usernameState" placeholder="Username" trim></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    Username นี้ถูกใช้งานไปแล้ว
                  </b-form-invalid-feedback>
                </b-form-group>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-password">รหัสผ่าน<span class="text-danger">*</span></label>
                    <b-form-input type="password" id="input-password" v-model="sellerForm.password" :state="passwordState" placeholder="Password"></b-form-input>
                    <b-form-invalid-feedback id="input-live-feedback">
                      {{ passwordMsg }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>

                <b-col>
                  <b-form-group>
                    <label for="input-cpassword">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                    <b-form-input type="password" id="input-cpassword" v-model="confirmPassword" :state="confirmPasswordState" placeholder="Confirm Password"></b-form-input>
                    <b-form-invalid-feedback id="input-live-feedback">
                      รหัสผ่านไม่ตรงกัน
                    </b-form-invalid-feedback>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-form-group>
                  <label for="input-email">อีเมล</label>
                  <b-form-input type="email" id="input-email" v-model="sellerForm.email" placeholder="อีเมล" trim></b-form-input>
                </b-form-group>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-tel">หมายเลขโทรศัพท์<span class="text-danger">*</span></label>
                    <b-form-input type="text" id="input-tel" v-model="sellerForm.phoneNumber" :state="phoneState" placeholder="หมายเลขโทรศัพท์" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-card">หมายเลขบัตรประชาชน</label>
                    <b-form-input type="text" id="input-card" v-model="sellerForm.idCard" placeholder="หมายเลขบัตรประชาชน" maxlength="13" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-line">ไลน์ไอดี</label>
                    <b-form-input type="text" id="input-line" v-model="sellerForm.lineId" placeholder="ไลน์ไอดี" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-facebook">Facebook</label>
                    <b-form-input type="text" id="input-facebook" v-model="sellerForm.facebookName" placeholder="Facebook" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-address">บ้านเลขที่</label>
                    <b-form-input type="text" id="input-address" v-model="sellerForm.address" placeholder="บ้านเลขที่" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-moo">หมู่ (ถ้ามี)</label>
                    <b-form-input type="text" id="input-moo" v-model="sellerForm.moo" placeholder="หมู่" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-road">ถนน</label>
                    <b-form-input type="text" id="input-road" v-model="sellerForm.road" placeholder="ถนน" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-road">รหัสไปรณีย์</label>
                    <b-form-input type="text" id="input-road" v-model="sellerForm.postcode" placeholder="รหัสไปรณีย์" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label label-for="input-3">จังหวัด<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.vProvinceId" :options="provinceOption" @change="findAreaByProvince(sellerForm.vProvinceId)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label label-for="input-3">อำเภอ<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.ampCode" :options="ampOption" @change="findTumbolByAmpCode(sellerForm.ampCode, sellerForm.vProvinceId)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label label-for="input-3">ตำบล<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.tambolCode" :options="tambolOption" required></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label label-for="input-3">ชื่อศูนย์<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.vLinkAreaDetailId" :options="vLinkAreaDetailIdOption" required></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label label-for="input-3">ลักษณะการจ่ายสินค้า<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="sellerForm.idTypeOfSeller" :options="idTypeOfSellerdOption" required></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-groupName">ชื่อกลุ่ม (ถ้ามี)</label>
                    <b-form-input type="text" id="input-groupName" v-model="sellerForm.groupName" placeholder="ชื่อกลุ่ม (ถ้ามี)"></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-shopName">ชื่อร้าน (ถ้ามี)</label>
                    <b-form-input type="text" id="input-shopName" v-model="sellerForm.shopName" placeholder="ชื่อร้าน (ถ้ามี)"></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-brandName">ชื่อตราสินค้า (ถ้ามี)</label>
                    <b-form-input type="text" id="input-brandName" v-model="sellerForm.brandName" placeholder="ชื่อตราสินค้า (ถ้ามี)"></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <label for="input-shopName">ชนิดสินค้าที่ต้องการจำหน่าย (เลือกได้มากกว่า 1 ชนิด)<span class="text-danger">*</span></label>
                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="sellerForm.productType" :options="checkboxOptions" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>

                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="sellerForm.productType" :options="checkboxOptions2" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>


                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="sellerForm.productType" :options="checkboxOptions3" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-button @click="submitForm" type="button" :disabled="isDisabled" block variant="primary">เพิ่มสมาชิกผู้ขาย</b-button>
            </b-card-text>
          </b-card>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php' ?>
</body>
<script>
  var app = new Vue({
    el: '#buyerRegister',
    data: {
      checkboxOptions: [{
          text: 'ข้าวและธัญพืซ',
          value: 'ข้าวและธัญพืซ'
        },
        {
          text: 'ผักและสมุนไพร',
          value: 'ผักและสมุนไพร'
        },
        {
          text: 'ไม้ผล',
          value: 'ไม้ผล'
        },
      ],
      checkboxOptions2: [{
          text: 'ไม้ดอกไม้ประดับ',
          value: 'ไม้ดอกไม้ประดับ'
        },
        {
          text: 'ผลิตภัณฑ์แปรรูป',
          value: 'ผลิตภัณฑ์แปรรูป'
        },
        {
          text: 'ชา กาแฟ และโกโก้',
          value: 'ชา กาแฟ และโกโก้'
        },
      ],
      checkboxOptions3: [{
          text: 'หัตถกรรม',
          value: 'หัตถกรรม'
        },
        {
          text: 'พืซท้องถิ่น',
          value: 'พืซท้องถิ่น'
        },
        {
          text: 'ปศุสัตว์ และประมง',
          value: 'ปศุสัตว์ และประมง'
        },
      ],
      confirmPassword: '',
      isDisabled: false,
      url: null,
      isUsernameExist: false,
      passwordMsg: '',
      targetFilter: [],
      sellerForm: {
        idTypeOfSeller: "",
        prefix: "",
        firstName: "",
        lastName: "",
        username: "",
        phoneNumber: "",
        email: "",
        idCard: "",
        gender: "",
        password: "",
        vProvinceId: "",
        vLinkAreaDetailId: "",
        productType: [],
        address: "",
        img: [],
        postcode: "",
        moo: "",
        road: "",
        tambolCode: "",
        ampCode: "",
        zipcode: "",
        groupName: "",
        shopName: "",
        brandName: "",
        lineId: "",
        facebookName: "",
      },
      allProvince: [],
      provinceOption: [],
      buyerAmphur: [],
      buyerAmphurOption: [],
      buyerTambol: [],
      buyerTambolOption: [],
      vLinkAreaDetailIdOption: [],
      idTypeOfSellerdOption: [],
      sellType: [],
      tambolOption: [],
      ampOption: [],
      genderOption: [{
          text: "ชาย",
          value: "ชาย"
        },
        {
          text: "หญิง",
          value: "หญิง"
        },
      ],
      qovOption: [{
          text: "ค้นหาจาก Google",
          value: "ค้นหาจาก Google"
        },
        {
          text: "เข้ามาในเว็บไซต์ของสถาบันวิจัยและพัฒนาพื้นที่สูง",
          value: "เข้ามาในเว็บไซต์ของสถาบันวิจัยและพัฒนาพื้นที่สูง"
        },
        {
          text: "เพื่อน / คนรู้จักแนะนำ",
          value: "เพื่อน / คนรู้จักแนะนำ"
        },
        {
          text: "อื่น ๆ",
          value: "อื่น ๆ"
        },
      ],
      objOption: [{
          text: "เข้ามาเยี่ยมชม",
          value: "เข้ามาเยี่ยมชม"
        },
        {
          text: "เข้ามาซื้อผลผลิต",
          value: "เข้ามาซื้อผลผลิต"
        },
        {
          text: "เข้ามาอ่าน ติดตามข้อมูลข่าวสาร",
          value: "เข้ามาอ่าน ติดตามข้อมูลข่าวสาร"
        },
        {
          text: "อื่น ๆ",
          value: "อื่น ๆ"
        },
      ],
      prefix: [],
    },
    computed: {
      nameState() {
        return this.sellerForm.firstName.length > 0 ? true : null
      },
      lastNameState() {
        return this.sellerForm.lastName.length > 0 ? true : null
      },
      usernameState() {
        if (this.isUsernameExist) {
          this.isDisabled = true;
          return false;
        } else if (this.sellerForm.username.length < 1) {
          this.isDisabled = false;
          return null;
          this.isDisabled = false;
        } else {
          return true;
        }
      },
      passwordState() {
        if (/[A-Z]+/.test(this.sellerForm.password) && /[0-9]/g.test(this.sellerForm.password) && /^[a-zA-Z0-9äöüÄÖÜ]*$/.test(this.sellerForm.password) && this.sellerForm.password.length >= 6) {
          this.isDisabled = false;
          return true;
        } else {
          if (/[A-Z]+/.test(this.sellerForm.password) === false && this.sellerForm.password.length > 0) {
            this.passwordMsg = 'ต้องมีตัวอักษรตัวใหญ่ในรหัสผ่าน';
            this.isDisabled = true;
            return false;
          }

          if (/[0-9]/g.test(this.sellerForm.password) === false && this.sellerForm.password.length > 0) {
            this.passwordMsg = 'ตัองมีตัวเลขในรหัสผ่าน';
            this.isDisabled = true;
            return false;
          }

          if (this.sellerForm.password.length < 6 && this.sellerForm.password.length > 0) {
            this.passwordMsg = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัว';
            this.isDisabled = true;
            return false;
          }

        }

      },
      confirmPasswordState() {
        if (this.confirmPassword.length < 1) {
          return null;
        } else if (this.sellerForm.password === this.confirmPassword) {
          this.isDisabled = false;
          return true;
        } else {
          if (this.sellerForm.password != this.confirmPassword)
            this.isDisabled = true;
          return false;
        }
      },
      phoneState() {
        return this.sellerForm.phoneNumber.length >= 10 ? true : null
      },
    },
    methods: {
      back() {
        window.history.back();
      },
      findTumbolByAmpCode(ampId, provinceId) {
        this.tambol = [];
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getTumbolByAmpProv.php?provinceId=${provinceId}&ampId=${ampId}`
          )
          .then((res) => {
            if (res.data.tambol.length > 0) {
              this.tambol = res.data.tambol;
              console.log('ampOption', this.ampOption);
            }
            console.log("getTumbolByAmpProv", this.tambol);
          });
      },
      findAmphurBuyer(provinceId) {
        this.buyerAmphur = [];
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getBuyerAmphur.php?provinceId=${provinceId}`
          )
          .then((res) => {
            this.buyerAmphur = res.data.buyerAmphur;
            console.log("getBuyerAmphur", this.buyerAmphur);
          });
      },
      getSellerType() {
        axios
          .get("https://farmtd.hrdi.or.th/farmdd/admin/api/getSellerType.php")
          .then((res) => {
            this.sellType = res.data.sellType;
            this.idTypeOfSellerdOption = this.sellType.map((e) => ({
              value: e.idTypeOfSeller,
              text: e.nameTypeOfSeller
            }))
            console.log("sellType", this.sellType);
          });
      },
      getProvince() {
        axios
          .get("https://farmtd.hrdi.or.th/farmdd/admin/api/getVLinkProvince.php")
          .then((res) => {
            if (res.data.vLinkProvince.length > 0) {
              this.province = [
                ...new Map(
                  res.data.vLinkProvince.map((item) => [item.provinceId, item])
                ).values(),
              ];
            }

            this.province = this.province.filter((item, index) => {
              return (
                item.provinceName !== "เลย" &&
                item.provinceName !== "ลำปาง" &&
                item.provinceName !== "แพร่"
              );
            });

            this.provinceOption = this.province.map((e) => ({
              value: e.provinceId,
              text: e.provinceName
            }))

            console.log("province", this.province);
          });
      },
      findAreaByProvince(provinceId) {
        this.getAmphurByProvince(provinceId);
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getVLinkTargetById.php?provinceId=${provinceId}`
          )
          .then((res) => {
            console.log("vTargetDetail", res.data.vTargetDetail);
            if (res.data.vTargetDetail.length > 0) {
              this.targetName = [
                ...new Map(
                  res.data.vTargetDetail.map((item) => [item.targetName, item])
                ).values(),
              ];
              this.getArea();
            }
          });
      },
      getAmphurByProvince(provinceId) {
        this.amphur = [];
        this.tambol = [];
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getAmphurById.php?provinceId=${provinceId}`
          )
          .then((res) => {
            if (res.data.amphur.length > 0) {
              this.amphur = res.data.amphur;
              this.ampOption = res.data.amphur.map(e => ({
                value: e.ampCode,
                text: e.ampT
              }))
            }
            console.log("getAmphurById", this.amphur);
          });
      },
      findTumbolByAmpCode(ampId, provinceId) {
        this.tambol = [];
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getTumbolByAmpProv.php?provinceId=${provinceId}&ampId=${ampId}`
          )
          .then((res) => {
            if (res.data.tambol.length > 0) {
              this.tambol = res.data.tambol;
              this.tambolOption = res.data.tambol.map(e => ({
                value: e.tamCode,
                text: e.tamT
              }))
            }
            console.log("getTumbolByAmpProv", this.tambol);
          });
      },
      checkUsername(username) {
        this.isUsernameExist = false;
        var usernameFormData = new FormData();
        usernameFormData.append("username", username);

        var userForm = {};
        usernameFormData.forEach(function(value, key) {
          userForm[key] = value;
        });
        axios
          .post(
            "https://farmtd.hrdi.or.th/farmdd/admin/api/checkUsername.php",
            JSON.stringify(userForm)
          )
          .then((res) => {
            if (res.data.username[0].username.length > 0) {
              this.isUsernameExist = true;
            }
          });
      },
      onFileChange(e) {
        const file = e.target.files[0];
        this.sellerForm.img = file;
        this.url = URL.createObjectURL(file);
      },
      errAlert(msg) {
        Swal.fire({
          icon: 'info',
          title: msg,
          showConfirmButton: true,
          allowOutsideClick: false,
        });
      },
      getPrefix() {
        axios
          .get("https://farmtd.hrdi.or.th/farmdd/admin/api/getPrefix.php")
          .then((res) => {
            this.prefix = res.data.prefix.map(e => ({
              value: e.idPrefix,
              text: e.prefixNameTh
            }))
            console.log(this.prefix);
          });
      },
      submitForm() {
        console.log(this.sellerForm);
        if (this.sellerForm.prefix === "") {
          this.errAlert('กรุณาเลือกคำนำหน้า');
          return
        }

        if (this.sellerForm.firstName === "") {
          this.errAlert('กรุณากรอกชื่อ');
          return
        }

        if (this.sellerForm.gender === "") {
          this.errAlert('กรุณากรอกเพศ');
          return
        }

        if (this.sellerForm.img === "") {
          this.errAlert('กรุณาเลือกรูปภาพ');
          return
        }

        if (this.sellerForm.username === "") {
          this.errAlert('กรุณากรอก Username');
          return
        }

        if (this.sellerForm.username.indexOf(' ') >= 0) {
          console.log("ไม่อนุญาติให้มีช่องว่างในรหัสผ่าน");
        }

        if (this.sellerForm.password === "") {
          this.errAlert('กรุณากรอก Password');
          return
        }

        if (this.sellerForm.confirmPassword === "") {
          this.errAlert('กรุณายืนยัน Password');
          return
        }

        if (this.sellerForm.phoneNumber === "") {
          this.errAlert('กรุณากรอกหมายเลขโทรศัพท์');
          return
        }

        if (this.sellerForm.vProvinceId === "") {
          this.errAlert('กรุณาเลือกจังหวัด');
          return
        }

        if (this.sellerForm.ampCode === "") {
          this.errAlert('กรุณาเลือกอำเภอ');
          return
        }

        if (this.sellerForm.tambolCode === "") {
          this.errAlert('กรุณาเลือกตำบล');
          return
        }

        if (this.sellerForm.vLinkAreaDetailId === "") {
          this.errAlert('กรุณาเลือกชื่อศูนย์');
          return
        }

        if (this.sellerForm.idTypeOfSeller === "") {
          this.errAlert('กรุณาเลือกประเภทการจำหน่ายสินค้า');
          return
        }

        if (this.sellerForm.productType.length === 0) {
          this.errAlert('กรุณาเลือกชนิดสินค้าที่ต้องการจำหน่าย');
          return
        }

        var formData = new FormData();
        formData.append("address", this.sellerForm.address);
        formData.append("ampCode", this.sellerForm.ampCode);
        formData.append("brandName", this.sellerForm.brandName);
        formData.append("tambolCode", this.sellerForm.tambolCode);
        formData.append("email", this.sellerForm.email);
        formData.append("facebookName", this.sellerForm.facebookName);
        formData.append("firstName", this.sellerForm.firstName);
        formData.append("gender", this.sellerForm.gender);
        formData.append("groupName", this.sellerForm.groupName);
        formData.append("idCard", this.sellerForm.idCard);
        formData.append("idTypeOfSeller", this.sellerForm.idTypeOfSeller);
        formData.append("lastName", this.sellerForm.lastName);
        formData.append("lineId", this.sellerForm.lineId);
        formData.append("moo", this.sellerForm.moo);
        formData.append("img", this.sellerForm.img);
        formData.append("password", this.sellerForm.password);
        formData.append("postcode", this.sellerForm.postcode);
        formData.append("phoneNumber", this.sellerForm.phoneNumber);
        formData.append("prefix", this.sellerForm.prefix);
        formData.append("productType", this.sellerForm.productType);
        formData.append("road", this.sellerForm.road);
        formData.append("shopName", this.sellerForm.shopName);
        formData.append("username", this.sellerForm.username);
        formData.append("vLinkAreaDetailId", this.sellerForm.vLinkAreaDetailId);
        formData.append("vProvinceId", this.sellerForm.vProvinceId);
        formData.append("zipcode", this.sellerForm.zipcode);
        var contentForm = {};
        formData.forEach(function(value, key) {
          console.log(value);
          contentForm[key] = value;
        });

        axios
          .post(
            "https://farmtd.hrdi.or.th/farmdd/admin/api/postAddSellerMember.php",
            formData, {
              headers: {
                "Content-Type": "multipart/form-data",
              },
            }
          )
          .then((res) => {
            if (res.data === "True") {
              Swal
                .fire({
                  icon: "success",
                  title: "เพิ่มสมาชิกผู้ขายสำเร็จ",
                  showConfirmButton: false,
                  timer: 2000,
                })
                .then(() => {
                  window.location = "member.php";
                });
            } else {
              Swal
                .fire({
                  icon: "error",
                  title: "เกิดข้อผิดพลาด",
                  text: "ไม่สามารถสมัครสมาชิกได้",
                  showConfirmButton: false,
                  timer: 2000,
                })
                .then(() => {
                  window.location = "member.php";
                });
            }
          });
      },
      findAmphurBuyer(provinceId) {
        this.buyerAmphur = [];
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getBuyerAmphur.php?provinceId=${provinceId}`
          )
          .then((res) => {
            this.buyerAmphur = res.data.buyerAmphur;
            this.buyerAmphurOption = this.buyerAmphur.map((e) => ({
              value: e.ampCode,
              text: e.ampT
            }))
            console.log("getBuyerAmphur", this.buyerAmphur);
          });
      },
      findTambolBuyer(provinceId, amphurId) {
        axios
          .get(
            `https://farmtd.hrdi.or.th/farmdd/admin/api/getBuyerTambol.php?provinceId=${provinceId}&amphurId=${amphurId}`
          )
          .then((res) => {
            if (res.data.buyerTambol.length > 0) {
              this.buyerTambol = res.data.buyerTambol;
              this.buyerTambolOption = this.buyerTambol.map((e) => ({
                value: e.tamCode,
                text: e.tamT
              }))
            }
            console.log("getBuyerTambol", this.buyerTambol);
          });
      },
      getArea() {
        axios
          .get(`https://farmtd.hrdi.or.th/farmdd/admin/api/getAllArea.php`)
          .then((res) => {
            this.targetName = this.targetName.map((item) => item.targetId);
            console.log("targetName", this.targetName);
            if (res.data.area.length > 0) {
              this.area = res.data.area;
            }
            this.targetFilter = res.data.area.filter((item) =>
              this.targetName.includes(item.idArea)
            );
            this.vLinkAreaDetailIdOption = this.targetFilter.map(e => ({
              value: e.idArea,
              text: e.areaName,
            }))
            console.log("targetFilter", this.targetFilter);
          });
      },
    },
    async mounted() {
      let urlParams = new URLSearchParams(window.location.search);
      this.sellerForm.typeOfMember = urlParams.get('memberType');
      await this.getPrefix();
      await this.getProvince();
      await this.getArea();
      await this.getSellerType();
      localStorage.table = this.sellerForm.typeOfMember;
    },
  })
</script>


</html>