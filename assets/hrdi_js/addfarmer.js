var argi_JsonArray =[];
var  argi_group_sel;
var earnPay=[];

(function ($) {

/*
    $("#addFarmerForm input[name='argbirth']").datepicker({
        format: "dd-mm-yyyy",
        language: "th",
        orientation: "auto left",
        autoclose: true
      });*/


      var d = new Date();
      var year = d.getFullYear();
      var month = d.getMonth();
      var day = d.getDate();
      var c = new Date(year , month, day);


      $('#addFarmerForm .argbirthTmp').datepicker({
          format: "dd MM yyyy",
          language:  'th',
          changeMonth: false,
          changeYear: false,
          thaiyear: true,
          stepMonths: 0
      }).datepicker("setDate",d);


     new SlimSelect({
      select: '#addFarmerForm #argi_group_type'
      });
       argi_group_sel = new SlimSelect({
        select: '#addFarmerForm #argi_group'
        });





        $('#earnpay #deleteEarnPaybtn').on('click',function(e){
            var id =$(this).data('id');
            var idYearEarnPay =$(this).data('idyearearnpay-id');
            deleteEarnPay(id,idYearEarnPay);
        });


        $('#addYearEarnPay').on('show.bs.modal', function (e) {
            $("#addYearEarnPay input").val('');

        });
        $('#addYearEarnPay #addEarnPayBtn').on('click',function(){
            addYearEarnPayToTmp();
        });


      $('#addPersonBtn').on('click',function(){
          var argpre =$('#addFarmerForm [name="argpre"] option:selected').val();
          var fname =$('#addFarmerForm input[name="argname"]').val();
          var lname =$('#addFarmerForm input[name="argsurname"]').val();
          var area =$('#addFarmerForm [name="idArea"] option:selected').val();
          var argid = $('#addFarmerForm input[name="argid"]').val();

          var argbirth =$('#addFarmerForm #argbirth').val();
          var argprovince=$('#addFarmerForm [name="argprovince"] option:selected').val();
          var argdist=$('#addFarmerForm [name="argdist"] option:selected').val();
          var argsub=$('#addFarmerForm [name="argsub"] option:selected').val();
          var argno=$('#addFarmerForm input[name="argno"]').val();
          var road=$('#addFarmerForm input[name="road"]').val();
          var argmoo_no=$('#addFarmerForm input[name="argmoo_no"]').val();
          var argmoo_name=$('#addFarmerForm [name="argmoo_name"] option:selected').text();
          var argsub_moo=$('#addFarmerForm input[name="argsub_moo"]').val();
          var argzip_code=$('#addFarmerForm input[name="argzip_code"]').val();
          var argTel=$('#addFarmerForm input[name="argTel"]').val();
          var occupFirst=$('#addFarmerForm [name="occupFirst"] option:selected').val();
          var occupSecond=$('#addFarmerForm [name="occupSecond"] option:selected').val();
          var earnPerYear=$('#addFarmerForm input[name="earnPerYear"]').val();
          var payPerYear =$('#addFarmerForm input[name="payPerYear"]').val();
          var plots=$('#addFarmerForm input[name="plots"]').val();
          var rai=$('#addFarmerForm input[name="rai"]').val();
          var ngan =$('#addFarmerForm input[name="ngan"]').val();
          var sqaurewa=$('#addFarmerForm input[name="sqaure_wa"]').val();
          var argEmail=$('#addFarmerForm input[name="argEmail"]').val();
          var idRiverBasin =$('#addFarmerForm [name="idRiverBasin"] option:selected').val();

          var file = $('#addFarmerForm #file').prop('files')[0];

          var img =$('#addFarmerForm .basic-img').attr('src');
          var agriList =argi_group_sel.selected();
          var idGroupVillage =   $('#addFarmerForm #idGroupVillage').val();
          var statusPerson =$('#addFarmerForm #statusPerson option:selected').val();


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
          formData.append('argbirth',argbirth);
          formData.append('argprovince',argprovince);
          formData.append('argsub',argsub);
          formData.append('argno',argno);
          formData.append('road',road);
          formData.append('argmoo_name',argmoo_name);
          formData.append('argsub_moo',argsub_moo);
          formData.append('argzip_code',argzip_code);
          formData.append('argTel',argTel);
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
          if(img!="" && img !="../images/noPic.jpg"){
            formData.append('image',img);
          }

          formData.append('agriList',agriList);
          formData.append('idGroupVillage',idGroupVillage);
          formData.append('statusPerson',statusPerson);

          formData.append('earnPay',JSON.stringify(earnPay));

       var error=   validatePersonUser(formData,'#addFarmerForm');
        if(error>0){
            return false;
        }

          $.ajax({
            url:"../util/checkPerson.php",
            method:"POST",
            data:{area_Id:area, firstName:fname, lastName:lname},
            dataType:"text",
            success:function(data){
                console.log(data);
                if(data == '1'){
                    alert("มีข้อมูลเกษตรกรอยู่ในระบบแล้ว !");
                    return false;
                }else{
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
                        },complete:function(){
                          alert("เพิ่มเกษตรกร :"+fname+" "+lname+"  แล้ว");
                          clearData();
                        }
                    });
                }
            }
          });
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
      var argbirth =$('#editFarmer input[name="argbirth"]').val();
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
      var earnPerYear=$('#editFarmer input[name="earnPerYear"]').val();
      var payPerYear =$('#editFarmer input[name="payPerYear"]').val();
      var plots=$('#editFarmer input[name="plots"]').val();
      var rai=$('#editFarmer input[name="rai"]').val();
      var ngan =$('#editFarmer input[name="ngan"]').val();
      var sqaurewa=$('#editFarmer input[name="sqaure_wa"]').val();
      var argEmail=$('#editFarmer input[name="argEmail"]').val();
      var idRiverBasin =$('#editFarmer [name="idRiverBasin"] option:selected').val();
      var idPerson=$('#editFarmer input[name="argnumber"]').val();
      var path=$('#editFarmer #path').val();

      var statusPerson =$('#editFarmer #statusPerson option:selected').val();
      var file = $('#editFarmer #file').prop('files')[0];
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
      formData.append('statusPerson',statusPerson);


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

  var argi_group={};
   $('#addFarmerForm #argi_group_type').change(function(){
        var argi_group_type ;
        var beforeData =[];
        if($(this).val()!=null && $(this).val().length>1){
          argi_group_type =   $(this).val().toString().split(',').map(Number);
        }else if($(this).val()==null){
          argi_group_sel.destroy();
          argi_group_sel =    new SlimSelect({
            select: '#addFarmerForm #argi_group',
           });
           argi_group_sel.set([]);
           argi_group_sel.setData([]);
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
              argi_group_sel.destroy();

             },complete:function(){
              argi_group_sel =    new SlimSelect({
                select: '#addFarmerForm #argi_group',
               });
               beforeData = argi_group_sel.selected() ;
               for(var i=0;i<argi_group.length;i++){
                var j ={};
                  j["value"] = argi_group[i].idAgri;
                  j["text"]=argi_group[i].nameArgi;
                 argi_group_JsonArray.push(j);

               }
                argi_group_sel.setData(argi_group_JsonArray);

                argi_group_sel.set(beforeData);

             }
         });
     });


     $('#addFarmerForm #idRiverBasin').change(function(){
        var idRiverBasin =jQuery("#addFarmerForm #idRiverBasin option:selected").val();
        var AreaAll = $("#AreaAll").val();
         $.ajax({
             url:"../util/AreaDependentWithRole.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin,idArea:AreaAll},
             dataType:"text",
             success:function(data){
                 $('#addFarmerForm #area').html(data);
             },complete:function(){
                $('#addFarmerForm [name="idArea"]').trigger('change');
             }
         });
     });

     //

   /*  $('#addFarmerForm #idRiverBasin').change(function(){
        var idRiverBasin =jQuery("#addFarmerForm #idRiverBasin option:selected").val();
        $('#addFarmerForm #idGroupVillage').html("");
        $.ajax({
            url:"../util/loadGroupVillage.php",
            method:"GET",
            data:{"idRiverBasin":idRiverBasin},
            dataType:"text",
            success:function(data){
                $('#addFarmerForm #idGroupVillage').html(data);
            }
        });

    });*/

    $('#addFarmerForm #idRiverBasin').trigger('change');
    $('#addFarmerForm [name="idArea"]').change(function(){
        var Area_idArea = $('#addFarmerForm [name="idArea"] option:selected').val();
        var idRiverBasin =jQuery("#addFarmerForm #idRiverBasin option:selected").val();
             $('#addFarmerForm #idGroupVillage').html("");
             $.ajax({
                url:"../util/loadGroupVillage.php",
                method:"GET",
                data:{"idRiverBasin":idRiverBasin,"idArea":Area_idArea},
                dataType:"text",
                success:function(data){
                    $('#addFarmerForm #idGroupVillage').html(data);
                },complete:function(){
                    $('#addFarmerForm #idGroupVillage').trigger('change');
                }
            });
         });

         $('#addFarmerForm #idGroupVillage').change(function(){
            var gv = "";
            if($(this).val() !=null && $(this).val()!= undefined){
                gv  = $(this).val();
            }
            if(gv.length>0 && gv.length == 9){
                var PROV_CODE = gv.substring(0,2);
                var AMP_CODE = gv.substring(2,4);
                var TAM_CODE = gv.substring(4,6);
                var VILL_CODE  = gv.substring(6,9);

                $("#addFarmerForm #argprovince option[value='"+PROV_CODE+"']").attr('selected','selected');
                $("#addFarmerForm #argprovince").trigger("change",[{"AMP_CODE":AMP_CODE,"TAM_CODE":TAM_CODE,"VILL_CODE":VILL_CODE}]);

            }
        });


     //



     $('#editFarmer #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependent.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin},
             dataType:"text",
             success:function(data){
                 $('#editFarmer #area').html(data);
             }
         });
     });


     $('#addFarmerForm #argprovince').change(function(e, data){
      var PROV_CODE = $(this).val();
       $.ajax({
           url:"../util/AmphurDependent.php",
           method:"POST",
           data:{PROV_CODE:PROV_CODE},
           dataType:"text",
           success:function(data){
               $('#addFarmerForm #argdist').html(data);
               $('#addFarmerForm #argsub').html('');
               $('#addFarmerForm #argmoo_name').html('');
               $('#addFarmerForm [name="argmoo_no"]').val('');
           },complete:function(){
            if(data!= undefined && data.AMP_CODE !=undefined && data.AMP_CODE != null && data.AMP_CODE !=""){
                $("#addFarmerForm #argdist option[value='"+data.AMP_CODE+"']").attr('selected','selected');
                $('#addFarmerForm #argdist').trigger("change",data);
                $('#addFarmerForm #argzip_code').val("");
                $.ajax({
                    url:"../util/loadZipCode.php",
                    method:"GET",
                    data:{"districtCode":PROV_CODE+data.AMP_CODE+data.AMP_CODE},
                    dataType:"text",
                    success:function(data){
                        $('#addFarmerForm input[name="argzip_code"]').val(data);
                    }

                });
            }



         }
       });
   });

   $('#addFarmerForm #argdist').change(function(e,data){
    var AMP_CODE = $(this).val();
    var PROV_CODE =  $('#addFarmerForm #argprovince option:selected').val();
     $.ajax({
         url:"../util/TamDependent.php",
         method:"POST",
         data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE},
         dataType:"text",
         success:function(data){
             $('#addFarmerForm #argsub').html(data);
             $('#addFarmerForm #argmoo_name').html('');
             $('#addFarmerForm [name="argmoo_no"]').val('');

         },complete:function(){
            if(data!= undefined && data.TAM_CODE !=undefined && data.TAM_CODE != null && data.TAM_CODE !=""){
                $("#addFarmerForm #argsub option[value='"+data.TAM_CODE+"']").attr('selected','selected');
                $('#addFarmerForm #argsub').trigger("change",data);
            }

         }
     });
  });

  $('#addFarmerForm #argsub').change(function(){
    $('#addFarmerForm #argmoo_name').html('');
    var TAM_CODE = $(this).val();
    var PROV_CODE =  $('#addFarmerForm #argprovince option:selected').val();
    var AMP_CODE =  $('#addFarmerForm #argdist option:selected').val();
     $.ajax({
         url:"../util/VillageDependent.php",
         method:"POST",
         data:{PROV_CODE:PROV_CODE , AMP_CODE:AMP_CODE ,TAM_CODE:TAM_CODE},
         dataType:"text",
         success:function(data){
             $('#addFarmerForm #argmoo_name').html(data);
         }
     });
  });
  $('#addFarmerForm #argmoo_name').change(function(){
    var argmoo_no = $(this).val();
    $('#addFarmerForm [name="argmoo_no"]').val(argmoo_no);

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









     $(document).on("click", "#editPerson", function () {
        var person_id = $(this).data('id');
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
    $(mode+'[name="argpre"] option:selected').val();
    $(mode+'[name="argnumber"]').val(data.idPerson);
    $(mode+'input[name="argname"]').val(data.firstName);
    $(mode+'input[name="argsurname"]').val(data.lastName);
    $(mode+' .basic-img').attr('src', '../img/Activity/'+data.picName+"?ver=" + d.getTime());
    $(mode+' #path').val(data.picName);

      var idRiverBasin = data.RiverBasin_idRiverBasin;
       $.ajax({
           url:"../util/AreaDependent.php",
           method:"POST",
           data:{idRiverBasin:idRiverBasin},
           dataType:"text",
           success:function(data){
               $('#editFarmer #area').html(data);
           },
           complete:function(){
            $(mode+'#idRiverBasin option[value="'+data.RiverBasin_idRiverBasin+'"]').attr("selected",true);
            $(mode+'[name="idArea"] option[value="'+data.Area_idArea+'"]').attr("selected",true);
           }
       });


    $(mode+'input[name="argid"]').val(data.idcard);
    $(mode+'[name="religion"] option[value="'+data.religionName+'"]').attr("selected",true);
    $(mode+'#statusPerson option[value="'+data.statusPerson+'"]').attr("selected",true);


       if(data.tribeName!=0 || data.tribeName!=null){
          $(mode+'[name="tribes"] option[value="'+data.tribeName+'"]').attr("selected",true);
        }else{
          $(mode+'[name="tribes"] option:eq(0)').attr("selected",true);
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

   var birthday = new Date(data.birthday.date.substring(0,10));
   var date = birthday.getDate();
   var month= birthday.getMonth()+1;
   var year= birthday.getFullYear();
   var dateStr =year+'-'+zeroPad(month,2)+'-'+zeroPad(date,2);

   $(mode+'input[name="argbirth"]').val(dateStr);


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

    }

  });

  function zeroPad(num, places) {
    var zero = places - num.toString().length + 1;
    return Array(+(zero > 0 && zero)).join("0") + num;
  }






  function clearData(){
    $(":input:not([type=hidden])").val('');
    $('.basic-img').attr('src','');
    $('#addFarmerForm #idRiverBasin').trigger('change') ;
    earnPay=[];
    displayEarnPay("#addFarmerForm ");


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

    $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay);
    });



 }

 function deleteEarnPay(id,idYearEarnPay){

  /*  if (!confirm("ต้องการลบข้อมูล")){
        return false;
      }*/
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
           displayEarnPay("#addFarmerForm ");
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
    displayEarnPay("#addFarmerForm ");
    $('#addYearEarnPay').modal('toggle');
    $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay);
    });
 }



  })(jQuery);


