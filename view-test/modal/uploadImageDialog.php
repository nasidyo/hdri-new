
<div class="modal fade" id="uploadImageDialog" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">อัพโหลดรูปภาพการขนส่ง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" method="post" id="uploadImageModal" enctype="multipart/form-data">
                    <div class="row form-group">
                        <!-- <label for="inputext" class="col-sm-3 col-form-label">Choose Images:</label>
                        <div class="col-sm-4">
                            <input type="file" id="file-multiple-input" name="file-multiple-input" multiple="" class="form-control-file btnUpload">
                        </div> -->
                        <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label">Choose Images :</label></div>
                        <div class="col-12 col-md-9">
                            <div class="row form-group">
                                <input type="file" id="files" name="files[]" multiple="" class="btnUpload form-control-file">
                            </div>
                            <div class="row form-group">
                                <label for="inputext" class="col-sm-1 col-form-label" id="nameoffiles" name="nameoffiles"></label>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <img class="mx-auto d-block basic-img" style=" height: 200px;float: left;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                    ยกเลิก
                </button>
                <button type="button" id="uploadImage" name="uploadImage" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</div>
