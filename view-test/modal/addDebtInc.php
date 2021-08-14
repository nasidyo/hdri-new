<?php
$db = new Database();
$conn=  $db->getConnection();
?>
<div class="modal fade" id="debtIncomeAdd" tabindex="-1" role="dialog" aria-labelledby="debtIncomeAdd" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" style=" max-width: 600px; ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editIncome">เพิ่มรายการชำระหนี้</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <from>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">จำนวนค้างชำระ</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="all" id="all" disabled >
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">วันที่</label>
                                        <div class="input-group date form_date col-sm-6 debtDateTmp" data-date="" data-date-format="dd MM yyyy" data-link-field="debtDate" data-link-format="dd-mm-yyyy">
                                                    <input class="form-control" size="14" type="text" value="" >
                                                    <input class="form-control" size="14" type="hidden" id="debtDate" value="" readonly>
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">เลขที่เอกสาร</label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" name="doc_no" id="doc_no" maxlength="20">
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">จำนวนเงิน</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="amount" id="amount" placeholder="" min="0"   onkeydown="javascript: return event.keyCode == 69 ? false : true" >
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">ประเภทโอน</label>
                                            <div class="col-sm-6">
                                                <input type="checkbox" class="form-control" name="transfer" id="transfer" placeholder=""  >
                                            </div>
                                    </div>


                                    <div class="form-group row" id="attach" style="display: none;">
                                        <label class="col-sm-3 col-form-label">แนบไฟล์</label>
                                            <div class="col-sm-3">
                                                    <input type="file" name="fileToUpload" id="fileToUpload" style=" height: auto; ">
                                            </div>
                                            <div class="col-sm-3">
                                                    <img id="blah" src=""  />
                                            </div>


                                    </div>




                                 </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addDebtBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
