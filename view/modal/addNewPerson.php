
<div class="modal fade" id="createPersonDialog" tabindex="-1" role="dialog" aria-labelledby="createPersonModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPersonModalLabel">เพิ่มข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createPerson_form">
                    <input type="hidden" id="action" name="action" value="createPerson"/>
                    <input type="hidden" id="area_Id" name="area_Id" value="<?php echo $area_Id?>">
                    <input type="hidden" id="yearsId" name="yearsId" value="<?php echo $yearsId?>">
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">เลขที่บัตรประชาชน</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="argid" placeholder="เลขที่บัตรประชาชน">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">ชื่อ-สกุล <span style=" color: red; ">*</span></label>
                            <div class="col-sm-2">
                            <select class="form-control"name="argpre">
                            <?php	
                                $sql2="select *  from Prefix";
                                $stmt = sqlsrv_query( $conn, $sql2 );

                                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
                                $id_pre=$row["idPrefix"];
                                $name_pre=$row["prefixNameTh"];
                                echo "<option value='$id_pre'> $name_pre</option>";
                                }
                            ?>
                            </select>
                            </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="argname" placeholder="ชื่อ">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="argsurname" placeholder="นามสกุล">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label">เบอร์โทร</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="argTel" placeholder="เบอร์โทร">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createNewPerson" name="createNewPerson" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
