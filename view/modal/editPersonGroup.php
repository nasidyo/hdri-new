<div class="modal fade" id="editPersonGroup" tabindex="-1" role="dialog" aria-labelledby="editPersonGroup" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPersonGroup">แก้ไขกลุ่ม</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>
                                    <input type="hidden" id="sub_group_id" value="">
                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-3 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-8">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;" disabled>

                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="idArea"  style="width: 100%;" disabled>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-control" id="institute_id"  style="width: 100%;" disabled>

                                                     </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ชื่อกลุ่ม <span style="color:red" >*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"name="person_group_name" id="person_group_name"  style="width: 100%;"  maxlength="200">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">สถานะ</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="status"  style="width: 100%;">

                                                    <option value="Y">ใช้งาน</option>
                                                    <option value="N">ระงับใช้งาน</option>

                                               </select>
                                            </div>
                                        </div>
                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="editPersonGroupBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
