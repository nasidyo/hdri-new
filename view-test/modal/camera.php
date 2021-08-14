<div class="modal fade bd-example-modal-sm" id="camera" tabindex="-1" role="dialog" aria-labelledby="camera" aria-hidden="true">
<div class="modal-dialog modal-sm" role="document" style=" max-width: 600px; ">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="camera">ถ่ายภาพ</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
        <div class="row">
                <div class="col-md-1" ></div>
                <div class="col-md-10" id="my_camera" style="width: 400px;height: 400px;text-align: center;"></div>
                <div class="col-md-1" ></div>
         </div>
         <div class="row" style=" margin-top: 20px; ">
            <div class="col-md-4" ></div>
             <div class="col-md-4" > <input type=button value="ถ่ายรูป"  class="btn btn-primary " onClick="take_snapshot()" style=" height: auto; text-align: center; "></div>
             <div class="col-md-4" ></div>
         </div>
        </div>
    <div class="modal-footer">

    </div>
  </div>
</div>
</div>
<script language="JavaScript">
                        // Configure a few settings and attach camera
                        Webcam.set({
                        width: 300,
                        height: 400,
                        image_format: 'jpeg',
                        jpeg_quality: 90
                      });
                      Webcam.attach( '#my_camera' );
		function take_snapshot() {

			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
        // display results in page
				document.getElementById('results').innerHTML =
					'<img class="mx-auto d-block basic-img"   style="  max-width:300px;max-height: 300px;float: left;" src="'+data_uri+'"/>';
            } );
            (function ($) {
                $('#camera').modal('toggle');
            })(jQuery);


		}
</script>
