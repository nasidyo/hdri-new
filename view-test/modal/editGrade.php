<div class="modal fade" id="editGrade" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-s" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGradeModalLabel">เพิ่มข้อมูลเกรด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style=" padding: 1.5rem; ">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="editGradeForm">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">รหัสเกรด</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="grade_Id" id="grade_Id" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputext" class="col-sm-3 col-form-label">ชื่อเกรด</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"name="gradeName" id="gradeName"  style="width: 100%;">
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="editGradeBtn">ตกลง</button>
            </div>
        </div>
    </div>
</div>
