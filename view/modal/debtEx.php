<?php
$db = new Database();
$conn=  $db->getConnection();
?>
<div class="modal fade" id="debtExpenseAdd" tabindex="-1" role="dialog" aria-labelledby="debtExpenseAdd" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" style=" max-width: 600px; ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editExpense">เพิ่มรายการชำระหนี้</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <from>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">วันที่</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="debtDate" placeholder="วันที่ชำระหนี้">
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">เลขที่เอกสาร</label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" name="doc_no" id="doc_no">
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">จำนวนเงิน</label>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="amount" id="amount" placeholder="">
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
