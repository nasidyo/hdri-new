    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="addProduct" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProduct">เพิ่มสินค้า</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>
                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-4">
                                                 <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                    <?php
                                                         echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-10">
                                                <select class="form-control"name="idArea" id="idArea" style="width: 100%;">
                                                    <?php
                                                       echo loadAreaDependentInSS($conn,$_SESSION['RBAll'],$_SESSION['AreaAll']);
                                                    ?>
                                                </select>
                                            </div>
                                    </div>

                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;">


                                                        </select>

                                                    </div>
                                        </div>

                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="sub_group_id"  style="width: 100%;">


                                                        </select>

                                                    </div>
                                        </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">รหัสสินค้า</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="order_id" placeholder="รหัสสินค้า" readonly>
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                    <label for="inputext" class="col-sm-2 col-form-label">ชื่อสินค้า</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control order_name" name="order_name" placeholder="ชื่อสินค้า" id="order_name" maxlength="300">
                                        </div>


                                           <label class="col-sm-2 col-form-label">จำนวน</label>
                                           <div class="col-sm-4">
                                             <input type="number" class="form-control" name="balance" id="balance" value="0" min="0" oninput="validity.valid||(value='');">
                                          </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label">หน่วย</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="unit" id="unit" style="width: 100%;">
                                                <?php

                                                    $sql = "SELECT idCountUnit, nameCountUnit FROM CountUnit ";
                                                    $stmt = sqlsrv_query( $conn, $sql );
                                                    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                    $id_pre=$row["idCountUnit"];
                                                    $name_pre=$row["nameCountUnit"];
                                                    echo "<option value='$id_pre' > $name_pre</option>";
                                                }
                                            ?>
                                                </select>
                                            </div>

                                            <label class="col-sm-2 col-form-label">สถานะ</label>
                                            <div class="col-sm-4">
                                                <select class="form-control"name="status" id="status">
                                                    <option value="Y" selected>ขาย</option>
                                                    <option value="N">ระงับการขาย</option>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">

                                           <label class="col-sm-2 col-form-label">หมายเหตุ</label>
                                           <div class="col-sm-8">
                                              <textarea name="textarea-input" id="comment" rows="9" placeholder="Content..." class="form-control"  maxlength="300" ></textarea>
                                           </div>
                                   </div>


                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clear">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addProduct">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
