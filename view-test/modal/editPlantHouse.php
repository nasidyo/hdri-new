    <div class="modal fade" id="editPlantHouse" role="dialog" aria-labelledby="editPlantHouse" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPlantHouse">แก้ไขข้อมูลโรงเรือน</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style=" padding: 1.5rem; ">
                                <form class="form-horizontal" action="#" method="post" id="editPlantHouse_form">
                                        <input type="hidden" id="plant_house_id">

                                    <div class="form-group row">
                                            <label for="inputext" class="col-sm-3 col-form-label">พื้นที่ลุ่มน้ำ</label>
                                                 <div class="col-sm-6">
                                                 <select class="form-control"name="idRiverBasin_edit" id="idRiverBasin_edit" style="width: 100%;" >
                                                    <?php
                                                       echo loadRiverDependentBySS($conn,$_SESSION['idRiverBasin']);
                                                    ?>
                                                    </select>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">พื้นที่</label>
                                            <div class="col-sm-6">
                                                <select class="form-control"name="idArea_edit" id="idArea_edit" style="width: 100%;" >
                                                    <?php
                                                           echo loadAreaDependentBySS($conn,$_SESSION['idRiverBasin'],$_SESSION['idarea']);
                                                    ?>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ชื่อเกษตรกร</label>
                                            <div class="col-sm-6">
                                            <select class="form-control"name="person_name_edit" id="person_name_edit"  style="width: 100%;">

                                            </select>
                                            </div>
                                        </div>


                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">หมายเลขแปลง</label>
                                        <div class="col-sm-6">
                                            <select class="form-control"name="land_id_edit" id="land_id_edit"  style="width: 100%;">

                                            </select>
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <label for="inputext" class="col-sm-3 col-form-label">หมายเลขโรงเรือน</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="house_number_edit" id="house_number_edit">
                                        </div>


                                    </div>
                                </from>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clear">ยกเลิก</button>
                                <button type="button" class="btn btn-primary" id="editPlantHouseBtnM">ตกลง</button>
                            </div>
                        </div>
                    </div>
                </div>
