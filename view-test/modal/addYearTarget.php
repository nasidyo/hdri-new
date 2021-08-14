
<div class="modal fade" id="createYearTargetDialog" tabindex="-1" role="dialog" aria-labelledby="createYearTargetModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createYearTargetModalLabel">เพิ่มข้อมูลปีงบประมาณ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createyear_form">
                    
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">ปีงบประมาณ</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="yearName" id="yearName" placeholder="ปีงบประมาณที่">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันเริ่มต้นปีงบประมาณ :</label>
                        <div class="input-group date form_date col-md-4" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input_start" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input_start" name="dtp_input_start" value="" /><br/>
                    </div>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-3 col-form-label">วันสิ้นสุดปีงบประมาณ :</label>
                        <div class="input-group date form_date col-md-4" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input_end" data-link-format="dd-mm-yyyy">
                            <input class="form-control" size="14" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input_end" name="dtp_input_end" value="" /><br/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createYearBtn" name="createYearBtn" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
