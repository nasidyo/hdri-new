
<div class="modal fade" id="createCustomerDialog" tabindex="-1" role="dialog" aria-labelledby="createCustomerModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCustomerModalLabel">เพิ่มข้อมูลลูกค้าใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createCustomer_form">
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">ชื่อลูกค้าใหม่</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="CustomerName" placeholder="ชื่อลูกค้าใหม่">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createNewCustomer" name="createNewCustomer" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
