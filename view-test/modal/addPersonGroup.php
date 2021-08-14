<div class="modal fade" id="addPersonGroup" tabindex="-1" role="dialog" aria-labelledby="addPersonGroup" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPersonGroup">สร้างกลุ่ม</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                    <from>

                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-3 col-form-label">ลุ่มน้ำ</label>
                                                 <div class="col-sm-8">
                                                    <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                    <?php
                                                           echo loadRiverDependentInSS($conn,$_SESSION['RBAll']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">พื้นที่</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"name="idArea" id="idArea"  style="width: 100%;">
                                                    <?php
                                                         echo loadAreaDependentInSS($conn,$_SESSION['RBAll'],$_SESSION['AreaAll']);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">สถาบันเกษตรกร</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-control" id="institute_id"  style="width: 100%;">

                                                        </select>

                                                    </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ชื่อกลุ่ม <span style="color:red" >*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control"name="person_group_name" id="person_group_name"  style="width: 100%;" maxlength="200">
                                            </div>
                                        </div>
                                    </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="addPersonGroup">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
