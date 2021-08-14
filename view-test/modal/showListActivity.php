
<div class="modal fade" id="showActivityUserModal" tabindex="-1" role="dialog" aria-labelledby="showActivityUserModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showActivityUserModalLabel">รายการเข้าใข้ระบบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style=" padding: 1.5rem; ">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" id="addNewUserForm">
                    <div class="row form-group">

                    </div>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <table id="activityUser-table" name="activityUser-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>รหัส</th>
                                        <th>ชื่อ-นามสกุล</th>
                                        <th>ลิงค์ที่เข้าถึง</th>
                                        <th>วันและเวลา</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </from>
            </div>
        </div>
    </div>
</div>
