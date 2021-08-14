<div class="modal fade" id="addYearEarnPay" tabindex="-1" role="dialog" aria-labelledby="addYearEarnPay" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addYearEarnPay">เพิ่มรายรับรายจ่าย</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">ปี</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="yearGetPay" id="yearGetPay" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                    <label for="inputext" class="col-sm-3 col-form-label">รายรับต่อปี</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="earnPerYear" id="earnPerYear" onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    <label for="inputext" class="col-sm-3 col-form-label">รายจ่ายต่อปี</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" name="payPerYear" id="payPerYear"  onkeydown="javascript: return event.keyCode == 69 ? false : true">
                                        </div>


                                    </div>
                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addEarnPayBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
