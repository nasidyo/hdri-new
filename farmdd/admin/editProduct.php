<?php
include 'includes/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <?php include 'includes/navbar.php' ?>

    <div class="content-wrapper" id="addProduct">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">แก้ไขสินค้า</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">หน้าแรก</a></li>
                <li class="breadcrumb-item active">แก้ไขสินค้า</li>
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
          <b-card header="แก้ไขสินค้า" header-text-variant="white" header-tag="header" header-bg-variant="success" v-if="isLoading">
            <b-card-text>
              <div v-if="isLoading" class="d-flex justify-content-center mb-3">
                <b-spinner variant="primary" style="width: 30rem; height: 30rem;" label="Large Spinner"></b-spinner>
              </div>
            </b-card-text>
          </b-card>
          <b-card header="แก้ไขสินค้า" header-text-variant="white" header-tag="header" header-bg-variant="success" v-if="formStep.step1 && !isLoading">
            <b-card-text>
              <b-row>
                <b-col>
                  <label label-for="input-3">หมวดผลผลิต<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.idTypeOfArgi" :options="typeOfArgiOptions" @change="findProductName(productForm.idTypeOfArgi)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-live">ผลผลิต<span class="text-danger">*</span></label>
                  <b-form-input id="input-live" v-model="productForm.idAgri" placeholder="ผลผลิต"></b-form-input>
                </b-col>
                <b-col>
                  <label for="input-live">สายพันธ์ุ</label>
                  <b-form-input id="input-live" v-model="productForm.speciesArgi" placeholder=""></b-form-input>
                </b-col>
                <!-- <b-col>
                  <label label-for="input-3">ผลผลิต<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.idAgri" :options="productByArgiTypeOptions" @change="findSpecies(productForm.idAgri)" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label label-for="input-3">สายพันธ์</label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.speciesArgi" :options="speciesItemOptions"></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row> -->
              <!-- 
              <b-row>
                <b-col>
                  <label label-for="input-3">ค้นหาพื้นที่จากจังหวัด</label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="province" :options="provinceOptions" @change="findAreaFromProvince()"></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-col>
                    <label label-for="input-3">กรองสมาชิกจากพื้นที่</label>
                    <b-form-group id="input-group-3">
                      <b-form-select id="input-3" v-model="areaId" :options="areaOptions" @change="findSellerFormArea()" required></b-form-select>
                    </b-form-group>
                  </b-col>
              </b-row> -->

              <!-- <b-row>
                <b-col>
                  <label label-for="input-3">สมาชิกที่ต้องการเพิ่มสินค้า<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.idSellerMember" :options="idSellerMemberOptions" required></b-form-select>
                  </b-form-group>
                </b-col>
              </b-row> -->

              <b-row>
                <b-col>
                  <label label-for="input-3">รูปภาพสินค้า (สูงสุด 5 รูปภาพ)<span class="text-danger">*</span></label>
                  <b-form-file multiple accept="image/*" @change="previewMultiImage">
                    <template slot="file-name" slot-scope="{ names }">
                      <b-badge variant="dark">{{ names[0] }}</b-badge>
                    </template>
                  </b-form-file>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col v-for="item, index in oldImg" :key="index" cols="4" class="p-2">
                  <img :src="item.imgTitle" width="175" height="175" />
                  <p class="mb-0">{{ item.imgName }}</p>
                  <!-- <b-badge variant="info">(รูปเดิม)</b-badge> -->
                  <b-btn variant="danger" @click="deleteOldImg(item.productImgId, item.imgTitle)" size="sm"><i class="fas fa-trash"></i></b-btn>
                  <b-btn v-if="item.imgTitle === productForm.titleImg" variant="primary" size="sm">รูปปกปัจจุบัน</b-btn>
                  <b-btn v-if="item.imgTitle !== productForm.titleImg" :variant="item.imgName === chooseTitle ? 'primary' : 'secondary'" @click="titleImgChoose(index, item.imgName, 'oldImg')" size="sm">รูปปก</b-btn>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col v-for="item, index in preview_list" :key="index" cols="4" class="p-2">
                  <img :src="item" width="175" height="175" />
                  <p class="mb-0">{{ image_list[index].name }}</p>
                  <!-- <p>Size: {{ image_list[index].size / (1024*1024) }}MB</p> -->
                  <b-btn :variant="image_list[index].name === chooseTitle ? 'success' : 'secondary'" @click="titleImgChoose(index, image_list[index].name, 'newImg')" size="sm">รูปปก</b-btn>
                  <b-btn variant="danger" @click="deleteImg(index)" size="sm"><i class="fas fa-trash"></i></b-btn>
                </b-col>
              </b-row>

              <b-row class="mt-3">
                <b-col>
                  <label label-for="input-3">รายละเอียดสินค้า<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-textarea id="textarea" v-model="productForm.detailOfProduct" placeholder="รายละเอียดสินค้า..." rows="3" max-rows="6" required></b-form-textarea>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label for="input-live">ขนาดบรรจุ</label>
                  <b-form-input id="input-live" v-model="productForm.sizeOfProduct" placeholder="ขนาดบรรจุ"></b-form-input>
                </b-col>
                <b-col>
                  <label label-for="input-3">หน่วย<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.unit" :options="unitMkOptions" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-live">ราคาเริ่มต้น</label>
                  <b-form-input type="number" min="0" id="input-live" v-model="productForm.priceBegin" placeholder="ราคาเริ่มต้น" required></b-form-input>
                </b-col>
                <b-col>
                  <label for="input-live">ราคาสิ้นสุด</label>
                  <b-form-input type="number" min="0" id="input-live" v-model="productForm.priceEnd" placeholder="ราคาสิ้นสุด" required></b-form-input>
                </b-col>
              </b-row>

              <b-row>
                <label for="input-shopName">ช่วงเวลาที่เก็บเกี่ยวผลผลิต<span class="text-danger">*</span></label>
                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="productForm.monthOfProduct" :options="checkboxOptions" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="productForm.monthOfProduct" :options="checkboxOptions2" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group>
                    <b-form-checkbox-group v-model="productForm.monthOfProduct" :options="checkboxOptions3" plain stacked></b-form-checkbox-group>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label label-for="input-3">มาตรฐานผลผลิต<span class="text-danger">*</span></label>
                  <b-form-group id="input-group-3">
                    <b-form-select id="input-3" v-model="productForm.idTypeOfStand" :options="typeOfStandOptions" required></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-live">การผลิตตามออเดอร์</label>
                  <b-form-input id="input-live" v-model="productForm.madeByOrder" placeholder="การผลิตตามออเดอร์" required></b-form-input>
                </b-col>
              </b-row>

              <b-row>
                <b-col>
                  <label for="input-qov">แนะนำสินค้าหรือไม่ (แสดงหน้าแรก)<span class="text-danger">*</span></label>
                  <b-form-group>
                    <b-form-radio-group id="radio-group-qov" v-model="productForm.suggestOption" :options="suggestOption" name="sug-options" plain stacked></b-form-radio-group>
                  </b-form-group>
                </b-col>
                <b-col>
                  <label for="input-qov">เผยแพร่สินค้าหรือไม่<span class="text-danger">*</span></label>
                  <b-form-group>
                    <b-form-radio-group id="radio-group-qov" v-model="productForm.publish" :options="publishOption" name="pub-options" plain stacked></b-form-radio-group>
                  </b-form-group>
                </b-col>
              </b-row>

              <b-button @click="submitForm" type="button" :disabled="isDisabled" block variant="primary">บันทึกสินค้า</b-button>
            </b-card-text>
          </b-card>
        </div>
      </section>
    </div>

    <?php include 'includes/footer.php' ?>
</body>
<script>
  var app = new Vue({
    el: '#addProduct',
    data: {
      chooseIndex: null,
      chooseTitle: null,
      chooseType: null,
      province: "",
      areaId: null,
      isDisabled: false,
      productForm: {
        idTypeOfArgi: "",
        idAgri: "",
        speciesArgi: "",
        detailOfProduct: "",
        sizeOfProduct: "",
        unit: "",
        priceBegin: "",
        idSellerMember: "",
        priceEnd: "",
        monthOfProduct: [],
        idTypeOfStand: "",
        madeByOrder: "",
        suggestOption: "",
        publish: "",
        imgCurFiles: [],
        img: [],
        vLink: [],
      },
      preview_list: [],
      suggestOption: [{
          text: "แนะนำ",
          value: "1"
        },
        {
          text: "ไม่แนะนำ",
          value: "0"
        },
      ],
      publishOption: [{
          text: "เผยแพร่",
          value: "1"
        },
        {
          text: "ไม่เผยแพร่",
          value: "0"
        },
      ],
      checkboxOptions: [{
          text: 'มกราคม',
          value: '1'
        },
        {
          text: 'เมษายน',
          value: '4'
        },
        {
          text: 'กรกฎาคม',
          value: '7'
        },
        {
          text: 'ตุลาคม',
          value: '10'
        },
      ],
      checkboxOptions2: [{
          text: 'กุมภาพันธ์',
          value: '2'
        },
        {
          text: 'พฤษภาคม',
          value: '5'
        },
        {
          text: 'สิงหาคม',
          value: '8'
        },
        {
          text: 'พฤศจิกายน',
          value: '11'
        },
      ],
      checkboxOptions3: [{
          text: 'มีนาคม',
          value: '3'
        },
        {
          text: 'มิถุนายน',
          value: '6'
        },
        {
          text: 'กันยายน',
          value: '9'
        },
        {
          text: 'ธันวาคม',
          value: '12'
        },
      ],
      area: [],
      areaOptions: [],
      typeOfArgi: [],
      typeOfArgiOptions: [],
      productByArgiType: [],
      productByArgiTypeOptions: [],
      argiTd: [],
      speciesItem: [],
      speciesItemOptions: [],
      unitMk: [],
      unitMkOptions: [],
      typeOfStand: [],
      provinceOptions: [],
      province: [],
      typeOfStandOptions: [],
      idSellerMemberOptions: [],
      sellerOptionClone: [],
      image_list: [],
      oldImg: [],
      formStep: {
        step1: true,
        step2: false,
      },
      isLoading: false,
      baseUrl: "https://farmtd.hrdi.or.th/farmdd/admin/api/",
    },
    computed: {

    },
    methods: {
      deleteOldImg(productImgId, imgName) {
        if (this.oldImg.length === 1) {
          this.errAlert('ต้องมีรูปภาพอย่างน้อย 1 รูป');
          return;
        }

        if (this.productForm.titleImg === imgName) {
          this.errAlert('ไม่สามารถลบรูปภาพหน้าปกได้');
          return;
        }
        Swal.fire({
          title: 'ต้องการลบรูปสินค้าหรือไม่ ?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ยืนยัน',
          cancelButtonText: 'ยกเลิก',
        }).then((result) => {
          if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('productImgId', productImgId);
            axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/postDeleteImgProduct.php', formData).then((res) => {
              Swal.fire({
                icon: 'success',
                title: 'ลบรูปภาพสินค้าสำเร็จ',
                showConfirmButton: false,
                timer: 1000
              }).then((result) => {
                this.getProductImg();
              })
            }).catch(err => {
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
      deleteImg(index) {
        this.preview_list.splice(index, 1);
        this.productForm.img.splice(index, 1);
      },  
      previewMultiImage: function(event) {
        var input = event.target;
        var count = input.files.length;
        var index = 0;
        if (input.files) {
          while (count--) {
            var reader = new FileReader();
            reader.onload = (e) => {
              this.preview_list.push(e.target.result);
            }
            this.productForm.img.push(input.files[index])
            this.image_list.push(input.files[index]);
            reader.readAsDataURL(input.files[index]);
            index++;
          }
        }
        console.log(this.productForm.img);
      },
      back() {
        window.history.back();
      },
      findAreaFromProvince() {
        this.getVLinkAreaDetail(this.province);
      },
      findSellerFormArea() {
        if (this.areaId === 0) {
          this.getSellerMember();
        } else {
          this.idSellerMemberOptions = [...this.sellerOptionClone];
          this.idSellerMemberOptions = this.idSellerMemberOptions.filter((e, i) => {
            return e.vLinkAreaDetailId_MK === this.areaId;
          });
        }
      },
      getVLinkAreaDetail(provinceId) {
        axios.get(`${this.baseUrl}getVLinkAreaDetail.php`).then((res) => {
          this.vLink = res.data.vLinkAreaDetail;
          this.vLink = this.vLink.filter((item) => {
            return item.provinceName !== 'เลย' && item.provinceName !== "ลำปาง" && item.provinceName !== "แพร่";
          })
          this.vLink = this.vLink.filter((thing, index, self) =>
            index === self.findIndex((t) => (
              t.targetAreaTypeTitle === thing.targetAreaTypeTitle && t.targetId === thing.targetId &&
              thing.targetName === t.targetName
            ))
          )

          this.areaOptions = this.vLink.filter((e) => {
            return e.provinceId === provinceId;
          })

          this.areaOptions = this.areaOptions.map((e) => ({
            value: e.targetId,
            text: e.targetName
          }));

          this.areaOptions.unshift({
            text: "ทั้งหมด",
            value: 0,
          });

          console.log('options2', this.areaOptions);

          console.log('vLinkAreaDetail', this.vLink);
        }).catch((err) => {
          console.log(err);
        })
      },
      submitForm() {
        console.log(this.productForm);

        if (this.productForm.speciesArgi === null) {
          this.productForm.speciesArgi = 0;
        }

        if (this.productForm.idTypeOfArgi === null || this.productForm.idTypeOfArgi === "" || this.productForm.idTypeOfArgi === undefined) {
          this.errAlert('กรุณาเลือกประเภทสินค้า');
          return;
        }

        if (this.productForm.idSellerMember === null || this.productForm.idSellerMember === "" || this.productForm.idSellerMember === undefined) {
          this.errAlert('กรุณาเลือกผู้ขาย');
          return;
        }

        if (this.productForm.idAgri === null || this.productForm.idAgri === "" || this.productForm.idAgri === undefined) {
          this.errAlert('กรุณาเลือกสินค้า');
          return;
        }

        if (this.productForm.detailOfProduct === null || this.productForm.detailOfProduct === "" || this.productForm.detailOfProduct === undefined) {
          this.errAlert('กรุณากรอกรายละเอียดสินค้า');
          return;
        }

        if (this.productForm.priceBegin === null || this.productForm.priceBegin === "" || this.productForm.priceBegin === undefined) {
          this.errAlert('กรุณากรอกราคาเริ่มต้น');
          return;
        }

        if (this.productForm.priceEnd === null || this.productForm.priceEnd === "" || this.productForm.priceEnd === undefined) {
          this.errAlert('กรุณากรอกราคาสูงสุด');
          return;
        }

        if (this.productForm.unit === null || this.productForm.unit === "" || this.productForm.unit === undefined) {
          this.errAlert('กรุณาเลือกหน่วย');
          return;
        }

        if (this.productForm.idTypeOfStand === null || this.productForm.idTypeOfStand === "" || this.productForm.idTypeOfStand === undefined) {
          this.errAlert('กรุณาเลือกมาตรฐานการผลิต');
          return;
        }

        if (this.productForm.monthOfProduct.length === 0) {
          this.errAlert('กรุณาเลือกเดือนที่เก็บเกี่ยวผลผลิต');
          return;
        }

        this.isFormValid = true;

        let formData = new FormData();
        formData.append("idTypeOfArgi", this.productForm.idTypeOfArgi);
        formData.append("detailOfProduct", this.productForm.detailOfProduct);
        formData.append("idSellerMember", this.productForm.idSellerMember);
        formData.append("idProductOfMemberMk", this.productForm.idProductOfMemberMk);
        formData.append("idAgri", this.productForm.idAgri);
        formData.append("madeByOrder", this.productForm.madeByOrder);
        formData.append("monthOfProduct", this.productForm.monthOfProduct);
        formData.append("priceBegin", this.productForm.priceBegin);
        formData.append("priceEnd", this.productForm.priceEnd);
        formData.append("sizeOfProduct", this.productForm.sizeOfProduct);
        formData.append("speciesArgi", this.productForm.speciesArgi);
        formData.append("typeOfStand", this.productForm.idTypeOfStand);
        formData.append("suggestOption", this.productForm.suggestOption)
        formData.append("publish", this.productForm.publish)
        formData.append("unit", this.productForm.unit);

        if (this.chooseType === 'oldImg') {
          formData.append("titleImg", this.oldImg[this.chooseIndex].imgName);
        }

        if (this.chooseType === 'newImg') {
          formData.append("titleImg", this.productForm.img[this.chooseIndex].name);
        }

        if (this.chooseType === null) {
          formData.append("titleImg", this.productForm.titleImg.substring(54));
        }


        if (this.productForm.img.length > 0) {
          if (this.productForm.img.length > 5 || this.productForm.img.length + this.oldImg.length > 5) {
            this.errAlert("ไม่สามาถเพิ่มรูปภาพได้เกิน 5 รูป");
            return;
          }

          var fileSize = 0;
          for (var i = 0; i < this.productForm.img.length; i++) {
            let file = this.productForm.img[i];
            fileSize += file.size;
            formData.append("img[" + i + "]", file);
            console.log(file);
          }

          if (fileSize > 8000000) {
            this.errAlert('ขนาดไฟล์รวมกันห้ามเกิน 8 MB');
            return;
          }
        }

        this.isLoading = true;

        axios
          .post(`${this.baseUrl}product/postUpdateProduct.php`, formData, {
            maxContentLength: Infinity,
            maxBodyLength: Infinity,
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((res) => {
            console.log(res);
            if (res.data === "True") {
              this.isLoading = false;
              Swal
                .fire({
                  icon: "success",
                  title: "แก้ไขสินค้าสำเร็จ",
                  showConfirmButton: false,
                  timer: 2000,
                })
                .then(() => {
                  window.location = "product.php";
                });
            }
          })
          .catch((err) => {
            if (err) {
              this.isLoading = false;
              console.log(err);
              Swal
                .fire({
                  icon: "error",
                  title: "เกิดข้อผิดพลาด",
                  text: "ไม่สามารถแก้ไขได้",
                  showConfirmButton: false,
                  timer: 2000,
                })
                .then(() => {
                  window.location = "product.php";
                });
            }
          });
      },
      formSubmit() {
        console.log(this.productForm);
      },
      errAlert(msg) {
        Swal.fire({
          icon: 'info',
          title: msg,
          showConfirmButton: true,
          allowOutsideClick: false,
        });
      },
      formStep2() {
        console.log(this.productForm);
        // if (this.formStep.step1) {
        //   (this.formStep.step1 = false), (this.formStep.step2 = true);
        // }
      },
      getTypeOFStand() {
        axios
          .get(`${this.baseUrl}product/getTypeOfStand.php`)
          .then((res) => {
            this.typeOfStand = res.data.typeOfStand;
            this.typeOfStandOptions = this.typeOfStand.map(e => ({
              value: e.nameTypeOfStand,
              text: e.nameTypeOfStand
            }));
            console.log("gettypeOfStand", this.typeOfStand);
          })
          .catch((err) => {
            console.log(err);
          });
      },
      getUnitMk() {
        axios
          .get(`${this.baseUrl}product/getUnitMk.php`)
          .then((res) => {
            this.unitMk = res.data.unitMk;

            this.unitMkOptions = this.unitMk.map((e) => ({
              value: e.idUnit,
              text: e.nameUnit
            }));
            console.log("unitMk", this.unitMk);
          })
          .catch((err) => {
            console.log(err);
          });
      },
      findSpecies() {
        console.log(this.productForm.idAgri);
        let agriId = new FormData();
        agriId.append("agriId", this.productForm.idAgri);
        axios
          .post(`${this.baseUrl}product/postSpeciesByArgi.php`, agriId)
          .then((res) => {
            if (res.data.species) {
              this.speciesItem = res.data.species;
              if (this.speciesItem.length === 0) {
                this.speciesItem[0] = {
                  agriId: this.productForm.idAgri,
                  speciesId: 0,
                  speciesName: "ไม่มี",
                };
              }

              this.speciesItemOptions = this.speciesItem.map((e) => ({
                value: e.speciesId,
                text: e.speciesName
              }));
              console.log("speciesItem", this.speciesItem);
            }
          })
          .catch((err) => {
            console.log(err);
          });
      },
      findProductName(type) {
        console.log('type', type);
        this.productByArgiType = [];
        this.productByArgiType = this.argiTd.filter((e) => {
          return e.TypeOfArgiIdTypeOfArgi === type;
        });

        this.productByArgiTypeOptions = this.productByArgiType.map((e) => ({
          value: e.idAgri,
          text: e.nameArgi
        }));
        console.log("productByArgiType", this.productByArgiType);
      },
      getArgiTd() {
        axios
          .get(`${this.baseUrl}product/getArgiTd.php`)
          .then((res) => {
            this.argiTd = res.data.argiTd;
            console.log("getArgiTd", this.argiTd);
          }).then((response) => {
            this.getProductDetail();
          })
          .catch((err) => {
            console.log(err);
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

              this.typeOfArgiOptions = this.typeOfArgi.map(e => ({
                value: e.idTypeOfArgi,
                text: e.nameTypeOfArgiMk
              }))

              console.log("typeOfArgi", this.typeOfArgi);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getSellerMember() {
        axios
          .get(`${this.baseUrl}member/getAllSellerMember.php`)
          .then((response) => {
            if (response.data.sellerUser !== 0) {
              this.sellerUser = response.data.sellerUser;

              this.idSellerMemberOptions = this.sellerUser.map(e => ({
                value: e.idSellerMember,
                vLinkAreaDetailId_MK: e.vLinkAreaDetailId_MK,
                text: `ชื่อ ${e.firstName} นามสกุล ${e.lastName} ชื่อกลุ่ม ${e.groupName || '-'}`
              }))

              this.sellerOptionClone = this.idSellerMemberOptions;

              console.log("sellerUser", this.idSellerMemberOptions);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getArea() {
        axios
          .get(`https://farmtd.hrdi.or.th/farmdd/admin/api/getAllArea.php`)
          .then((res) => {

            if (res.data.area.length > 0) {
              this.area = res.data.area;
            }

            this.areaOptions = this.area.map(e => ({
              value: e.idArea,
              text: e.areaName
            }))

            this.areaOptions.unshift({
              text: "ทั้งหมด",
              value: 0,
            }, this.areaOptions[0]);

            console.log("area", this.areaOptions);
          });
      },
      getProductDetail() {
        let formData = new FormData();
        formData.append('idProductOfMemberMk', this.productForm.idProductOfMemberMk)

        axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getProductDetail.php', formData).then((res) => {
          if (res.data.productMk.length !== 0) {
            this.productForm = res.data.productMk[0];
            this.productForm.suggestOption = res.data.productMk[0].suggestSta;
            this.productForm.monthOfProduct = res.data.productMk[0].monthOfProduct.split(',');
            this.productForm.img = [];

            if (this.productForm.speciesArgi !== '') {
              this.findSpecies();
            }

            if (this.productForm.idTypeOfArgi !== '') {
              this.findProductName(this.productForm.idTypeOfArgi);
            }

            console.log('productDetail', this.productForm);
          }
        }).then(() => {
          this.getProductImg();
        }).catch((err) => {
          console.log(err);
        })
      },
      getProductImg() {
        let formData = new FormData();
        formData.append('idProductOfMemberMk', this.productForm.idProductOfMemberMk)
        axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/product/getProductImg.php', formData).then((res) => {
          this.oldImg = res.data.productImgMk;
          console.log('oldImg', this.oldImg);
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

            this.provinceOptions = this.province.map(e => ({
              value: e.provinceId,
              text: e.provinceName
            }));

            console.log('province', this.province);
          });
      },
      titleImgChoose(index, chooseTitle, imgType) {
        this.chooseIndex = index;
        this.chooseTitle = chooseTitle;
        this.chooseType = imgType;
      }
    },
    mounted() {
      let urlParams = new URLSearchParams(window.location.search);
      this.productForm.idProductOfMemberMk = urlParams.get('idProductOfMemberMk');
      localStorage.idSellerMember = urlParams.get('idSellerMember');
      localStorage.table = 'Product';
      this.getArea();
      this.getProvince();
      this.getTypeOfArgi();
      this.getArgiTd();
      this.getUnitMk();
      this.getTypeOFStand();
      this.getSellerMember();
      this.getVLinkAreaDetail();
    },
  })
</script>
<style>
  #my-strictly-unique-vue-upload-multiple-image {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }

  h1,
  h2 {
    font-weight: normal;
  }

  ul {
    list-style-type: none;
    padding: 0;
  }

  li {
    display: inline-block;
    margin: 0 10px;
  }

  a {
    color: #42b983;
  }
</style>

</html>