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
              <h1 class="m-0 text-dark">{{ title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">{{ title }}</li>
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
          <b-card :header="title" header-text-variant="white" header-tag="header" header-bg-variant="success">
            <b-card-text>
              <b-row>
                <b-col>
                  <label label-for="input-3">คำนำหน้า<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="buyerForm.prefix" :options="prefix" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-live">ชื่อ<span class="text-danger">*</span></label>
                  <b-form-input id="input-live" v-model="buyerForm.firstName" :state="nameState" placeholder="ชื่อ"></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    กรุณากรอกชื่อ
                  </b-form-invalid-feedback>
                </b-col>
                <b-col>
                  <label for="input-lastname">นามสกุล</label>
                  <b-form-input id="input-lastname" v-model="buyerForm.lastName" :state="lastNameState" placeholder="นามสกุล"></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    กรุณากรอกนามสกุล
                  </b-form-invalid-feedback>
                </b-col>
              </b-row>

              <b-row>
                <label for="input-gender">เพศ<span class="text-danger">*</span></label>
                <b-form-group>
                  <b-form-radio-group id="radio-group-1" v-model="buyerForm.gender" :options="genderOption" name="gender-options"></b-form-radio-group>
                </b-form-group>
              </b-row>

              <b-row>
                <b-form-group>
                  <label for="input-image">รูปสมาชิก<span class="text-danger">*</span></label>
                  <b-container class="text-center" fluid id="preview">
                    <img v-if="url" fluid width="250" height="250" :src="url" />
                  </b-container>
                  <b-form-file class="mt-3" @change="onFileChange" accept="image/jpeg, image/png, image/gif"></b-form-file>
                </b-form-group>
              </b-row>

              <b-row>
                <b-form-group>
                  <label for="input-username">Username<span class="text-danger">*</span></label>
                  <b-form-input id="input-username" @keyup="checkUsername(buyerForm.username)" v-model="buyerForm.username" :state="usernameState" placeholder="Username" trim></b-form-input>
                  <b-form-invalid-feedback id="input-live-feedback">
                    Username นี้ถูกใช้งานไปแล้ว
                  </b-form-invalid-feedback>
                </b-form-group>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-password">รหัสผ่าน<span class="text-danger">*</span></label>
                    <b-form-input type="password" id="input-password" v-model="buyerForm.password" :state="passwordState" placeholder="Password"></b-form-input>
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
                  <b-form-input type="email" id="input-email" v-model="buyerForm.email" placeholder="อีเมล" trim></b-form-input>
                </b-form-group>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-tel">หมายเลขโทรศัพท์<span class="text-danger">*</span></label>
                    <b-form-input type="text" id="input-tel" v-model="buyerForm.phoneNumber" :state="phoneState" placeholder="หมายเลขโทรศัพท์" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-card">หมายเลขบัตรประชาชน</label>
                    <b-form-input type="text" id="input-card" v-model="buyerForm.idCard" placeholder="หมายเลขบัตรประชาชน" maxlength="13" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-line">ไลน์ไอดี</label>
                    <b-form-input type="text" id="input-line" v-model="buyerForm.lineId" placeholder="ไลน์ไอดี" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-facebook">Facebook</label>
                    <b-form-input type="text" id="input-facebook" v-model="buyerForm.facebookName" placeholder="Facebook" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <b-form-group>
                    <label for="input-address">บ้านเลขที่</label>
                    <b-form-input type="text" id="input-address" v-model="buyerForm.address" placeholder="บ้านเลขที่" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-moo">หมู่ (ถ้ามี)</label>
                    <b-form-input type="text" id="input-moo" v-model="buyerForm.moo" placeholder="หมู่" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-road">ถนน</label>
                    <b-form-input type="text" id="input-road" v-model="buyerForm.road" placeholder="ถนน" trim></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <label for="input-road">รหัสไปรย์ณีย์</label>
                    <b-form-input type="text" id="input-road" v-model="buyerForm.postcode" placeholder="รหัสไปรณีย์" trim></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label label-for="input-3">จังหวัด<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="buyerForm.provinceCode" :options="provinceOption" @change="findAmphurBuyer(buyerForm.provinceCode)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label label-for="input-3">อำเภอ<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="buyerForm.amphurCode" :options="buyerAmphurOption" @change="findTambolBuyer(buyerForm.provinceCode, buyerForm.amphurCode)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label label-for="input-3">ตำบล<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="buyerForm.tambolCode" :options="buyerTambolOption" required></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label for="input-qov">คุณรู้จักเว็บไซต์ของดีบนดอยได้อย่างไร<span class="text-danger">*</span></label>
                  <b-form-group>
                    <b-form-radio-group @change="questionBuyer(buyerForm.questionOfVisit)" id="radio-group-qov" v-model="buyerForm.questionOfVisit" :options="qovOption" name="qov-options" plain stacked></b-form-radio-group>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-obj">วัตถุประสงค์ที่สมัครสมาชิก<span class="text-danger">*</span></label>
                  <b-form-group>
                    <b-form-radio-group @change="questionObjBuyer(buyerForm.questionOfObjective)" id="radio-group-obj" v-model="buyerForm.questionOfObjective" :options="objOption" name="obj-options" plain stacked></b-form-radio-group>
                  </b-form-group>
                </b-col>
                <b-row>
                  <b-col>
                    <b-form-group>
                      <b-form-input v-if="showEtc.visit" type="text" id="input-visit" v-model="buyerForm.questionOfVisit" trim></b-form-input>
                    </b-form-group>
                  </b-col>
                  <b-col>
                    <b-form-group>
                      <b-form-input v-if="showEtc.objective" type="text" id="input-questionAnother" v-model="buyerForm.questionOfObjective" trim></b-form-input>
                    </b-form-group>
                  </b-col>
                </b-row>
              </b-row>

              <b-row>
                <b-button @click="submitForm" type="button" :disabled="isDisabled" block variant="primary">{{ title }}</b-button>
              </b-row>
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
      confirmPassword: '',
      isDisabled: false,
      url: null,
      isUsernameExist: false,
      passwordMsg: '',
      showEtc: {
        visit: false,
        objective: false,
      },
      buyerForm: {
        prefix: "",
        firstName: "",
        lastName: "",
        username: "",
        phoneNumber: "",
        email: "",
        idCard: "",
        password: "",
        img: [],
        provinceCode: "",
        postcode: "",
        typeOfMember: "",
        amphurCode: "",
        tambolCode: "",
        lineId: "",
        facebookName: "",
        address: "",
        moo: "",
        road: "",
        questionOfVisit: "",
        questionOfObjective: "",
      },
      allProvince: [],
      provinceOption: [],
      buyerAmphur: [],
      buyerAmphurOption: [],
      buyerTambol: [],
      buyerTambolOption: [],
      title: '',
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
        return this.buyerForm.firstName.length > 0 ? true : null
      },
      lastNameState() {
        return this.buyerForm.lastName.length > 0 ? true : null
      },
      usernameState() {
        if (this.isUsernameExist) {
          this.isDisabled = true;
          return false;
        } else if (this.buyerForm.username.length < 1) {
          this.isDisabled = false;
          return null;
          this.isDisabled = false;
        } else {
          return true;
        }
      },
      passwordState() {
        if (/[A-Z]+/.test(this.buyerForm.password) && /[0-9]/g.test(this.buyerForm.password) && /^[a-zA-Z0-9äöüÄÖÜ]*$/.test(this.buyerForm.password) && this.buyerForm.password.length >= 6) {
          this.isDisabled = false;
          return true;
        } else {
          if (/[A-Z]+/.test(this.buyerForm.password) === false && this.buyerForm.password.length > 0) {
            this.passwordMsg = 'ต้องมีตัวอักษรตัวใหญ่ในรหัสผ่าน';
            this.isDisabled = true;
            return false;
          }

          if (/[0-9]/g.test(this.buyerForm.password) === false && this.buyerForm.password.length > 0) {
            this.passwordMsg = 'ตัองมีตัวเลขในรหัสผ่าน';
            this.isDisabled = true;
            return false;
          }

          if (this.buyerForm.password.length < 6 && this.buyerForm.password.length > 0) {
            this.passwordMsg = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัว';
            this.isDisabled = true;
            return false;
          }

        }

      },
      confirmPasswordState() {
        if (this.confirmPassword.length < 1) {
          return null;
        } else if (this.buyerForm.password === this.confirmPassword) {
          this.isDisabled = false;
          return true;
        } else {
          if (this.buyerForm.password != this.confirmPassword)
            this.isDisabled = true;
          return false;
        }
      },
      phoneState() {
        return this.buyerForm.phoneNumber.length >= 10 ? true : null
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
    },
    methods: {
      back() {
        window.history.back();
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
      questionBuyer(select) {
        if (select === "อื่น ๆ") {
          this.showEtc.visit = true;
        } else {
          this.showEtc.visit = false;
        }
      },
      questionObjBuyer(select) {
        if (select === "อื่น ๆ") {
          this.showEtc.objective = true;
        } else {
          this.showEtc.objective = false;
        }
      },
      onFileChange(e) {
        const file = e.target.files[0];
        this.buyerForm.img = file;
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
        console.log(this.buyerForm);
        if (this.buyerForm.prefix === "") {
          this.errAlert('กรุณาเลือกคำนำหน้า');
          return
        }

        if (this.buyerForm.firstName === "") {
          this.errAlert('กรุณากรอกชื่อ');
          return
        }
        
        if (this.buyerForm.gender === "") {
          this.errAlert('กรุณากรอกเพศ');
          return
        }

        if (this.buyerForm.img === "") {
          this.errAlert('กรุณาเลือกรูปภาพ');
          return
        }

        if (this.buyerForm.username === "") {
          this.errAlert('กรุณากรอก Username');
          return
        }

        if (this.buyerForm.username.indexOf(' ') >= 0) {
          console.log("ไม่อนุญาติให้มีช่องว่างในรหัสผ่าน");
        }

        if (this.buyerForm.password === "") {
          this.errAlert('กรุณากรอก Password');
          return
        }

        if (this.buyerForm.confirmPassword === "") {
          this.errAlert('กรุณายืนยัน Password');
          return
        }

        if (this.buyerForm.phoneNumber === "") {
          this.errAlert('กรุณากรอกหมายเลขโทรศัพท์');
          return
        }

        if (this.buyerForm.provinceCode === "") {
          this.errAlert('กรุณาเลือกจังหวัด');
          return
        }

        if (this.buyerForm.amphurCode === "") {
          this.errAlert('กรุณาเลือกอำเภอ');
          return
        }

        if (this.buyerForm.tambolCode === "") {
          this.errAlert('กรุณาเลือกตำบล');
          return
        }

        if (this.buyerForm.questionOfVisit === "" || this.buyerForm.questionOfObjective === "") {
          this.errAlert('กรุณาเลือกเหตุผล');
          return
        }

        var formData = new FormData();
        formData.append("address", this.buyerForm.address);
        formData.append("amphurCode", this.buyerForm.amphurCode);
        formData.append("email", this.buyerForm.email);
        formData.append("facebookName", this.buyerForm.facebookName);
        formData.append("firstName", this.buyerForm.firstName);
        formData.append("idCard", this.buyerForm.idCard);
        formData.append("firstName", this.buyerForm.firstName);
        formData.append("gender", this.buyerForm.gender);
        formData.append("img", this.buyerForm.img);
        formData.append("typeOfMember", this.buyerForm.typeOfMember);
        formData.append("lastName", this.buyerForm.lastName);
        formData.append("postcode", this.buyerForm.postcode);
        formData.append("lineId", this.buyerForm.lineId);
        formData.append("moo", this.buyerForm.moo);
        formData.append("password", this.buyerForm.password);
        formData.append("phoneNumber", this.buyerForm.phoneNumber);
        formData.append("prefix", this.buyerForm.prefix);
        formData.append("provinceCode", this.buyerForm.provinceCode);
        formData.append(
          "questionOfObjective",
          this.buyerForm.questionOfObjective
        );
        formData.append("questionOfVisit", this.buyerForm.questionOfVisit);
        formData.append("road", this.buyerForm.road);
        formData.append("tambolCode", this.buyerForm.tambolCode);
        formData.append("username", this.buyerForm.username);

        var contentForm = {};
        formData.forEach(function(value, key) {
          console.log(value);
          contentForm[key] = value;
        });

        axios
          .post(
            "https://farmtd.hrdi.or.th/farmdd/admin/api/postAddBuyerMember.php",
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
                  title: "เพิ่มสมาชิกทั่วไป / ผู้ซื้อสำเร็จ",
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
      getAllProvince() {
        axios
          .get("https://farmtd.hrdi.or.th/farmdd/admin/api/getAllprovince.php")
          .then((res) => {
            if (res.data.allProvince.length > 0) {
              this.allProvince = res.data.allProvince;
              this.provinceOption = this.allProvince.map((e) => ({
                value: e.code,
                text: e.name
              }))
            }
            console.log("getAllprovince", this.allProvince);
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
    },
    mounted() {
      let urlParams = new URLSearchParams(window.location.search);
      this.buyerForm.typeOfMember = urlParams.get('memberType');
      if (this.buyerForm.typeOfMember == 'Normal') {
        this.title = 'เพิ่มสมาชิกทั่วไป';
      } else {
        this.title = 'เพิ่มสมาชิกผู้ซื้อ'
      }
      this.getPrefix();
      this.getAllProvince();
      localStorage.table = this.buyerForm.typeOfMember;
    },
  })
</script>


</html>