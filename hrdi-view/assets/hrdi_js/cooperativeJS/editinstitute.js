(function ($) {


    $('#editInstitute').on('show.bs.modal', function (e) {

        $('#editInstitute #idRiverBasin').change(function(){
            var idRiverBasin = $(this).val();
             $.ajax({
                 url:"../util/AreaDependent.php",
                 method:"POST",
                 data:{idRiverBasin:idRiverBasin},
                 dataType:"text",
                 success:function(data){
                     $('#editInstitute  #idArea').html(data);
                 }
             });
         });

         var id =$(e.relatedTarget).data('id');
         $("#editInstitute #institute_id").val(id);
         $.ajax({
            url: "../handler/instituteHandler.php",
            type: "POST",
            dataType: "html",
            async: true,
            data:{'institute_id':id,'action':'load'},
            success:function(data){
                var instituteEdit =JSON.parse(data);

            $('#editInstitute [name="institute_name"] option[value="'+instituteEdit.institute_name+'"]').attr("selected",true);
            $('#editInstitute [name="status"] option[value="'+instituteEdit.status+'"]').attr("selected",true);
            $('#editInstitute [name="idArea"] option[value="'+instituteEdit.idArea+'"]').attr("selected",true);
            }
        });


    });


         $('#editInstitute #editInsituteBtn').on('click',function(){
            var id =$('#editInstitute input[name="institute_id"]').val();
            var name =$('#editInstitute [name="institute_name"] option:selected').val();
            var status =$('#editInstitute [name="status"] option:selected').val();
            var area =$('#editInstitute [name="idArea"] option:selected').val();
            var formData= new FormData();
            formData.append('institute_id',id);
            formData.append('institute_name',name);
            formData.append('area_id',area);
            formData.append('status',status);
            formData.append('action','update');
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                dataType:'text',
                data:formData,
                url: "../handler/instituteHandler.php",
                dataType: "html",
                async: false,
                success: function(data) {
                  result=data;
                  $('#editInstitute').modal('toggle');
                  Table.ajax.reload();
                }
              });
        });

        function loadIns(id){
                $.ajax({
                    url: "../handler/instituteHandler.php",
                    type: "POST",
                    dataType: "html",
                    async: true,
                    data:{'institute_id':id,'action':'load'},
                    success:function(data){
                        var instituteEdit =JSON.parse(data);

                    $('#editInstitute [name="institute_name"] option[value="'+instituteEdit.institute_name+'"]').attr("selected",true);
                    $('#editInstitute [name="status"] option[value="'+instituteEdit.status+'"]').attr("selected",true);
                    $('#editInstitute [name="idArea"] option[value="'+instituteEdit.idArea+'"]').attr("selected",true);
                    }
                });


        }








})(jQuery);
