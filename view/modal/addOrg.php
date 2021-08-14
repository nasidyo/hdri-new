<?php
$db = new Database();
$conn=  $db->getConnection();
?>
<div class="modal fade" id="AddOrg" tabindex="-1" role="dialog" aria-labelledby="AddOrg" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document" style=" max-width: 600px; ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AddOrg">เพิ่มโครงสร้างองค์กร</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <from>
                                <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">ชื่อสมาชิก<span style=" color: red; "> *</span></label>
                                            <div class="col-sm-6">
                                                <input type="hidden" id="org_map_id">
                                                <select class="form-control" id="person_id"  style="width: 100%;">
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">ตำแหน่ง <span style=" color: red; "> *</span></label>
                                            <div class="col-sm-6">

                                            <select class="form-control" id="org_id"  style="width: 100%;">
                                                    <option value='0'>กรุณาเลือก</option>
                                                        <?php
                                                                $sql2="  select org_id ,org_name from ms_organization where status ='Y' ";
                                                                $stmt = sqlsrv_query( $conn, $sql2 );

                                                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                                                $id_pre=$row["org_id"];
                                                                $name_pre=$row["org_name"];
                                                                echo "<option value='$id_pre' > $name_pre</option>";
                                                                }
                                                            ?>

                                                        </select>
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
