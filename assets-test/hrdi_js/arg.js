var argi_group_type_sel_add;
var argi_group_sel_add;
var argi_group_type_sel_edit;
var argi_group_sel_edit;

var argi_group_type_sel_criteria;
var argi_group_sel_criteria;

var earnPay=[];
var idarea_session;
var idRiverBasin_session;
var perm =['admin','staff'];
var role ="";
var spinner;
(function ($) {


    spinner = $("#loader");

    $(document).on({
       ajaxStart: function(){
           spinner.show();
       },
       ajaxStop: function(){
           spinner.hide();
       }
   });

   var defaultData =" <option value='0'>ทั้งหมด</option>";
    role = $("#staffPermis").val();
    idarea_session = $("#idarea_session").val();
    idRiverBasin_session = $("#idRiverBasin_session").val();
  var spinner = $("#loader");

      $("input:radio[name='inline-radios']").on('change', function (event) {
        if(this.value=='member'){
          $("#Member").show(300);
          $("#MemberFarmer").hide(300);
        }else{
          $("#Member").hide(300);
          $("#MemberFarmer").show(300);
        }
    });


    var yearsStart = new Date().getFullYear()+540;
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDate();
    var c = new Date(year, month, day);


    $("#addFarmer .argbirthTmp").datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        thaiyear: true,
        stepMonths: 0
    }).datepicker('setDate',c);

    $("#editFarmer .argbirthTmp").datepicker({
        format: "dd MM yyyy",
        language:  'th',
        changeMonth: false,
        changeYear: false,
        thaiyear: true,
        stepMonths: 0
    });


        argi_group_type_sel_add = new SlimSelect({
          select: '#addFarmer #argi_group_type'
          });
        argi_group_sel_add = new SlimSelect({
          select: '#addFarmer #argi_group'
          });

          argi_group_type_sel_edit = new SlimSelect({
            select: '#editFarmer #argi_group_type'
            });
          argi_group_sel_edit = new SlimSelect({
            select: '#editFarmer #argi_group'
            });


            argi_group_type_sel_criteria=   new SlimSelect({
                select: '#criteria #argi_group_type'
            });
            argi_group_sel_criteria =    new SlimSelect({
                select: '#criteria #argi_group'
            });



         /*   $('#criteria #idRiverBasin').change(function(){
                var idRiverBasin =jQuery("#criteria #idRiverBasin option:selected").val();
                $('#criteria #idGroupVillage').html("");
                $.ajax({
                    url:"../util/loadGroupVillage.php",
                    method:"GET",
                    data:{"idRiverBasin":idRiverBasin},
                    dataType:"text",
                    success:function(data){
                        $('#criteria #idGroupVillage').html(data);
                    }
                });

            });*/

            $('#criteria #area').change(function(){
                var idArea =jQuery("#criteria #area option:selected").val();
                var idRiverBasin =jQuery("#criteria #idRiverBasin option:selected").val();
                $('#criteria #idGroupVillage').html("");
                $.ajax({
                    url:"../util/loadGroupVillage.php",
                    method:"GET",
                    data:{"idArea":idArea ,"idRiverBasin":idRiverBasin},
                    dataType:"text",
                    success:function(data){

                        $('#criteria #idGroupVillage').html(data);
                    }
                });

            });

            $('#addFarmer #idRiverBasin').change(function(){
                var idRiverBasin =jQuery("#addFarmer #idRiverBasin option:selected").val();
                $('#addFarmer #idGroupVillage').html("");
                $.ajax({
                    url:"../util/loadGroupVillage.php",
                    method:"GET",
                    data:{"idRiverBasin":idRiverBasin},
                    dataType:"text",
                    success:function(data){

                        $('#addFarmer #idGroupVillage').html(data);
                    }
                });

            });

            $('#addFarmer #area').change(function(){
                var idArea =jQuery("#addFarmer #area option:selected").val();
                var idRiverBasin =jQuery("#addFarmer #idRiverBasin option:selected").val();
                $('#addFarmer #idGroupVillage').html("");
                $.ajax({
                    url:"../util/loadGroupVillage.php",
                    method:"GET",
                    data:{"idArea":idArea ,"idRiverBasin":idRiverBasin},
                    dataType:"text",
                    success:function(data){
                        $('#addFarmer #idGroupVillage').html(data);
                    },complete:function(){
                        $('#addFarmer #idGroupVillage').trigger('change');
                    }
                });

            });

            $('#addFarmer #idGroupVillage').change(function(){
                var gv = "";
                if($(this).val() !=null && $(this).val()!= undefined){
                    gv  = $(this).val();
                }
                if(gv.length>0 && gv.length == 9){
                    var PROV_CODE = gv.substring(0,2);
                    var AMP_CODE = gv.substring(2,4);
                    var TAM_CODE = gv.substring(4,6);
                    var VILL_CODE  = gv.substring(6,9);

                    $("#addFarmer #argprovince option[value='"+PROV_CODE+"']").attr('selected','selected');
                    $("#addFarmer #argprovince").trigger("change",[{"AMP_CODE":AMP_CODE,"TAM_CODE":TAM_CODE,"VILL_CODE":VILL_CODE}]);

                }
            });





            var argi_group_criteria={};
            $('#criteria #argi_group_type').change(function(){
                 var argi_group_type ;
                 var beforeData =[];
                 if($(this).val()!=null && $(this).val().length>1){
                   argi_group_type =   $(this).val().toString().split(',').map(Number);
                 }else if($(this).val()==null){
                    argi_group_sel_criteria.destroy();
                    argi_group_sel_criteria =    new SlimSelect({
                     select: '#criteria #argi_group',
                    });
                    argi_group_sel_criteria.set([]);
                    argi_group_sel_criteria.setData([]);
                   return false;
                 }
                 else{
                   argi_group_type =   parseInt($(this).val());
                 }


                 var argi_group_JsonArray =[];
                  $.ajax({
                      url:"../util/loadAgri.php",
                      method:"GET",
                      data:{"idArgiGroup":argi_group_type},
                      dataType:"text",
                      success:function(data){
                        argi_group_criteria = JSON.parse(data);
                        argi_group_sel_criteria.destroy();

                      },complete:function(){
                        argi_group_sel_criteria =    new SlimSelect({
                         select: '#criteria #argi_group',
                        });
                        beforeData = argi_group_sel_criteria.selected() ;
                        for(var i=0;i<argi_group_criteria.length;i++){
                         var j ={};
                           j["value"] = argi_group_criteria[i].idAgri;
                           j["text"]=argi_group_criteria[i].nameArgi;
                          argi_group_JsonArray.push(j);

                        }
                        argi_group_sel_criteria.setData(argi_group_JsonArray);

                        argi_group_sel_criteria.set(beforeData);

                      }
                  });
              });






      var argi_group={};
      $('#addFarmer #argi_group_type').change(function(){
           var argi_group_type ;
           var beforeData =[];
           if($(this).val()!=null && $(this).val().length>1){
             argi_group_type =   $(this).val().toString().split(',').map(Number);
           }else if($(this).val()==null){
             argi_group_sel_add.destroy();
             argi_group_sel_add =    new SlimSelect({
               select: '#addFarmer #argi_group',
              });
              argi_group_sel_add.set([]);
              argi_group_sel_add.setData([]);
             return false;
           }
           else{
             argi_group_type =   parseInt($(this).val());
           }


           var argi_group_JsonArray =[];
            $.ajax({
                url:"../util/loadAgri.php",
                method:"GET",
                data:{"idArgiGroup":argi_group_type},
                dataType:"text",
                success:function(data){
                 argi_group = JSON.parse(data);
                 argi_group_sel_add.destroy();

                },complete:function(){
                 argi_group_sel_add =    new SlimSelect({
                   select: '#addFarmer #argi_group',
                  });
                  beforeData = argi_group_sel_add.selected() ;
                  for(var i=0;i<argi_group.length;i++){
                   var j ={};
                     j["value"] = argi_group[i].idAgri;
                     j["text"]=argi_group[i].nameArgi;
                    argi_group_JsonArray.push(j);

                  }
                   argi_group_sel_add.setData(argi_group_JsonArray);

                   argi_group_sel_add.set(beforeData);

                }
            });
        });



        $('#editFarmer #argi_group_type').change(function(){
             var argi_group_type ;
             var beforeData =[];

             argi_group_sel_edit.set([]);
             argi_group_sel_edit.setData([]);


             if($(this).val()!=null && $(this).val().length>1){
               argi_group_type =   $(this).val().toString().split(',').map(Number);
             }else if($(this).val()==null){
               argi_group_sel_edit.destroy();
               argi_group_sel_edit =    new SlimSelect({
                 select: '#editFarmer #argi_group',
                });
                argi_group_sel_edit.set([]);
                argi_group_sel_edit.setData([]);
               return false;
             }
             else{
               argi_group_type =   parseInt($(this).val());
             }


             var argi_group_JsonArray =[];
              $.ajax({
                  url:"../util/loadAgri.php",
                  method:"GET",
                  data:{"idArgiGroup":argi_group_type},
                  dataType:"text",
                  success:function(data){
                   argi_group = JSON.parse(data);
                   argi_group_sel_edit.destroy();

                  },complete:function(){
                    argi_group_sel_edit =    new SlimSelect({
                     select: '#editFarmer #argi_group',
                    });
                    beforeData = argi_group_sel_edit.selected() ;
                    for(var i=0;i<argi_group.length;i++){
                     var j ={};
                       j["value"] = argi_group[i].idAgri;
                       j["text"]=argi_group[i].nameArgi;
                      argi_group_JsonArray.push(j);

                    }
                    argi_group_sel_edit.setData(argi_group_JsonArray);

                    argi_group_sel_edit.set(beforeData);

                  }
              });
          });






 $('#addFarmer #earnpay #deleteEarnPaybtn').on('click',function(e){
    var id =$(this).data('id');
    var idYearEarnPay =$(this).data('idyearearnpay-id');
    deleteEarnPay(id,idYearEarnPay,"#addFarmer");
});


$('#editFarmer #earnpay #deleteEarnPaybtn').on('click',function(e){
    var id =$(this).data('id');
    var idYearEarnPay =$(this).data('idyearearnpay-id');
    deleteEarnPay(id,idYearEarnPay,"#editFarmer");
});

 $('#addFarmer').on('hide.bs.modal', function (e) {
    earnPay=[];
    displayEarnPay("#addFarmer");
 });

 $('#addFarmer').on('show.bs.modal', function (e) {
    $('#addFarmer #idRiverBasin').trigger('change');
 });


 $('#editFarmer').on('hide.bs.modal', function (e) {
    earnPay=[];
    displayEarnPay('#editFarmer');

 });


 $('#editFarmer').on('show.bs.modal', function (e) {
    $('#editFarmer #idRiverBasin').trigger('change');
 });

 $('#addYearEarnPay').on('hide.bs.modal', function (e) {
    $("#addYearEarnPay input").val('');
 });

 $('#addYearEarnPay #addEarnPayBtn').on('click',function(){
    addYearEarnPayToTmp();
});

 $('#editYearEarnPay #editEarnPayBtn').on('click',function(){
    editYearEarnPayToTmp();
});

$('#editYearEarnPay').on('hide.bs.modal', function (e) {
    $("#editYearEarnPay input").val('');
 });





$("#isMemberBt").on('click',function(){
  var action=$('#MemberAction option:selected').val();
  var flag="";
    if(action==1){
      flag="Y";
    }else if(action==2){
      flag="N";
    }


    var person_ids=[];
    $('#farmerTable').DataTable().$('input[type="checkbox"]').each(function(){
         if(this.checked){
            person_ids.push(this.value);
         }
   });

   if(person_ids.length>0){
    $.ajax({
      type: "POST",
      data: {
          'action':'isMember',
          'person_ids':JSON.stringify(person_ids),
          'val':flag
      },
      url: "../handler/personHandler.php",
      dataType: "html",
      async: false,
      success: function(data) {
        Table.ajax.reload().draw();
        $('input:checkbox').removeAttr('checked');
      },complete:function(){
        clearData();
      }
    });
   }

});



$("#isMemberFarmerBt").on('click',function(){
  var action=$('#MemberFarmerAction option:selected').val();
  var flag="";
    if(action==1){
      flag="Y";
    }else if(action==2){
      flag="N";
    }


    var person_ids=[];
    $('#farmerTable').DataTable().$('input[type="checkbox"]').each(function(){
         if(this.checked){
            person_ids.push(this.value);
         }
   });

   if(person_ids.length>0){
    $.ajax({
      type: "POST",
      data: {
          'action':'isGroup',
          'person_ids':JSON.stringify(person_ids),
          'val':flag
      },
      url: "../handler/personHandler.php",
      dataType: "html",
      async: false,
      success: function(data) {
        Table.ajax.reload().draw();
        $('input:checkbox').removeAttr('checked');
      },complete:function(){
        clearData();
      }
    });
   }

});
spinner.show();
var Table= $('#farmerTable').DataTable( {
        "dom": '<"top"i>Brt<"bottom"lp><"clear">',
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

        'responsive': true,
        'buttons': [{
          'extend': 'collection',
          'className': 'exportButton',
          'text': 'Data Export',
          'buttons': [
              { 'extend':'copy',
              'action':newexportaction ,
                      'exportOptions': {
                        'modifier': {
                          'page': 'All',
                          'search': 'none'
                        },
                        'columns': [  1, 2, 3,4,5]
                    },

              },

              { 'extend':'csv',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'All',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4 ,5]
                },
              },

              { 'extend':'excel',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'All',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4,5 ]
                },
              },
              { 'extend':'print',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'ALL',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4 ,5]
                },
              },
            ]
        }],
        "pageLength": 10,
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": {url:"../server_side/personSS.php?idRiverBasin="+$("#RBAll").val()+"&idArea="+$("#AreaAll").val()+"&idPerson="+$("#idPerson_taget").val(),"type": "GET"},
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [
       {
        "targets": [0],
        "visible": false,
        "searchable": false
     },{
      'targets': [7],
      'width': 70,
      'searchable': false,
      'orderable': true,
      'className': 'dt-header-center',
      'render': function (data, type, full, meta){
          if(perm.indexOf(role)!=-1){
            return '<div style=" font-size: 20px; text-align: center;"><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editFarmer" data-id="'+data+'" id="editPerson"></i><i class=" fa fa-times" style="cursor: pointer;color: red;" id="deletePerson" data-id="'+data+'"  ></i></div>';
          }else{
            return '<div style=" font-size: 20px; text-align: center;"><i class="fa fa-edit" style="margin-right: 10px; color: gray;"></i> </div>';
          }

      }
    },{
        "targets": [6],
        "visible": false,
        "searchable": false
     }
      ],
       'order': [[6, 'desc']]
       ,"drawCallback": function( settings ) {
             spinner.hide()
         }
    }




    );


    $('#searchPerson').on('keyup',function(e) {

      if(this.value==""){
        clearSearch();
      }
      if(e.which == 13) {
        $('#criteria #idRiverBasin option[value=0]').attr('selected','selected');
        $('#criteria #area').html('');
        $('#criteria #isMember option[value=""]').attr('selected','selected');
        $('input:checkbox').removeAttr('checked');
        Table.destroy();
        spinner.show();
         Table= $('#farmerTable').DataTable( {
            "dom": '<"top"i>Brt<"bottom"lp><"clear">',
            "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

            'responsive': true,
            'buttons': [{
              'extend': 'collection',
              'className': 'exportButton',
              'text': 'Data Export',
              'buttons': [
                  { 'extend':'copy',
                  'action':newexportaction ,
                          'exportOptions': {
                            'modifier': {
                              'page': 'All',
                              'search': 'none'
                            },
                            'columns': [  1, 2, 3,4,5]
                        },

                  },

                  { 'extend':'csv',
                  'action':newexportaction ,
                  'exportOptions': {
                    'modifier': {
                      'page': 'All',
                      'search': 'none'
                      },
                      'columns': [  1, 2, 3,4 ,5]
                    },
                  },

                  { 'extend':'excel',
                  'action':newexportaction ,
                  'exportOptions': {
                    'modifier': {
                      'page': 'All',
                      'search': 'none'
                      },
                      'columns': [  1, 2, 3,4,5 ]
                    },
                  },
                  { 'extend':'print',
                  'action':newexportaction ,
                  'exportOptions': {
                    'modifier': {
                      'page': 'ALL',
                      'search': 'none'
                      },
                      'columns': [  1, 2, 3,4,5 ]
                    },
                  },



                ]
            }],
            "pageLength": 10,
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {url:"../server_side/personSS.php?name="+this.value+"&idRiverBasin="+$("#RBAll").val()+"&idArea="+$("#AreaAll").val(),"type": "GET"},
            "autoWidth": false,
            'fixedColumns':   {
              'heightMatch': 'none'
            },
            'columnDefs': [
           {
            "targets": [0],
            "visible": false,
            "searchable": false
         },{
          'targets': [7],
          'width': 70,
          'searchable': false,
          'orderable': true,
          'className': 'dt-header-center',
          'render': function (data, type, full, meta){
            if(perm.indexOf(role)!=-1){
              return '<div style=" font-size: 20px; text-align: center; "><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editFarmer" data-id="'+data+'" id="editPerson"></i> <i class=" fa fa-times" style="cursor: pointer;color: red;" id="deletePerson" data-id="'+data+'" ></i></div>';
            }else{
                return '<div style=" font-size: 20px;  text-align: center;"><i class="fa fa-edit" style="margin-right: 10px; color: gray;"></i>        </div>';
            }
        }
        },{
            "targets": [6],
            "visible": false,
            "searchable": false
         }
          ],
           'order': [[6, 'desc']]
           ,"drawCallback": function( settings ) {
                 spinner.hide()
             }
        }
      );

    }


    });



    $('#addPersonBtn').on('click',function(){
        var argpre =$('#addFarmer [name="argpre"] option:selected').val();
        var fname =$('#addFarmer input[name="argname"]').val();
        var lname =$('#addFarmer input[name="argsurname"]').val();
        var area =$('#addFarmer [name="idArea"] option:selected').val();
        var argid = $('#addFarmer input[name="argid"]').val();
        var religion =$('#addFarmer [name="religion"] option:selected').val();
        var tribes =$('#addFarmer [name="tribes"] option:selected').val();
        var pos_family=$('#addFarmer [name="pos_family"] option:selected').val();
        var familyCount=$('#addFarmer input[name="familyCount"]').val();
        var argbirth =$('#addFarmerForm #argbirth').val();
        var argprovince=$('#addFarmer [name="argprovince"] option:selected').val();
        var argdist=$('#addFarmer [name="argdist"] option:selected').val();
        var argsub=$('#addFarmer [name="argsub"] option:selected').val();
        var argno=$('#addFarmer input[name="argno"]').val();
        var road=$('#addFarmer input[name="road"]').val();
        var argmoo_no=$('#addFarmer input[name="argmoo_no"]').val();
        var argmoo_name=$('#addFarmer [name="argmoo_name"] option:selected').text();
        var argsub_moo=$('#addFarmer input[name="argsub_moo"]').val();
        var argzip_code=$('#addFarmer input[name="argzip_code"]').val();
        var argTel=$('#addFarmer input[name="argTel"]').val();
        var eduStatus=$('#addFarmer [name="eduStatus"] option:selected').val();
        var eduLevel=$('#addFarmer [name="eduLevel"] option:selected').val();
        var occupFirst=$('#addFarmer [name="occupFirst"] option:selected').val();
        var occupSecond=$('#addFarmer [name="occupSecond"] option:selected').val();
        var earnPerYear=$('#addFarmer input[name="earnPerYear"]').val();
        var payPerYear =$('#addFarmer input[name="payPerYear"]').val();
        var plots=$('#addFarmer input[name="plots"]').val();
        var rai=$('#addFarmer input[name="rai"]').val();
        var ngan =$('#addFarmer input[name="ngan"]').val();
        var sqaurewa=$('#addFarmer input[name="sqaure_wa"]').val();
        var argEmail=$('#addFarmer input[name="argEmail"]').val();
        var idRiverBasin =$('#addFarmer [name="idRiverBasin"] option:selected').val();


        var coop =$('#addFarmer #coop').is(':checked')?'Y':'N';
        var groupList= $("#addFarmer #slim-select").val()
        var img =$('#addFarmer .basic-img').attr('src');
        var idGroupVillage=$('#addFarmer #idGroupVillage option:selected').val();

        var statusPerson =$('#addFarmer #statusPerson option:selected').val();

        var file = $('#addFarmer #file').prop('files')[0];



       if(argbirth!=""){
        argbirth =  dateDBFM(argbirth);
        }

        var formData= new FormData();
        formData.append('fileToUpload',file);
        formData.append('argpre',argpre);
        formData.append('fname',fname);
        formData.append('lname',lname);
        formData.append('area',area);
        formData.append('argid',argid);
        formData.append('religion',religion);
        formData.append('tribes',tribes);
        formData.append('pos_family',pos_family);
        formData.append('familyCount',familyCount);
        formData.append('argbirth',argbirth);
        formData.append('argprovince',argprovince);
        formData.append('argsub',argsub);
        formData.append('argno',argno);
        formData.append('road',road);
        formData.append('argmoo_name',argmoo_name);
        formData.append('argsub_moo',argsub_moo);
        formData.append('argzip_code',argzip_code);
        formData.append('argTel',argTel);
        formData.append('eduStatus',eduStatus);
        formData.append('eduLevel',eduLevel);
        formData.append('occupFirst',occupFirst);
        formData.append('occupSecond',occupSecond);
        formData.append('earnPerYear',earnPerYear);
        formData.append('payPerYear',payPerYear);
        formData.append('plots',plots);
        formData.append('rai',rai);
        formData.append('ngan',ngan);
        formData.append('sqaurewa',sqaurewa);
        formData.append('argEmail',argEmail);
        formData.append('idRiverBasin',idRiverBasin);
        formData.append('action','add');
        formData.append('plots',plots);
        formData.append('argmoo_no',argmoo_no);
        formData.append('argdist',argdist);
        formData.append('coop',coop);
        formData.append('groupList',groupList);
        formData.append('idGroupVillage',idGroupVillage);
        formData.append('statusPerson',statusPerson);

        formData.append('earnPay',JSON.stringify(earnPay));

        if(img!="" && img !="../images/noPic.jpg"){
            formData.append('image',img);
          }

        var error=   validatePersonUser(formData,'#addFarmer');
        if(error>0){
            return false;
        }
        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            dataType:'text',
            data:formData,
            url: "../handler/personHandler.php",
            dataType: "html",
            async: false,
            success: function(data) {
              result=data;
              $('#addFarmer').modal('toggle');
            }
          });
    });



    $('#editFarmer').on('hidden.bs.modal', function () {
      $('#editFarmer input').val('');

       argi_group_type_sel_edit.set([]);
       argi_group_sel_edit.set([]);
       argi_group_sel_edit.setData([]);

  });


  $('#updatePersonBtn').on('click',function(){
    var argpre =$('#editFarmer [name="argpre"] option:selected').val();
    var fname =$('#editFarmer input[name="argname"]').val();
    var lname =$('#editFarmer input[name="argsurname"]').val();
    var area =$('#editFarmer [name="idArea"] option:selected').val();
    var argid = $('#editFarmer input[name="argid"]').val();
    var religion =$('#editFarmer [name="religion"] option:selected').val();
    var tribes =$('#editFarmer [name="tribes"] option:selected').val();
    var pos_family=$('#editFarmer [name="pos_family"] option:selected').val();
    var familyCount=$('#editFarmer input[name="familyCount"]').val();
    var argbirth =$('#editFarmer #argbirthE').val();
    var argprovince=$('#editFarmer [name="argprovince"] option:selected').val();
    var argdist=$('#editFarmer [name="argdist"] option:selected').val();
    var argsub=$('#editFarmer [name="argsub"] option:selected').val();
    var argno=$('#editFarmer input[name="argno"]').val();
    var road=$('#editFarmer input[name="road"]').val();
    var argmoo_no=$('#editFarmer input[name="argmoo_no"]').val();
    var argmoo_name=$('#editFarmer [name="argmoo_name"] option:selected').text();
    var argsub_moo=$('#editFarmer input[name="argsub_moo"]').val();
    var argzip_code=$('#editFarmer input[name="argzip_code"]').val();
    var argTel=$('#editFarmer input[name="argTel"]').val();
    var eduStatus=$('#editFarmer [name="eduStatus"] option:selected').val();
    var eduLevel=$('#editFarmer [name="eduLevel"] option:selected').val();
    var occupFirst=$('#editFarmer [name="occupFirst"] option:selected').val();
    var occupSecond=$('#editFarmer [name="occupSecond"] option:selected').val();
    var earnPerYear=0;
    var payPerYear =0;
    var plots=$('#editFarmer input[name="plots"]').val();
    var rai=$('#editFarmer input[name="rai"]').val();
    var ngan =$('#editFarmer input[name="ngan"]').val();
    var sqaurewa=$('#editFarmer input[name="sqaure_wa"]').val();
    var argEmail=$('#editFarmer input[name="argEmail"]').val();
    var idRiverBasin =$('#editFarmer [name="idRiverBasin"] option:selected').val();
    var idPerson=$('#editFarmer input[name="argnumber"]').val();
    var path=$('#editFarmer #path').val();
    var coop =$('#editFarmer #coop').is(':checked')?'Y':'N';
    var file = $('#editFarmer #file').prop('files')[0];
    var idGroupVillage=$('#editFarmer #idGroupVillage option:selected').val();
    var statusPerson =$('#editFarmer #statusPerson option:selected').val();

    var img =$('#addFarmerForm .basic-img').attr('src');

    var agriList =argi_group_sel_edit.selected();

    if(argbirth!=""){
        argbirth =  dateDBFM(argbirth);
     }

    var formData= new FormData();
    formData.append('fileToUpload',file);
    formData.append('argpre',argpre);
    formData.append('fname',fname);
    formData.append('lname',lname);
    formData.append('area',area);
    formData.append('argid',argid);
    formData.append('religion',religion);
    formData.append('tribes',tribes);
    formData.append('pos_family',pos_family);
    formData.append('familyCount',familyCount);
    formData.append('argbirth',argbirth);
    formData.append('argprovince',argprovince);
    formData.append('argsub',argsub);
    formData.append('argno',argno);
    formData.append('road',road);
    formData.append('argmoo_name',argmoo_name);
    formData.append('argsub_moo',argsub_moo);
    formData.append('argzip_code',argzip_code);
    formData.append('argTel',argTel);
    formData.append('eduStatus',eduStatus);
    formData.append('eduLevel',eduLevel);
    formData.append('occupFirst',occupFirst);
    formData.append('occupSecond',occupSecond);
    formData.append('earnPerYear',earnPerYear);
    formData.append('payPerYear',payPerYear);
    formData.append('plots',plots);
    formData.append('rai',rai);
    formData.append('ngan',ngan);
    formData.append('sqaurewa',sqaurewa);
    formData.append('argEmail',argEmail);
    formData.append('idRiverBasin',idRiverBasin);
    formData.append('action','update');
    formData.append('plots',plots);
    formData.append('argdist',argdist);
    formData.append('idPerson',idPerson);
    formData.append('argmoo_no',argmoo_no);
    formData.append('path',path);
    formData.append('coop',coop);
    formData.append('agriList',agriList);
    formData.append('idGroupVillage',idGroupVillage);
    formData.append('statusPerson',statusPerson);

    formData.append('earnPay',JSON.stringify(earnPay));
    if(img!="" && img !="../images/noPic.jpg"){
        formData.append('image',img);
      }

    var error=   validatePersonUser(formData,'#editFarmer');
    if(error>0){
        return false;
    }
    $.ajax({
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      dataType:'text',
      data:formData,
      url: "../handler/personHandler.php",
      dataType: "html",
      async: false,
      success: function(data) {
        result=data;
        $('#editFarmer').modal('toggle');
      },complete:function(){
          Table.ajax.reload();
        }
      });
});

$('#addFarmer').on('hidden.bs.modal', function () {
    Table.ajax.reload();
    $('input:checkbox').removeAttr('checked');

        argi_group_type_sel_add.set([]);
        argi_group_sel_add.set([]);
        argi_group_sel_add.setData([]);

});
$('#editFarmer').on('hidden.bs.modal', function () {
  $('#editFarmer input').val('');
  $('input:checkbox').removeAttr('checked');
  $('#editFarmer #qrcode canvas').remove();
  $('#editFarmer [name="argprovince"] option').each(function(){   this.removeAttribute('selected');   })

});

$('#farmerTable').on('draw.dt', function() {
  $('input:checkbox').removeAttr('checked');
});

    $('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = Table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });


   $('#addFarmer #idRiverBasin').change(function(){
      var idRiverBasin = $(this).val();
      var AreaAll = $("#AreaAll").val();
       $.ajax({
           url:"../util/AreaDependentWithRole.php",
           method:"POST",
           data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
           dataType:"text",
           success:function(data){
               $('#addFarmer #area').html(data);
           },complete:function(){
            $('#addFarmer #area').trigger('change');
       }

       });
   });

   $('#criteria #idRiverBasin').change(function(){
      var idRiverBasin = $(this).val();
      var AreaAll = $("#AreaAll").val();
       $.ajax({
           url:"../util/AreaDependentWithRole.php",
           method:"POST",
           data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
           dataType:"text",
           success:function(data){
               $('#criteria  #area').html(data);
           },complete:function(){
                $('#criteria #area').trigger('change');
           }
       });
   });


   $('#criteria #idRiverBasin').trigger('change');

   $('#editFarmer #idRiverBasin').change(function(){
      var idRiverBasin = $(this).val();
      var AreaAll = $("#AreaAll").val();
       $.ajax({
           url:"../util/AreaDependentWithRole.php",
           method:"POST",
           data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
           dataType:"text",
           success:function(data){
               $('#editFarmer [name="idArea"]').html(data);
           },complete:function(){
            $('#editFarmer [name="idArea"]').trigger('change');
           }
       });
   });

   $('#editFarmer #idRiverBasin').change(function(){
    var idRiverBasin =jQuery("#editFarmer #idRiverBasin option:selected").val();
    $('#editFarmer #idGroupVillage').html("");
    $.ajax({
        url:"../util/loadGroupVillage.php",
        method:"GET",
        data:{"idRiverBasin":idRiverBasin},
        dataType:"text",
        success:function(data){

            $('#editFarmer #idGroupVillage').html(data);
        }
    });

});

$('#editFarmer [name="idArea"]').change(function(){
    var idArea =jQuery("#editFarmer [name='idArea'] option:selected").val();
    var idRiverBasin =jQuery("#editFarmer #idRiverBasin option:selected").val();
    $('#editFarmer #idGroupVillage').html("");
    $.ajax({
        url:"../util/loadGroupVillage.php",
        method:"GET",
        data:{"idArea":idArea ,"idRiverBasin":idRiverBasin},
        dataType:"text",
        success:function(data){

            $('#editFarmer #idGroupVillage').html(data);
        }
    });

});


   $('#addFarmer #argprovince').on("change",function(e, data){
    var PROV_CODE = $(this).val();

     $.ajax({
         url:"../util/AmphurDependent.php",
         method:"POST",
         data:{PROV_CODE:PROV_CODE},
         dataType:"text",
         success:function(data){
             $('#addFarmer #argdist').html(data);
             $('#addFarmer #argsub').html('');
             $('#addFarmer #argmoo_name').html('');
             $('#addFarmer [name="argmoo_no"]').val('');
         },complete:function(){
            if(data!= undefined && data.AMP_CODE !=undefined && data.AMP_CODE != null && data.AMP_CODE !=""){
                $("#addFarmer #argdist option[value='"+data.AMP_CODE+"']").attr('selected','selected');
                $('#addFarmer #argdist').trigger("change",data);
                $('#addFarmer #argzip_code').val("");
                $.ajax({
                    url:"../util/loadZipCode.php",
                    method:"GET",
                    data:{"districtCode":PROV_CODE+data.AMP_CODE+data.AMP_CODE},
                    dataType:"text",
                    success:function(data){
                        $('#addFarmer input[name="argzip_code"]').val(data);
                    }

                });
            }



         }
     });
 });

 $('#addFarmer #argdist').change(function(e, data){
  var AMP_CODE = $(this).val();
  var PROV_CODE =  $('#addFarmer #argprovince option:selected').val();

   $.ajax({
       url:"../util/TamDependent.php",
       method:"POST",
       data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE},
       dataType:"text",
       success:function(data){
           $('#addFarmer #argsub').html(data);
           $('#addFarmer #argmoo_name').html('');
           $('#addFarmer [name="argmoo_no"]').val('');
       },complete:function(){
        if(data!= undefined && data.TAM_CODE !=undefined && data.TAM_CODE != null && data.TAM_CODE !=""){
            $("#addFarmer #argsub option[value='"+data.TAM_CODE+"']").attr('selected','selected');
            $('#addFarmer #argsub').trigger("change",data);
        }

     }
   });
});

$('#addFarmer #argsub').change(function(e, data){
  $('#addFarmer #argmoo_name').html('');
  var TAM_CODE = $(this).val();
  var PROV_CODE =  $('#addFarmer #argprovince option:selected').val();
  var AMP_CODE =  $('#addFarmer #argdist option:selected').val();
   $.ajax({
       url:"../util/VillageDependent.php",
       method:"POST",
       data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE ,TAM_CODE:TAM_CODE},
       dataType:"text",
       success:function(data){
           $('#addFarmer #argmoo_name').html(data);
       }
       ,complete:function(){
        if(data!= undefined && data.VILL_CODE !=undefined && data.VILL_CODE != null && data.VILL_CODE !=""){
            $("#addFarmer #argmoo_name option[value='"+data.VILL_CODE+"']").attr('selected','selected');

        }

     }
   });
});
$('#addFarmer #argmoo_name').change(function(){
  var argmoo_no = $(this).val();
  $('#addFarmer [name="argmoo_no"]').val(argmoo_no);

});


$('#editFarmer #argprovince').change(function(){
  var PROV_CODE = $(this).val();
   $.ajax({
       url:"../util/AmphurDependent.php",
       method:"POST",
       data:{PROV_CODE:PROV_CODE},
       dataType:"text",
       success:function(data){
           $('#editFarmer #argdist').html(data);
           $('#editFarmer #argsub').html('');
           $('#editFarmer #argmoo_name').html('');
           $('#editFarmer [name="argmoo_no"]').val('');
       }
   });
});

$('#editFarmer #argdist').change(function(){
var AMP_CODE = $(this).val();
var PROV_CODE =  $('#editFarmer #argprovince option:selected').val();
 $.ajax({
     url:"../util/TamDependent.php",
     method:"POST",
     data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE},
     dataType:"text",
     success:function(data){
         $('#editFarmer #argsub').html(data);
         $('#editFarmer #argmoo_name').html('');
         $('#editFarmer [name="argmoo_no"]').val('');

     }
 });
});

$('#editFarmer #argsub').change(function(){
$('#editFarmer #argmoo_name').html('');
var TAM_CODE = $(this).val();
var PROV_CODE =  $('#editFarmer #argprovince option:selected').val();
var AMP_CODE =  $('#editFarmer #argdist option:selected').val();
 $.ajax({
     url:"../util/VillageDependent.php",
     method:"POST",
     data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE ,TAM_CODE:TAM_CODE},
     dataType:"text",
     success:function(data){
         $('#editFarmer #argmoo_name').html(data);
     }
 });
});
$('#editFarmer #argmoo_name').change(function(){
  var argmoo_no = $(this).val();
  $('#editFarmer [name="argmoo_no"]').val(argmoo_no);

});



   $('#criteria #search_person').on('click',function(){
      var idRiverBasin =$('#criteria #idRiverBasin option:selected').val();
      var idArea =$('#criteria #area option:selected').val();
      if(idArea ==0 || idArea == undefined){
        idArea  =$("#AreaAll").val();
      }
      var argi_group_type =  jQuery("#criteria #argi_group_type").val()==null?'':jQuery("#criteria #argi_group_type").val().toString();
      var argi_group =jQuery("#criteria #argi_group").val()==null?'':jQuery("#criteria #argi_group").val().toString();
      Table.destroy();
      spinner.show();

      Table= $('#farmerTable').DataTable( {
        "dom": '<"top"i>Brt<"bottom"lp><"clear">',
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

        'responsive': true,
        'buttons': [{
          'extend': 'collection',
          'className': 'exportButton',
          'text': 'Data Export',
          'buttons': [
              { 'extend':'copy',
              'action':newexportaction ,
                      'exportOptions': {
                        'modifier': {
                          'page': 'All',
                          'search': 'none'
                        },
                        'columns': [  1, 2, 3,4,5]
                    },

              },

              { 'extend':'csv',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'All',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4 ,5]
                },
              },

              { 'extend':'excel',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'All',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4,5 ]
                },
              },
              { 'extend':'print',
              'action':newexportaction ,
              'exportOptions': {
                'modifier': {
                  'page': 'ALL',
                  'search': 'none'
                  },
                  'columns': [  1, 2, 3,4 ,5]
                },
              },
            ]
        }],
        "pageLength": 10,
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ajax": {url:"../server_side/personSS.php?idGroupVillage="+$("#criteria #idGroupVillage option:selected").val()+"&idRiverBasin="+idRiverBasin+'&idArea='+idArea+"&argi_group_type="+argi_group_type+"&argi_group="+argi_group ,"type": "GET"},
        "autoWidth": false,
        'fixedColumns':   {
          'heightMatch': 'none'
        },
        'columnDefs': [
       {
        "targets": [0],
        "visible": false,
        "searchable": false
     },{
      'targets': [7],
      'width': 70,
      'searchable': false,
      'orderable': true,
      'className': 'dt-header-center',
      'render': function (data, type, full, meta){

        if(perm.indexOf(role)!=-1){
            return '<div style=" font-size: 20px;text-align: center; "><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editFarmer" data-id="'+data+'" id="editPerson"></i> <i class=" fa fa-times" style="cursor: pointer;color: red;" id="deletePerson" data-id="'+data+'" ></i></div>';
        }else{
         return '<div style=" font-size: 20px; text-align: center;"><i class="fa fa-edit" style="margin-right: 10px; color: gray;"></i>     </div>';
        }



     }
    },{
        "targets": [6],
        "visible": false,
        "searchable": false
     }
      ],
       'order': [[6, 'desc']]
       ,"drawCallback": function( settings ) {
             spinner.hide()
         }
    }
  );




   });
   $('#criteria #clear_person').on('click',function(){
    clearSearch();
   });



   $('#farmerTable tbody').on( 'click', '#deletePerson', function () {
      var name =$(this).closest("tr").find('td:eq(1)').text();
      var person_id = $(this).attr("data-id");
        var status =false;
      if (!confirm("ต้องการลบข้อมูล :"+name)){
        return false;
      }
      $.ajax({
        url: "../util/checkPerson.php?person_id="+person_id,
        type: "GET",
        dataType: "html",
        async: false,
        success:function(data){
         if(data >0){
             alert(" "+name+" มีข้อมูลการส่งมอบผลผลิตอยู่ \n จึงไม่สามารถลบข้อมูลได้ ");
            return false;
         }
         status =true;
        }
    });
    if(status){
        $.ajax({
                url: "../handler/personHandler.php?person_id="+person_id,
                type: "POST",
                dataType: "html",
                async: false,
                data:{'person_id':person_id,'action':'delete'},
                success:function(data){
                console.log(data);
                    Table.ajax.reload().draw();
                    $('input:checkbox').removeAttr('checked');
                }
            });
    }



  } );


   $(document).on("click", "#editPerson", function () {
      var person_id = $(this).data('id');

      $('#editFarmer #qrcode').qrcode(window.location.origin+"/view/editPersonView.php?person_id="+person_id);
      $("#editFarmer input[name='person_id']").val( person_id );
      $.ajax({
        url: "../handler/personHandler.php?person_id="+person_id,
        type: "POST",
        dataType: "html",
        async: false,
        data:{'person_id':person_id,'action':'load'},
        success:function(data){
          var personEdit =JSON.parse(data);
          mapDataPerson(personEdit,'#editFarmer ');
        }
    });

  function mapDataPerson(data ,mode){

    var d = new Date();
    var pathImg="../img/Activity/";
  $(mode+'[name="argpre"] option[value="'+data.Prefix_idPrefix+'"]').attr("selected",true);
  $(mode+'[name="argnumber"]').val(data.idPerson);
  $(mode+'input[name="argname"]').val(data.firstName);
  $(mode+'input[name="argsurname"]').val(data.lastName);
  if(data.picName ==null || data.picName ==""){

    $(mode+' .basic-img').attr('src',"../images/noPic.jpg?ver=" + d.getTime());
  }else{
    $(mode+' .basic-img').attr('src',pathImg+data.picName+"?ver=" + d.getTime());
  }

  $(mode+' #path').val(data.picName);

  $(mode+'#statusPerson option[value="'+data.statusPerson+'"]').attr("selected",true);


  var landDetails = data.landDetails;
  var htmlLandDetail ="";
  $(mode+' #landDetail').html();
  for(var i=0;i<landDetails.length;i++){
    htmlLandDetail +="<li class='list-group-item col-md-12'><div class='col-md-2'>  เลขที่แปลง :"+landDetails[i].land_no+"</div>";
    htmlLandDetail +="<div class='col-md-4'> พิกัด X:"+landDetails[i].x+" , Y:"+landDetails[i].y+"   ความสูง:"+landDetails[i].z+"</div>";
    htmlLandDetail +="<div class='col-md-6'> จำนวน:"+landDetails[i].plots+" แปลง  พื้นที่: "+landDetails[i].rai+"-"+landDetails[i].ngan+"-"+landDetails[i].sqaurewa+" ไร่ </div>";
    htmlLandDetail +="</li>";
  }
  $(mode+' #landDetail').html(htmlLandDetail);




  var yearEarnPay = data.yearEarnPay;
  for(var i=0 ;i<yearEarnPay.length;i++){
    var tmp = yearEarnPay[i];
    tmp["id"] = Math.random();
    earnPay.push(tmp);
  }

  displayEarnPay(mode);

  var person_id = data.idPerson;
  $(mode+' #personGroup').html();
  var htmlPersonGroup ="";

  var formData = new  FormData();
  formData.append("person_id",person_id);
  formData.append("action","loadPersonGroup");


  jQuery.ajax({
      type: "POST",
      cache: false,
      contentType: false,
      processData: false,
      dataType:'text',
      data:formData,
      url: "../handler/personGroupHandler.php",
      dataType: "html",
      async: true,
      success: function(data) {
        var personGroup = JSON.parse(data);
        for(var i=0;i<personGroup.length;i++){
            htmlPersonGroup +="<li class='list-group-item col-md-12'><div class='col-md-12'>"+personGroup[i].areaName+" "+personGroup[i].INSTITUTE_NAME+" "+personGroup[i].sub_group_name+"</div></li>";
        }
        $(mode+' #personGroup').html(htmlPersonGroup);
      }
    });


  var regisAgri = data.agriList;
  for(var i=0;i<regisAgri.length;i++){
    var agri_type =regisAgri[i].TypeOfArgi_idTypeOfArgi;
    argi_group_type_sel_edit.set(agri_type);

      var argi_group_JsonArray =[];
      argi_group_sel_edit.destroy();
          $.ajax({
            url:"../util/loadAgri.php",
            method:"GET",
            data:{"idArgiGroup":agri_type},
            dataType:"text",
            success:function(data_argi){
                argi_group = JSON.parse(data_argi);
                for(var i=0;i<argi_group.length;i++){
                  var j ={};
                    j["value"] = argi_group[i].idAgri;
                    j["text"]=argi_group[i].nameArgi;
                  argi_group_JsonArray.push(j);
                }
                argi_group_sel_edit.setData(argi_group_JsonArray);
            },complete:function(){

              for(var i=0;i<regisAgri.length;i++){
                var agri_sel =regisAgri[i].idAgri;
                argi_group_sel_edit.set(agri_sel);

              }

            }
        });
      }


    var idRiverBasin = data.RiverBasin_idRiverBasin;
    var AreaAll = $("#AreaAll").val();
    if(AreaAll.split(',').length>1){
        $.ajax({
            url:"../util/AreaDependentWithRole.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
            dataType:"text",
            async:true,
            success:function(dataarea){
                $(mode+'#area').html(dataarea);
            },
            complete:function(){
             $(mode+'#idRiverBasin option[value="'+data.RiverBasin_idRiverBasin+'"]').attr("selected",true);
             $(mode+'[name="idArea"] option[value="'+data.Area_idArea+'"]').attr("selected",true);
             $.ajax({
               url:"../util/loadGroupVillage.php",
               method:"GET",
               async:true,
               data:{"idRiverBasin":data.RiverBasin_idRiverBasin,"idArea":data.Area_idArea},
               dataType:"text",
               success:function(dataG){
                   $(mode+'#idGroupVillage').html(dataG);
               },
               complete:function(){
                $(mode+'#idGroupVillage option[value="'+data.idGroupVillage+'"]').attr("selected",true);

               }
           });

            }
        });
    }else{
        $.ajax({
            url:"../util/AreaDependentWithRole.php",
            method:"POST",
            data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
            dataType:"text",
            async:false,
            success:function(dataarea){
                $(mode+'#area').html(dataarea);
            },
            complete:function(){
             $(mode+'#idRiverBasin option[value="'+data.RiverBasin_idRiverBasin+'"]').attr("selected",true);
             $(mode+'[name="idArea"] option[value="'+data.Area_idArea+'"]').attr("selected",true);
             $.ajax({
               url:"../util/loadGroupVillage.php",
               method:"GET",
               async:false,
               data:{"idRiverBasin":data.RiverBasin_idRiverBasin,"idArea":data.Area_idArea},
               dataType:"text",
               success:function(dataG){
                   $(mode+'#idGroupVillage').html(dataG);
               },
               complete:function(){
                $(mode+'#idGroupVillage option[value="'+data.idGroupVillage+'"]').attr("selected",true);

               }
           });

            }
        });

    }

     /*$(mode+'#idRiverBasin option[value="'+data.RiverBasin_idRiverBasin+'"]').attr("selected",true).trigger('change');
     $(mode+'[name="idArea"] option[value="'+data.Area_idArea+'"]').attr("selected",true).trigger('change');
     $(mode+'#idGroupVillage option[value="'+data.idGroupVillage+'"]').attr("selected",true);*/
     var Area_idArea = data.Area_idArea;








  $(mode+'input[name="argid"]').val(data.idcard);
  $(mode+'[name="religion"] option[value="'+data.religionName+'"]').attr("selected",true);



     if(data.tribeName!=0 || data.tribeName!=null){
        $(mode+'[name="tribes"] option[value="'+data.tribeName+'"]').attr("selected",true);
      }else{
        $(mode+'[name="tribes"] option:eq(1)').attr("selected",true);
      }



  $(mode+'[name="pos_family"] option[value="'+data.pos_family+'"]').attr("selected",true);
  $(mode+'input[name="familyCount"]').val(data.familyCount);
  $(mode+'input[name="argbirth"]').val();
  $(mode+'[name="argprovince"] option[value="'+data.Province_idProvince+'"]').attr("selected",true);
  var PROV_CODE = data.Province_idProvince;
  $.ajax({
      url:"../util/AmphurDependent.php",
      method:"POST",
      data:{PROV_CODE:PROV_CODE},
      dataType:"text",
      success:function(data){
          $('#editFarmer #argdist').html(data);
      },complete:function(){
        $(mode+'[name="argdist"] option[value="'+data.Amphur_idAmphur+'"]').attr("selected",true);
      }
  });
  var AMP_CODE = data.Amphur_idAmphur;
 $.ajax({
     url:"../util/TamDependent.php",
     method:"POST",
     data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE},
     dataType:"text",
     success:function(data){
         $('#editFarmer #argsub').html(data);
     },complete:function(){
       $(mode+'[name="argsub"] option[value="'+data.districtName+'"]').attr("selected",true);
     }
 });

var TAM_CODE = data.districtName;
$('#editFarmer #argmoo_name').html('');
 $.ajax({
     url:"../util/VillageDependent.php",
     method:"POST",
     data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE ,TAM_CODE:TAM_CODE},
     dataType:"text",
     success:function(data){
      $('#editFarmer #argmoo_name').html(data);
     },complete:function(){
      $(mode+'[name="argmoo_name"] option:contains("'+data.mooName+'")').attr("selected",true);
     }
 });
/*
 var dateStr='01-01-1990';
 if(data.birthday!=null){
    var birthday = new Date(data.birthday.date.substring(0,10));
    var date = birthday.getDate();
    var month= birthday.getMonth()+1;
    var year= birthday.getFullYear();
     dateStr =zeroPad(date,2)+'-'+zeroPad(month,2)+'-'+year;
 }*/


 var d = new Date(data.birthday.date);

   $(mode+'.argbirthETmp').datepicker({
     format: "dd MM yyyy",
     language:  'th',
     changeMonth: false,
     changeYear: false,
     thaiyear: true,
     stepMonths: 0
 }).datepicker('setDate',d);


  $(mode+'input[name="argno"]').val(data.address);
  $(mode+'input[name="road"]').val(data.road);
  $(mode+'input[name="argmoo_no"]').val(data.moo);
  $(mode+'input[name="argsub_moo"]').val(data.subMooName);
  $(mode+'input[name="argzip_code"]').val(data.postcode);
  $(mode+'input[name="argTel"]').val(data.phoneNumber);
  $(mode+'[name="eduStatus"] option[value="'+data.EduStatus_idEduStatus+'"]').attr("selected",true);
  $(mode+'[name="eduLevel"] option[value="'+data.EduLevel_idEduLevel+'"]').attr("selected",true);
  $(mode+'[name="occupFirst"] option[value="'+data.occupFirst+'"]').attr("selected",true);
  $(mode+'[name="occupSecond"] option[value="'+data.occupSecond+'"]').attr("selected",true);
  $(mode+'input[name="earnPerYear"]').val(data.earnPerYear);
  $(mode+'input[name="payPerYear"]').val(data.payPerYear);
  $(mode+'input[name="plots"]').val(data.plots);
  $(mode+'input[name="rai"]').val(data.rai);
  $(mode+'input[name="ngan"]').val(data.ngan);
  $(mode+'input[name="sqaure_wa"]').val(data.sqaurewa);
  $(mode+'input[name="argEmail"]').val(data.email);
    if(data.coop=='Y'){
      $(mode+' #coop').prop('checked', true);
    }
  }

});

function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}



$('#IsMember').on('click',function(){
  var person_ids=[];
  $('#farmerTable').DataTable().$('input[type="checkbox"]').each(function(){
       if(this.checked){
          person_ids.push(this.value);
       }
 });

 if(person_ids.length>0){
  $.ajax({
    type: "POST",
    data: {
        'action':'isMember',
        'person_ids':JSON.stringify(person_ids),
        'val':'Y'
    },
    url: "../handler/personHandler.php",
    dataType: "html",
    async: false,
    success: function(data) {
      Table.ajax.reload().draw();
      $('input:checkbox').removeAttr('checked');
    },complete:function(){
      clearData();
    }
  });
 }

});


$('#NotMember').on('click',function(){
  var person_ids=[];
  $('#farmerTable').DataTable().$('input[type="checkbox"]').each(function(){
       if(this.checked){
          person_ids.push(this.value);
       }
 });

 if(person_ids.length>0){
  $.ajax({
    type: "POST",
    data: {
        'action':'isMember',
        'person_ids':JSON.stringify(person_ids),
        'val':'N'
    },
    url: "../handler/personHandler.php",
    dataType: "html",
    async: false,
    success: function(data) {
      Table.ajax.reload().draw();
      $('input:checkbox').removeAttr('checked');
    },complete:function(){
      clearData();
    }
  });
 }

});

function clearSearch(){
  $('#criteria #idRiverBasin option[value=0]').attr('selected','selected');
  $('#criteria #area').html('');
  $('#criteria #idGroupVillage option[value=0]').attr('selected','selected');
  $('#criteria #isMember option[value=""]').attr('selected','selected');
  $('input:checkbox').removeAttr('checked');
  argi_group_type_sel_criteria.set([]);
  argi_group_sel_criteria.set([]);
  spinner.show();
  Table.destroy();
  Table= $('#farmerTable').DataTable( {
    "dom": '<"top"i>Brt<"bottom"lp><"clear">',
    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],

    'responsive': true,
    'buttons': [{
      'extend': 'collection',
      'className': 'exportButton',
      'text': 'Data Export',
      'buttons': [
          { 'extend':'copy',
          'action':newexportaction ,
                  'exportOptions': {
                    'modifier': {
                      'page': 'All',
                      'search': 'none'
                    },
                    'columns': [  1, 2, 3,4,5]
                },

          },

          { 'extend':'csv',
          'action':newexportaction ,
          'exportOptions': {
            'modifier': {
              'page': 'All',
              'search': 'none'
              },
              'columns': [  1, 2, 3,4,5 ]
            },
          },

          { 'extend':'excel',
          'action':newexportaction ,
          'exportOptions': {
            'modifier': {
              'page': 'All',
              'search': 'none'
              },
              'columns': [  1, 2, 3,4,5 ]
            },
          },
          { 'extend':'print',
          'action':newexportaction ,
          'exportOptions': {
            'modifier': {
              'page': 'ALL',
              'search': 'none'
              },
              'columns': [  1, 2, 3,4,5 ]
            },
          },



        ]
    }],
    "pageLength": 10,
    "processing": true,
    "responsive": true,
    "serverSide": true,
    "ajax": {url:"../server_side/personSS.php?idGroupVillage="+$("#criteria #idGroupVillage option:selected").val()+"&idRiverBasin="+$("#RBAll").val()+"&idArea="+$("#AreaAll").val() ,"type": "GET"},
    "autoWidth": false,
    'fixedColumns':   {
      'heightMatch': 'none'
    },
    'columnDefs': [
   {
    "targets": [0],
    "visible": false,
    "searchable": false
 },{
  'targets': [7],
  'width': 70,
  'searchable': false,
  'orderable': true,
  'className': 'dt-header-center',
  'render': function (data, type, full, meta){

    if(perm.indexOf(role)!=-1){
        return '<div style=" font-size: 20px; "><i class="fa fa-edit" style=" cursor: pointer;margin-right: 10px; color: blue;" data-toggle="modal" data-target="#editFarmer" data-id="'+data+'" id="editPerson"></i>        <i class=" fa fa-times" style="cursor: pointer;color: red;" id="deletePerson" data-id="'+data+'" ></i></div>';
    }else{
     return '<div style=" font-size: 20px; "><i class="fa fa-edit" style="margin-right: 10px; color: gray;"></i>        <i class=" fa fa-times" style="color: gray;" ></i></div>';
    }




  }
},{
    "targets": [6],
    "visible": false,
    "searchable": false
 }
  ],
   'order': [[6, 'desc']]
   ,"drawCallback": function( settings ) {
         spinner.hide()
     }
}
);


}


function clearData(){
  $("input[name='select_all']").prop( "checked", false );
  $('#editFarmer #qrcode canvas').remove();

}

$(function() {
  $(":file").change(function() {
      if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = imageIsLoaded;
          reader.readAsDataURL(this.files[0]);
      }
  });
});
function imageIsLoaded(e) {
  $('.basic-img').attr('src', e.target.result);
};


function newexportaction(e, dt, button, config) {
  var self = this;
  var oldStart = dt.settings()[0]._iDisplayStart;
  dt.one('preXhr', function (e, s, data) {
      // Just this once, load all data from the server...
      data.start = 0;
      data.length = 2147483647;
      dt.one('preDraw', function (e, settings) {
          // Call the original action function
          if (button[0].className.indexOf('buttons-copy') >= 0) {
              $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-excel') >= 0) {
              $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-csv') >= 0) {
              $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
              $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                  $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                  $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
          } else if (button[0].className.indexOf('buttons-print') >= 0) {
              $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
          }
          dt.one('preXhr', function (e, s, data) {
              // DataTables thinks the first item displayed is index 0, but we're not drawing that.
              // Set the property to what it was before exporting.
              settings._iDisplayStart = oldStart;
              data.start = oldStart;
          });
          // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
          setTimeout(dt.ajax.reload, 0);
          // Prevent rendering of the full data to the DOM
          return false;
      });
  });
  // Requery the server with the new one-time export settings
  dt.ajax.reload();
};



function displayEarnPay(mode){
    $(mode+' #earnpay tbody').html("");
    var htmlYearEarnPay ="";
    for(var i=0;i<earnPay.length;i++){
      htmlYearEarnPay +="<tr>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+(i+1)+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].yearGetPay+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].earnPerYear+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].payPerYear+"</td>";
          htmlYearEarnPay +="<td class='row'><i class='fa fa-times col-sm-6' style='cursor: pointer;color: red;text-align: left;padding: 5px;' id='deleteEarnPaybtn' data-id="+earnPay[i].id+" data-idYearEarnPay-id="+earnPay[i].idYearEarnPay+"></i></td>";

      htmlYearEarnPay +="/<tr>";
    }
    $(mode+' #earnpay tbody').html(htmlYearEarnPay);

 }

 function deleteEarnPay(id,idYearEarnPay,mode){

    if (!confirm("ต้องการลบข้อมูล")){
        return false;
      }
      $.ajax({
        url: "../handler/yearEarnPayHandler.php",
        type: "POST",
        dataType: "html",
        async: false,
        data:{'id_year_earn_pay':idYearEarnPay,'action':'delete'},
        success:function(data){
            earnPay = earnPay.filter(function( obj ) {
                return obj.id !== id;
              });
        },complete:function(){
           displayEarnPay(mode);
        }
    });

 }

  function addYearEarnPayToTmp(){
    var yearGetPay = $("#addYearEarnPay #yearGetPay").val();
    var earnPerYear = 0;
    var payPerYear = 0;
    if($("#addYearEarnPay #earnPerYear").val() !=undefined && $("#addYearEarnPay #earnPerYear").val()!=null){
        earnPerYear =  parseFloat($("#addYearEarnPay #earnPerYear").val());
    }
    if($("#addYearEarnPay #payPerYear").val() !=undefined && $("#addYearEarnPay #payPerYear").val()!=null){
        payPerYear =  parseFloat($("#addYearEarnPay #payPerYear").val());
    }

    var data = {};
    data["earnPerYear"]=toMoney(earnPerYear);
    data["payPerYear"]=toMoney(payPerYear);
    data["yearGetPay"]=yearGetPay;
    data["idYearEarnPay"]=0;
    data["idPerson"]=$("input[name='argnumber']").val();
    data["id"]=Math.random();
    earnPay.push(data);
    displayEarnPay("#addFarmer");
    setTimeout(function(){ $('#addYearEarnPay').modal('toggle'); }, 300);

    $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay,"#addFarmer");
    });
 }

 function editYearEarnPayToTmp(){
    var yearGetPay = $("#editYearEarnPay #yearGetPay").val();
    var earnPerYear = 0;
    var payPerYear = 0;
    if($("#editYearEarnPay #earnPerYear").val() !=undefined && $("#editYearEarnPay #earnPerYear").val()!=null){
        earnPerYear =  parseFloat($("#editYearEarnPay #earnPerYear").val());
    }
    if($("#editYearEarnPay #payPerYear").val() !=undefined && $("#addYearEarnPay #payPerYear").val()!=null){
        payPerYear =  parseFloat($("#editYearEarnPay #payPerYear").val());
    }

    var data = {};
    data["earnPerYear"]=toMoney(earnPerYear);
    data["payPerYear"]=toMoney(payPerYear);
    data["yearGetPay"]=yearGetPay;
    data["idYearEarnPay"]=0;
    data["idPerson"]=$("input[name='argnumber']").val();
    data["id"]=Math.random();
    earnPay.push(data);
    displayEarnPay("#editFarmer");
    setTimeout(function(){ $('#editYearEarnPay').modal('toggle'); }, 300);

    $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay,"#editFarmer");
    });
 }

})(jQuery);


