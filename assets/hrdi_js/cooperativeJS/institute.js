var Table;
(function ($) {

    $('#criteria #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:$("#AreaAll").val()},
             dataType:"text",
             success:function(data){
                 $('#criteria #idArea').html(data);
             }
         });
     });
     $('#criteria #idRiverBasin').trigger('change');

    Table = $('#InstituteTable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        dom: '<"top">r<tl><"bottom"ip><"clear">',
        pageLength: 10,
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {url:"../server_side/InstituteSS.php?idRiverBasin="+jQuery('#criteria #idRiverBasin option:selected').val()+"&idArea="+jQuery('#criteria #idArea option:selected').val()+"&name="+$("institute_name").val(),"type": "GET"},
        order: [[ 0, "desc" ]],
        columnDefs: [{
                        'targets': [4],
                        'width': 70,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-header-center',
                        'render': function (data, type, full, meta){
                            return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editInstitute" data-id="'+full[0]+'" id="edit"></i>       </div>';
                        }
                    },
                    {
                        "targets": [0],
                        "visible": true,
                        "searchable": false
                    }

                ]
    });

    $('#criteria #search_person').on('click',function(){
        Table.destroy();

        Table = $('#InstituteTable').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            dom: '<"top">r<tl><"bottom"ip><"clear">',
            pageLength: 10,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: {url:"../server_side/InstituteSS.php?idRiverBasin="+jQuery('#criteria #idRiverBasin option:selected').val()+"&idArea="+jQuery('#criteria #idArea option:selected').val()+"&name="+$("institute_name").val(),"type": "GET"},
            order: [[ 0, "desc" ]],
            columnDefs: [{
                            'targets': [4],
                            'width': 70,
                            'searchable': false,
                            'orderable': false,
                            'className': 'dt-header-center',
                            'render': function (data, type, full, meta){
                                return '<div style=" font-size: 20px; "  ><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px;" data-toggle="modal" data-target="#editInstitute" data-id="'+full[0]+'" id="edit"></i>       </div>';
                            }
                        },
                        {
                            "targets": [0],
                            "visible": true,
                            "searchable": false
                        }

                    ]
        });

    });






})(jQuery);
