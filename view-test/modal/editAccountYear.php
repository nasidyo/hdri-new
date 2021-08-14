<?php
$db = new Database();
$conn =  $db->getConnection();
?>
<div class="modal fade" id="EditAccountYear" tabindex="-1" role="dialog" aria-labelledby="EditAccountYear" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style=" max-width: 600px; ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditAccountYear">แก้ไขปีบัญชี</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style=" padding: 1.5rem; ">
                <from>
                    <input type="hidden" value="" id="account_year_id">
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">ลุ่มน้ำ</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="idRiverBasin" id="idRiverBasin" style="width: 100%;" disabled>
                                <?php
                                echo loadRiverDependentBySS($conn, $_SESSION['idRiverBasin']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">พื้นที่</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="idArea" id="idArea" style="width: 100%;" disabled>
                                <?php
                                echo loadAreaDependentBySS($conn, $_SESSION['idRiverBasin'], $_SESSION['idarea']);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">สถาบันเกษตรกร</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="institute_id" style="width: 100%;" disabled>
                            </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">กลุ่มเกษตรกร</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="sub_group_id" style="width: 100%;" disabled>


                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">ปีบัญชี</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="year_text" disabled>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label" >วันที่เริ่มต้น</label>
                        <div class="input-group date form_date col-md-6 account_year_startTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="account_year_start" data-link-format="dd-mm-yyyy" disabled>
                                    <input class="form-control" size="14" type="text" value="" disabled>
                                    <input class="form-control" size="14" type="hidden" id="account_year_start" value="" disabled>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        </div>
                        <div class="form-group row">

                        <label for="inputext" class="col-sm-3 col-form-label">วันที่สิ้นสุด</label>
                        <div class="input-group date form_date col-md-6 account_year_endTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="account_year_end" data-link-format="dd-mm-yyyy" disabled>
                                    <input class="form-control" size="14" type="text" value="" disabled>
                                    <input class="form-control" size="14" type="hidden" id="account_year_end" value="" disabled>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>


                        </div>
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">เงินสดในมือ</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="current_bugget" disabled>
                        </div>
                        <label class="col-sm-2 col-form-label" style="text-align: end;">เงินฝาก</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="bank_bugget" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">จำนวนหุ้น</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="stocks_amount" disabled>
                        </div>
                        <label class="col-sm-2 col-form-label" style="text-align: end;">ราคาหุ้น</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="stocks_price" disabled>
                        </div>
                    </div>




                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">สถานะ</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" id="status">
                                <option value="Y">ใช้งาน</option>
                                <option value="N">ปิดบัญชี</option>
                            </select>
                        </div>
                    </div>
                </from>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="editBtn">ตกลง</button>
            </div>
        </div>
    </div>
</div>
