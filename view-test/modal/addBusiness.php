<?php
$db = new Database();
$conn=  $db->getConnection();
?>
<div class="modal fade" id="AddBusiness" tabindex="-1" role="dialog" aria-labelledby="AddBusiness" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" style=" max-width: 600px; ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddBusiness">เพิ่มธุระกิจกลุ่ม</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <from>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">ชื่อธุระกิจกลุ่ม <span style=" color: red; "> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="hidden" class="form-control" name="business_group_id" id="business_group_id" >
                                                <input type="text" class="form-control" name="business_group_name" id="business_group_name" >
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                <label class="col-sm-3 col-form-label">สถานะ</label>
                                <div class="col-sm-6">
                                    <select class="form-control"name="status" id="status">
                                            <option value="Y">ใช้งาน</option>
                                            <option value="N">ไม่ใช้งาน</option>
                                    </select>
                                </div>
                                </div>
                                 </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
