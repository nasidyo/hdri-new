
<div class="modal fade" id="createAgriDialog" tabindex="-1" role="dialog" aria-labelledby="createAgriModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAgriModalLabel">เพิ่มข้อมูลพืชใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createAgri_form">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">สาขาพืช <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-5">
                            <select class="form-control"name="typeOfAgri_Id" id="typeOfAgri_Id">
                                <?php echo loadAllTypeOfAgri($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อชนิดพืช <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="agriName" id="agriName" placeholder="ชื่อชนิดพืชใหม่">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">พันธุ์พืช</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="speciesArgi" id="speciesArgi" placeholder="ชื่อพันธุ์พืช">
                        </div>
                        <div class="col-sm-2">
                            <i class="fa fa-plus-circle" style=" cursor: pointer; font-size: 20px; margin-top: 10px; color: blue;" data-toggle="tooltip" title="เพิ่มพันธุ์พืช" name="createSpeciesBtn" id="createSpeciesBtn"></i>
                            <!-- <button type="button" id="createSpeciesBtn" name="createSpeciesBtn" class="btn btn-primary"><i class="fa fa-align-justify"></i></button> -->
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-2 col-form-label">มาตรฐานพืช</label>
                        <div class="col-sm-5">
                            <select class="form-control"name="idTypeOfStand" id="idTypeOfStand">
                                <?php echo loadStandAll($conn)?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">เกรด</label>
                        <div class="col-sm-5">
                            <select class="gradeList-dropdown addfield" name="newGradeList" multiple="multiple" id="newGradeList" tabindex="1" size="5" style="width: 100%">
                                <!-- <option value="0">กรุณาเลือก</option> -->
                                <?php echo loadAllGradeProduct($conn); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">หน่วยวัดปริมาณ <span style=" color: red; ">*</span> </label>
                        <div class="col-sm-5">
                            <select class="form-control"name="contUnitId" id="contUnitId" style="width: 100%">
                                <option value='0'>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                </form>
                <!-- <div class="row form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5" >
                            <button type="button" id="createSpeciesBtn" name="createSpeciesBtn" class="btn btn-primary">เพิ่มพันธุ์พืช</button>
                        </div>
                </div> -->
                <div id="speciesLis" >
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">พันธุ์พืช</label>
                        <div class="col-sm-6">
                            <table class="table" id="dashTable">
                                <thead>
                                <tr>
                                    <th>ชื่อพันธุ์พืช</th>
                                    <th style="  text-align: center; width: 13%;">ลบ</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createAgriBtn" name="createAgriBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
