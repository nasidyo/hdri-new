<div class="modal fade" id="editInstitute" tabindex="-1" role="dialog" aria-labelledby="addProduct" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editInstitute">แก้ไขสถาบันเกษตรกร</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>
                                    <input type="hidden" id="institute_id" name="institute_id">
                                  <!--
                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">ลุ่มน้ำ</label>
                                            <div class="col-sm-10">
                                            <select class="form-control"name="idRiverBasin" id="idRiverBasin">
                                                 <?php // echo loadRiverDependent($conn); ?>
                                                 </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">พื้นที่</label>
                                            <div class="col-sm-10">
                                                <select class="form-control"name="idArea" id="idArea">

                                                </select>
                                            </div>
                                    </div>-->

                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อสถาบันเกษตรกร</label>
                                        <div class="col-sm-10">
                                            <select class="form-control"name="institute_name" id="institute_name">
                                                    <option value="กลุ่มสหกรณ์">กลุ่มสหกรณ์</option>
                                                    <option value="กลุ่มเตรียมสหกรณ์">กลุ่มเตรียมสหกรณ์</option>
                                                    <option value="กลุ่มวิสาหกิจชุมชน">กลุ่มวิสาหกิจชุมชน</option>
                                                    <option value="กลุ่มพึ่งตนเอง">กลุ่มพึ่งตนเอง</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">สถานะ</label>
                                            <div class="col-sm-10">
                                                <select class="form-control"name="status" id="status">
                                                    <option value="Y">ใช้งาน</option>
                                                    <option value="N"> ระงับใช้งาน</option>
                                                </select>
                                            </div>
                                    </div>
                                 </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="editInsituteBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
