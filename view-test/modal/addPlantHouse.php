    <div class="modal fade" id="addPlantHouse" role="dialog" aria-labelledby="addPlantHouse" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPlantHouse">เพิ่มโรงเรือน</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <form class="form-horizontal" action="#" method="post" id="createPlantHouse_form">
                                    <div class="form-group row">
                                             <label for="inputext" class="col-sm-3 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                                 <div class="col-sm-6">
                                                 <select class="form-control"name="idRiverBasin" id="idRiverBasin"  style="width: 100%;">
                                                    <?php
                                                       echo loadRiverDependentBySS($conn,$_SESSION['idRiverBasin']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">พื้นที่</label>
                                            <div class="col-sm-6">
                                                <select class="form-control"name="idArea" id="idArea" style="width: 100%;">
                                                    <?php
                                                           echo loadAreaDependentBySS($conn,$_SESSION['idRiverBasin'],$_SESSION['idarea']);
                                                    ?>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">เกษตรกร</label>
                                        <div class="col-sm-6">
                                            <select class="form-control"name="person_id" id="person_id" style="width: 100%;">
                                                <option value='0'>กรุณาเลือก</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" name="land_number" id="land_number"> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">แปลงปลูก</label>
                                        <div class="col-sm-6">
                                            <select class="form-control"name="landDetail" id="landDetail" style="width: 100%;">
                                                <option value='0'>ไม่เลือก</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">หมายเลขโรงเรือน</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="house_number" id="house_number">
                                        </div>
                                    </div>
                                </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clear">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="createPlantHouseBtn">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
