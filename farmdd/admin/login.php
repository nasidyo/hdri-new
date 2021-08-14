<?php
include 'includes/header.php';
?>
<style>
  .login-block {
    float: left;
    width: 100%;
    padding: 100px 0;
  }

  .banner-sec {
    background: url('./upload/product/login-logo.jpeg') no-repeat left bottom;
    background-size: cover;
    background-position: center;
    min-height: 600px;
    border-radius: 0 10px 10px 0;
    padding: 0;
  }

  .container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 15px 20px 0px rgba(0, 0, 0, 0.1);
  }

  .carousel-inner {
    border-radius: 0 10px 10px 0;
  }

  .carousel-caption {
    text-align: left;
    left: 5%;
  }

  .login-sec {
    padding: 50px 30px;
    position: relative;
  }

  .login-sec .copy-text {
    position: absolute;
    width: 80%;
    bottom: 20px;
    font-size: 13px;
    text-align: center;
  }

  .login-sec .copy-text i {
    color: #2D3753;
  }

  .login-sec .copy-text a {
    color: #E36262;
  }

  .login-sec h2 {
    margin-bottom: 30px;
    font-weight: 800;
    font-size: 30px;
    color: #2D3753;
  }

  .login-sec h2:after {
    content: " ";
    width: 100px;
    height: 5px;
    background: #1976D2;
    display: block;
    margin-top: 20px;
    border-radius: 3px;
    margin-left: auto;
    margin-right: auto
  }

  .btn-login {
    background: #1976D2;
    color: #fff;
    font-weight: 600;
  }

  .banner-text {
    width: 70%;
    position: absolute;
    bottom: 40px;
    padding-left: 20px;
  }

  .banner-text h2 {
    color: #fff;
    font-weight: 600;
  }

  .banner-text h2:after {
    content: " ";
    width: 100px;
    height: 5px;
    background: #FFF;
    display: block;
    margin-top: 20px;
    border-radius: 3px;
  }

  .banner-text p {
    color: #fff;
  }
</style>

<body>
  <div class="login-block">
    <div class="container" id="vueAppLogin">
      <div class="row">
        <div class="col-md-8 banner-sec">
        </div>
        <div class="col-md-4 login-sec">
          <h2 class="text-center">ของดีบนดอย Admin</h2>
          <form class="login-form">
            <div class="form-group">
              <label for="exampleInputEmail1" class="text-uppercase">Username</label>
              <input v-model="username" type="text" class="form-control" placeholder="Username" required>

            </div>
            <div class="form-group">
              <label for="exampleInputPassword1" class="text-uppercase">Password</label>
              <input v-model="password" type="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
              <b-form-checkbox @change="statusChange" id="checkbox-1" v-model="statusAd" name="checkbox-1" value="AD" unchecked-value="">
                Active Directory
              </b-form-checkbox>
            </div>

            <div class="form-check">
              <button @click.prevent="submitLogin" type="button" class="btn btn-login float-right">เข้าสู่ระบบ</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/vue-upload-multiple-image@1.1.6/dist/vue-upload-multiple-image.js"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="https://unpkg.com/vue@latest/dist/vue.js"></script>
  <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
  <script src="https: //unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="dist/js/demo.js"></script>
</body>
<script>
  var app = new Vue({
    el: '#vueAppLogin',
    data() {
      return {
        username: "",
        password: "",
        statusAd: ''
      }
    },
    computed: {

    },
    methods: {
        statusChange() {
            console.log(this.statusAd);
        },
      errAlert(msg) {
        Swal.fire({
          icon: 'info',
          title: msg,
          showConfirmButton: true,
          allowOutsideClick: false,
        });
      },
      submitLogin() {
        if (this.username === '' || this.username === null || this.username === undefined) {
          this.errAlert('กรุณากรอกข้อมูลให้ครบถ้วน');
          return;
        }

        if (this.password === '' || this.password === null || this.password === undefined) {
          this.errAlert('กรุณากรอกข้อมูลให้ครบถ้วน');
          return;
        }
        const formData = new FormData();
        formData.append('username', this.username);
        formData.append('password', this.password);
        formData.append('usr-Ad', this.statusAd);
        axios.post('https://farmtd.hrdi.or.th/farmdd/admin/api/login/checkLogin.php', formData).then((res) => {
          if (res.data.msg === 'True') {
            localStorage.login = 'True';
            Swal.fire({
              icon: 'success',
              title: 'เข้าสู่ระบบสำเร็จ',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location = 'index.php';
            })
          }

          if (res.data.msg !== 'True') {
            Swal.fire({
              icon: 'error',
              title: res.data.msg,
              showConfirmButton: true,
              allowOutsideClick: false,
            });
            return;
          }

        }).catch((err) => {
          Swal.fire({
            icon: 'error',
            title: 'ไม่สามารถเข้าระบบได้ กรุณาตรวจสอบ Username และ Password จากผู้ดูแลระบบ Sever ของสถาบันอีกครั้ง',
            showConfirmButton: false,
            timer: 2000
          }).then(() => {
            window.location.reload();
          })
        })
      }
    },
    mounted() {},
  });
</script>

</html>