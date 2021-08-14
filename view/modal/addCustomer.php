<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCustomer">เพิ่มผู้รับซื้อ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>

                                        <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ชื่อผู้รับซื้อ</label>
                                                 <div class="col-sm-8">
                                                    <input type="text" class="form-control"name="customer_name" id="customer_name"  style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ที่อยู่</label>
                                                 <div class="col-sm-8">
                                                    <input type="text" class="form-control"name="address" id="address"  style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                                                 <div class="col-sm-8">
                                                    <input type="text" class="form-control"name="phone" id="phone"  style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถานะ </label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="status" id="status" style="width: 200px;">

                                                <?php
                                                $sql2="select *  from connection_status_TD";
                                                $stmt = sqlsrv_query( $conn, $sql2 );
                                                echo "<option value='0' >กรุณาเลือก</option>";
                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                $id_pre=$row["conn_status_id"];
                                                $name_pre=$row["conn_status_name"];
                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                }
                                            ?>
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
                                <button type="button" class="btn btn-primary" id="addCustomerBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
