<?php
$db = new Database();
$conn=  $db->getConnection();
?>
<div class="modal fade" id="editExpense" tabindex="-1" role="dialog" aria-labelledby="editExpense" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" style=" max-width: 1140px; ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editExpense">แก้ไขรายจ่าย</h5>
                                    <input type="hidden" id="expense_id">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <from>
                                            <div class="form-group row">
                                                <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;" disabled >

                                                    </select>
                                                </div>

                                                <label for="inputext" class="col-sm-2 col-form-label" style=" text-align: end; ">วันที่ :</label>
                                                        <div class="input-group date form_date col-md-3 expenseDateTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="expenseDate" data-link-format="dd-mm-yyyy">
                                                                    <input class="form-control" size="14" type="text" value="" readonly>
                                                                    <input class="form-control" size="14" type="hidden" id="expenseDate" value="" readonly>
                                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        </div>

                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">พื้นที่</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control"name="idArea" id="idArea"  style="width: 100%;" disabled>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;" disabled>


                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มเกษตรกร</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="sub_group_id"  style="width: 100%;" disabled>
                                                        <option value='0'>ทั้งหมด</option>

                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">กลุ่มธุระกิจ</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="business_group_id"  style="width: 100%;" disabled>
                                                        <option value='0'>ทั้งหมด</option>

                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label">ผู้รับเงิน</label>
                                            <div class="col-sm-4">
                                            <select class="farmer-dropdown" name="customer" id="customer" style="width: 100%;">
                                                        <option value='0'>ทั้งหมด</option>
                                                        <?php
                                                            echo loadFarmerFromAgri($conn, $_SESSION['idarea']);
                                                        ?>
                                                    </select>
                                            </div>

                                            <label class="col-sm-2 col-form-label">ผู้รับเงินมิใช่สมาชิก</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="other_customer" id="other_customer" placeholder="" disabled>
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">เลขที่เอกสาร</label>
                                                    <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="doc_no" id="doc_no" disabled>

                                                    </div>

                                            </div>

                                            <div class="form-group row">
                                                 <label class="col-sm-2 col-form-label">ประเภทรายจ่าย</label>
                                                <div class="form-check-inline form-check">
                                                    <label for="inline-radio1" class="form-check-label ">
                                                        <input type="radio" id="inline-radio1" name="pay_type" value="product" class="form-check-input" checked="checked">สินค้า
                                                    </label>
                                                    <label for="inline-radio2" class="form-check-label ">
                                                        <input type="radio" id="inline-radio2" name="pay_type" value="other" class="form-check-input">อื่นๆ
                                                    </label>

                                                </div>
                                            </div>

                                            <div id="product_div">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">สินค้า</label>
                                                <div class="col-sm-4">
                                                <select class="form-control"name="product" id="product"  style="width: 100%;" disabled>
                                                </select>
                                                </div>

                                            </div>



                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">จำนวน</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="amount" id="amount" placeholder="" disabled>
                                                    </div>


                                                <label class="col-sm-2 col-form-label">ราคา</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="price" id ="price" placeholder="" disabled>
                                                    </div>
                                                    <label class="col-sm-1 col-form-label">บาท</label>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">ส่วนลด</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="discount"  id="discount" placeholder="" disabled>
                                                    </div>
                                                    <label class="col-sm-2 col-form-label">บาท</label>
                                            </div>

                                        </div>
                                        <div id="other_div" style="display: none;">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">อื่นๆ</label>
                                                    <div class="col-sm-2">
                                                        <select class="form-control" id="expense_other_id"  style="width: 100%;" disabled>
                                                            <option value='0'>กรุณาเลือก</option>
                                                            <?php
                                                                $sql2="  SELECT EXPENSE_OTHER_ID, EXPENSE_DETAIL, STATUS, COMMENT FROM EXPENSE_OTHER_TD where  STATUS ='Y' and EXPENSE_OTHER_ID <> 0 ";
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["EXPENSE_OTHER_ID"];
                                                                $name_pre=$row["EXPENSE_DETAIL"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
                                                            ?>
                                                            </select>

                                                    </div>

                                                </div>



                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">เป็นเงิน</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="price" id="price" placeholder="" disabled>
                                                        </div>
                                                    <label class="col-sm-1 col-form-label">บาท</label>
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถานะ</label>
                                                <div class="col-sm-2">
                                                    <select class="form-control" id="canceled"  style="width: 100%;" >
                                                                <option value="N">ใช้งาน</option>
                                                                <option value="Y">ยกเลิก</option>
                                                    </select>
                                                </div>
                                            <label class="col-sm-1 col-form-label">บาท</label>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">หมายเหตุ</label>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control" id="comment" rows="3"></textarea>
                                                </div>

                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                 <strong class="card-title">ตารางการชำระเงิน </strong>
                                            </div>
                                             <div class="card-body">
                                             <table class="table" >
                                             <button type="button" class="btn btn-primary" id="addDebt" style="float: right;margin-bottom: 10px;" data-toggle="modal" data-target="#debtExpenseAdd"><i class="fa fa-plus"></i> เพิ่มรายการชำระหนี้</button>
                                                    <thead style=" background-color: bisque; ">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">วันที่ชำระ</th>
                                                            <th scope="col">เลขที่เอกสาร</th>
                                                            <th scope="col">จำนวนเงิน</th>
                                                            <th scope="col">แนบเอกสาร</th>
                                                            <th scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style=" background-color: #ffe4c461; ">

                                                    </tbody>
                                            </table>

                                             </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-sm-8"></div>
                                                <label class="col-sm-2 col-form-label" style=" text-align: right; ">เป็นเงินทั้งหมด :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="otherPay" id="otherPay" placeholder="" disabled>
                                                    </div>
                                                </div>
                                            <div class="form-group row">
                                                <div class="col-sm-8"></div>
                                                <label class="col-sm-2 col-form-label" style=" text-align: right; ">จ่ายเงิน :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="expense_amount" id="expense_amount" placeholder="" disabled>
                                                    </div>



                                            </div>

                                            <div class="form-group row">
                                            <div class="col-sm-8"></div>
                                            <label class="col-sm-2 col-form-label"style=" text-align: right; ">ค้างชำระ :</label>
                                                    <div class="col-sm-2">
                                                        <input type="number" class="form-control" name="debt"  id="debt" placeholder="" disabled>
                                                    </div>
                                            </div>
                                 </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="editExpenseBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
