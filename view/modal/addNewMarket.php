
<div class="modal fade" id="createMarketDialog" tabindex="-1" role="dialog" aria-labelledby="createMarketModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMarketModalLabel">เพิ่มข้อมูลตลาดใหม่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="createMarket_form">
                    <input type="hidden" id="action" name="action" value="createMarket"/>
                    <div class="row form-group">
                        <label for="inputext" class="col-sm-2 col-form-label">ตลาด</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="marketName" placeholder="ชื่อตลาดใหม่">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="createNewMarket" name="createNewMarket" class="btn btn-primary">บันทึก</button>
            </div>
        </div>
    </div>
</div>
