<div class="modal fade" id="editIncomeOther" tabindex="-1" role="dialog" aria-labelledby="editIncomeOther" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editIncomeOther">แก้ไขรายการค่าใช้จ่าย</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>

                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-8">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;" disabled>
                                                    <?php
                                                         echo loadRiverDependentBySS($conn,$_SESSION['idRiverBasin']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="idArea"  style="width: 100%;" readonly>
                                                    <?php
                                                         echo loadAreaDependentBySS($conn,$_SESSION['idRiverBasin'],$_SESSION['idarea']);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;" readonly>
                                                        <option value='0'>ทั้งหมด</option>
                                                        <?php
                                                                $sql2="select ins.*  from INSTITUTE ins where 1=1";
                                                                    if($_SESSION['idarea']!="0" && $_SESSION['idarea']!=""){
                                                                        $sql2.=" and ins.AREA_ID =". $_SESSION['idarea'];
                                                                    }
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["INSTITUTE_ID"];
                                                                $name_pre=$row["INSTITUTE_NAME"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
                                                            ?>
                                                        </select>

                                                    </div>
                                        </div>


                                    <div class="form-group row" style="display:none">
                                        <label for="inputext" class="col-sm-2 col-form-label">รหัส</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="income_other_id" id="income_other_id" placeholder="รหัสรายจ่าย" readonly>
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                    <label for="inputext" class="col-sm-2 col-form-label">ชื่อรายการ</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="income_detail" id="income_detail" placeholder="ชื่อรายการ">
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                            <label class="col-sm-2 col-form-label">สถานะ</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="status" id="status">
                                                        <option value="">ทั้งหมด</option>
                                                        <option value="Y">ใช้งาน</option>
                                                        <option value="N">ไม่ใช้งาน</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">

                                           <label class="col-sm-2 col-form-label">หมายเหตุ</label>
                                           <div class="col-sm-8">
                                              <textarea name="textarea-input" id="comment" rows="9" placeholder="Content..." class="form-control"></textarea>
                                           </div>
                                   </div>


                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addProduct">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
