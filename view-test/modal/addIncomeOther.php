<div class="modal fade" id="addIncomeOther" tabindex="-1" role="dialog" aria-labelledby="addIncomeOther" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addIncomeOther">เพิ่มรายการรายรับอื่นๆ</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>

                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-8">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                    <?php
                                                            echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="idArea"  style="width: 100%;">
                                                    <?php
                                                         echo loadAreaDependentInSS($conn,$_SESSION['RBAll'],$_SESSION['AreaAll']);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="institute_id"  style="width: 100%;">

                                                        </select>

                                                    </div>
                                        </div>


                                    <div class="form-group row" style="display:none">
                                        <label for="inputext" class="col-sm-2 col-form-label">รหัส</label>
                                        <div class="col-sm-4">
                                            <input type="text"  class="form-control" name="product_id" placeholder="รหัสรายรับ" readonly>
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                    <label for="inputext" class="col-sm-2 col-form-label">ชื่อรายการ</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="income_detail" id="income_detail" placeholder="ชื่อรายการ" maxlength="300">
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
                                              <textarea name="textarea-input" id="comment" rows="9" placeholder="Content..." class="form-control" maxlength="300" ></textarea>
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
