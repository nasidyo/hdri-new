<?php
$db = new Database();
$conn=  $db->getConnection();
?>

<div class="modal fade bd-example-modal-xl"  style="overflow-y:auto;" id="editFarmer" tabindex="-1" role="dialog" aria-labelledby="addFarmerModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style=" max-width: 1140px; ">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addFarmerModalLabel">แก้ไขข้อมูลเกษตกร</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
    <form class="form-horizontal" method="post" >
             <div class="card-body">
               <div class="card">
                <div class="card-header">
                  <strong class="card-title">พื้นที่</strong>
                </div>
                <div class="card-body">
                  <div class="form-group row">
                  <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                  <div class="col-sm-4">
                        <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                        <?php
                            echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                          ?>
                        </select>

                  </div>
                    </div>
                    <div class="form-group row">
                  <label class="col-sm-2 col-form-label">พื้นที่</label>
                  <div class="col-sm-8">
                    <select class="form-control"name="idArea" id="area">

                        </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ชื่อบ้าน</label>
                    <div class="col-sm-8">
                        <select class="form-control"name="idGroupVillage" id="idGroupVillage">

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                      <label class="col-sm-2 col-form-label">สาขาพืชที่ส่งเสริม</label>
                      <div class="col-sm-8">
                      <select id="argi_group_type" multiple="multiple">
                      <?php
                        $sql2="select *  from TypeOfArgi_TD";
                        $stmt = sqlsrv_query( $conn, $sql2 );

                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                          $id_pre=$row["idTypeOfArgi"];
                          $name_pre=$row["nameTypeOfArgi"];
                          echo "<option value='$id_pre' > $name_pre</option>";
                        }
                      ?>
                      </select>

                  </div>
                </div>
                <div class="form-group row">
                      <label class="col-sm-2 col-form-label">ชนิดพืชที่ส่งเสริม</label>
                      <div class="col-sm-8" style="padding: 10px 10px 10px 15px;">
                      <select id="argi_group" multiple="multiple">
                      </select>
                  </div>
                </div>

                </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <strong class="card-title">ข้อมูลเกษตรกร</strong>
                  </div>
                  <div class="card-body">
                <div class="form-group row">
                 <label for="inputext" class="col-sm-2 col-form-label">รูปเกษตรกร</label>
                 <div class="col-sm-2">
                 <img class="mx-auto d-block basic-img"   style=" height: 200px;float: left;" src='../images/noPic.jpg'>
                 </div>
                 <div class="col-sm-4">
                  <input type="file" id="file" name="file" class="form-control-file" accept="image/*" style="height: auto; ">

                 </div>
                 <div class="col-sm-4">
                  <div style="width:500px;margin:auto;">
                        <div id="qrcode"></div>
                    </div>

                  </div>
                 <input type="hidden" id="path" name="path">
                </div>
                <div class="form-group row">
                 <label for="inputext" class="col-sm-2 col-form-label">รหัสเกษตรกร</label>
                 <div class="col-sm-4">
                   <input type="text" class="form-control" name="argnumber" placeholder="รหัสเกษตรกร" readonly>
                 </div>

                 <label for="inputext" class="col-sm-2 col-form-label">เลขที่บัตรประชาชน</label>
                 <div class="col-sm-4">
                   <input type="text" class="form-control" name="argid" placeholder="เลขที่บัตรประชาชน" maxlength="13">
                 </div>
                </div>

               <div class="form-group row">
                 <label class="col-sm-2 col-form-label">ชื่อ-สกุล <span style="color:red"> *</span></label>
                    <div class="col-sm-2">
                     <select class="form-control"name="argpre">
                     <?php
                        $sql2="select *  from Prefix_TD";
                        $stmt = sqlsrv_query( $conn, $sql2 );

                        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                          $id_pre=$row["idPrefix"];
                          $name_pre=$row["prefixNameTh"];
                          echo "<option value='$id_pre'> $name_pre</option>";
                        }
                      ?>
                     </select>
                    </div>
                  <div class="col-sm-4">
                   <input type="text" class="form-control" name="argname" placeholder="ชื่อเจ้าหน้าที่">
                 </div>
                 <div class="col-sm-4">
                   <input type="text" class="form-control" name="argsurname" placeholder="นามสกุลเจ้าหน้าที่">
                 </div>
                </div>
                <div class="form-group row">

                <label  class="col-sm-2 col-form-label">ปีเกิด</label>
                 <div class="col-sm-4">

                 <input type="text" class="form-control" name="argbirth" placeholder="ปีเกิด">
                 </div>

                 <label  class="col-sm-2 col-form-label">ศาสนา</label>
                 <div class="col-sm-4">
                  <select class="form-control"name="religion">
                      <?php
                          $sql3="select *  from Religion";
                          $stmt = sqlsrv_query( $conn, $sql3 );

                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idReligion"];
                            $name_pre=$row["religionName"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                    </select>
                 </div>

               </div>
               <div class="form-group row">
               <label  class="col-sm-2 col-form-label">ชนเผ่า</label>
                 <div class="col-sm-4">
                   <select class="form-control"name="tribes">
                      <?php
                          $sql3="select *  from Tribes";
                          $stmt = sqlsrv_query( $conn, $sql3 );

                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idTribes"];
                            $name_pre=$row["nameTribes"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                      </select>
                 </div>

                 <label  class="col-sm-2 col-form-label">สถานะครัวเรือน</label>
                 <div class="col-sm-4">
                   <select class="form-control"name="pos_family">
                          <option value='หัวหน้าครัวเรือน'>หัวหน้าครัวเรือน</option>
                          <option value='สมาชิกในครัวเรือน'>สมาชิกในครัวเรือน</option>
                      </select>

                 </div>
               </div>
               <div class="form-group row">
                  <label  class="col-sm-2 col-form-label">จำนวนสมาชิก</label>
                      <div class="col-sm-4">
                        <input type="number" class="form-control" name="familyCount" placeholder="จำนวนสมาชิกครัวเรือน">
                      </div>
                      <label  class="col-sm-2 col-form-label">สถานะปัจจุบัน</label>
                      <div class="col-sm-4">
                            <select class="form-control"name="statusPerson" id="statusPerson">
                                <option value='มีชีวิตอยู่'>มีชีวิตอยู่</option>
                                <option value='เสียชีวิต'>เสียชีวิต</option>
                                <option value='แจ้งลบข้อมูล'>แจ้งลบข้อมูล</option>
                            </select>
                      </div>
                  </div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <strong class="card-title">ที่อยู่เกษตรกร</strong>
            </div>
            <div class="card-body">
            <div class="form-group row">
                 <label  class="col-sm-2 col-form-label">รหัสไปรษณีย์</label>
                 <div class="col-sm-2">
                   <input type="number" class="form-control" name="argzip_code" placeholder="รหัสไปรษณีย์">
                 </div>
                 <label  class="col-sm-1 col-form-label">จังหวัด</label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argprovince" id="argprovince">
                        <?php
                          echo loadProvinceDependent($conn);
                          ?>
                        </select>
                 </div>
                 <label  class="col-sm-1 col-form-label">อำเภอ</label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argdist" id="argdist">

                    </select>
                 </div>
               </div>


              <div class="form-group row">

              <label  class="col-sm-2 col-form-label">ตำบล</label>
                 <div class="col-sm-2">

                   <select class="form-control"name="argsub" id="argsub">

                      </select>
                 </div>

              <label  class="col-sm-2 col-form-label">ชื่อหมู่บ้าน</label>
                 <div class="col-sm-3">

                   <select class="form-control"name="argmoo_name" id="argmoo_name">

                    </select>
                 </div>


               </div>

               <div class="form-group row">

               <label  class="col-sm-2 col-form-label">บ้านเลขที่</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="argno" placeholder="บ้านเลขที่">
                 </div>

                 <label  class="col-sm-1 col-form-label">หมู่ที่</label>
                 <div class="col-sm-2">
                   <input type="number" class="form-control" name="argmoo_no" placeholder="หมู่ที่">
                 </div>
               <label  class="col-sm-1 col-form-label">หย่อม</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="argsub_moo" placeholder="หย่อม">
                 </div>


               </div>

              <div class="form-group row">
              <label  class="col-sm-2 col-form-label">ถนน</label>
                 <div class="col-sm-2">
                   <input type="text" class="form-control" name="road" placeholder="ถนน">
                 </div>
                 <label  class="col-sm-2 col-form-label">เบอร์โทร</label>
                 <div class="col-sm-2">
                   <input type="number" class="form-control" name="argTel" placeholder="เบอร์โทร">
                 </div>
                <label  class="col-sm-1 col-form-label">อีเมล์</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="argEmail" placeholder="อีเมล์" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                  </div>
                </div>


            </div>
          </div>



          <div class="card">
            <div class="card-header">
              <strong class="card-title">ข้อมูลอื่นๆ</strong>
            </div>
            <div class="card-body">
            <div class="form-group row">
                 <label  class="col-sm-2 col-form-label">สถานะการศึกษา</label>
                 <div class="col-sm-4">

                   <select class="form-control"name="eduStatus">
                      <?php
                          $sql6="select *  from EduStatus";
                          $stmt = sqlsrv_query( $conn, $sql6 );
                          echo "<option value='0' >กรุณาเลือก</option>";
                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idEduStatus"];
                            $name_pre=$row["eduStatusName"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                      </select>
                 </div>
              <label  class="col-sm-2 col-form-label">ระดับการศึกษา</label>
                 <div class="col-sm-4">

                   <select class="form-control"name="eduLevel">
                      <?php
                          $sql6="select *  from EduLevel";
                          $stmt = sqlsrv_query( $conn, $sql6 );
                          echo "<option value='0' >กรุณาเลือก</option>";
                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idEduLevel"];
                            $name_pre=$row["eduLevelName"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                      </select>
                 </div>
               </div>
               <div class="form-group row">
                 <label  class="col-sm-2 col-form-label">อาชีพหลัก</label>
                 <div class="col-sm-4">

                   <select class="form-control"name="occupFirst">
                      <?php
                          $sql4="select *  from Occup";
                          $stmt = sqlsrv_query( $conn, $sql4 );

                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idOccup"];
                            $name_pre=$row["occupName"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                      </select>

                 </div>
              <label  class="col-sm-2 col-form-label">อาชีพรอง</label>
                 <div class="col-sm-4">

                   <select class="form-control"name="occupSecond">
                      <?php
                          $sql5="select *  from Occup";
                          $stmt = sqlsrv_query( $conn, $sql5 );

                          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                            $id_pre=$row["idOccup"];
                            $name_pre=$row["occupName"];
                            echo "<option value='$id_pre'> $name_pre</option>";
                          }
                        ?>
                      </select>
                 </div>
               </div>
            </div>
          </div>
          <div class="card">
                                            <div class="card-header">
                                            <strong class="card-title">เงินรายได้ - รายจ่าย</strong>
                                            </div>
                                            <div class="card-body">
                                                    <div class="row" style=" float: right;margin: 10px; ">
                                                        <div class="cal-sm-10"></div>
                                                        <div class="cal-sm-2"> <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#editYearEarnPay" style=" width: inherit; " >เพิ่มรายรับ/จ่ายต่อปี</button></div>

                                                    </div>
                                                    <div class="table-responsive">
                                                                <table class="table table-striped" id="earnpay">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" style='text-align: center;'>ลำดับ</th>
                                                                            <th scope="col"  style='text-align: center;'>ปี</th>
                                                                            <th scope="col"  style='text-align: center;'>รายได้</th>
                                                                            <th scope="col"  style='text-align: center;'>รายจ่าย</th>
                                                                            <th scope="col"  >ลบ</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    </tbody>
                                                                </table>
                                                    </div>
                                            </div>
                                        </div>

          <div class="card">
            <div class="card-header">
              <strong class="card-title">การถึอครองที่ดิน</strong>
            </div>
            <div class="card-body">
              <div class="form-group row">
                  <label  class="col-sm-2 col-form-label">จำนวนแปลง</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="plots" placeholder="จำนวนแปลง">
                  </div>
                <label  class="col-sm-2 col-form-label">จำนวนไร่</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="rai" placeholder="จำนวนไร่">
                  </div>
                </div>
                <div class="form-group row">
                  <label  class="col-sm-2 col-form-label">จำนวนงาน</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="ngan" placeholder="จำนวนงาน">
                  </div>
                <label  class="col-sm-2 col-form-label">จำนวนตารางวา</label>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" name="sqaure_wa" placeholder="จำนวนตารางวา">
                  </div>
                </div>
            </div>
          </div>


          <div class="card">
            <div class="card-header">
              <strong class="card-title">ข้อมูลรายแปลง</strong>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <ul class="list-group col-md-12" id="landDetail">


                </ul>

            </div>
          </div>
        </div>


        <div class="card">
            <div class="card-header">
              <strong class="card-title">การเป็นสมาชิกกลุ่ม</strong>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <ul class="list-group col-md-12" id="personGroup">
                </ul>
              </div>
           </div>
        </div>

        </div>



  </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
      <button type="button" class="btn btn-primary" id="updatePersonBtn">บันทึก</button>
    </div>
  </div>
</div>
</div>
