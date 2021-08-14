var argi_JsonArray =[];
var  argi_group_sel;
var  argi_type_sel;
var earnPay=[];
var spinner;
(function ($) {



argi_type_sel = new SlimSelect({
      select: '#editFarmer #argi_group_type'
      });
       argi_group_sel = new SlimSelect({
        select: '#editFarmer #argi_group'
        });


        var argi_group={};
        $('#editFarmer #argi_group_type').change(function(){
             var argi_group_type ;
             var beforeData =[];
             if($(this).val()!=null && $(this).val().length>1){
               argi_group_type =   $(this).val().toString().split(',').map(Number);
             }else if($(this).val()==null){
               argi_group_sel.destroy();
               argi_group_sel =    new SlimSelect({
                 select: '#editFarmer #argi_group',
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
                     select: '#editFarmer #argi_group',
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






var person_id = $("#editFarmer input[name='argnumber']").val();
$('#qrcode').qrcode(window.location.origin+"/view/editPersonView.php?person_id="+person_id);


$.ajax({
  url: "../handler/personHandler.php?person_id="+person_id,
  type: "POST",
  dataType: "html",
  async: false,
  data:{'person_id':person_id,'action':'load'},
  success:function(data){
    var personEdit =JSON.parse(data);
    mapDataPerson(personEdit,'#editFarmer ');
  }});

  function mapDataPerson(data ,mode){

    var d = new Date();
    var pathImg="../img/Activity/";
  $(mode+'[name="argpre"] option:selected').val();
  $(mode+'[name="argnumber"]').val(data.idPerson);
  $(mode+'input[name="argname"]').val(data.firstName);
  $(mode+'input[name="argsurname"]').val(data.lastName);

  if(data.picName ==null || data.picName ==""){
    $(mode+' .basic-img').attr('src',"../images/noPic.jpg?ver=" + d.getTime());
  }else{
    $(mode+' .basic-img').attr('src',  pathImg+data.picName+"?ver=" + d.getTime());
  }

  $(mode+'#statusPerson option[value="'+data.statusPerson+'"]').attr("selected",true);
  $(mode+' #path').val(data.picName);

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

  //earnPay=yearEarnPay;
  displayEarnPay(mode);

  $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay);
    });

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
        argi_type_sel.set(agri_type);

    var argi_group_JsonArray =[];
    argi_group_sel.destroy();
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
                argi_group_sel.setData(argi_group_JsonArray);
          },complete:function(){

            for(var i=0;i<regisAgri.length;i++){
              var agri_sel =regisAgri[i].idAgri;
              argi_group_sel.set(agri_sel);

            }
          }
      });
    }

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
          $('#area_Id').val(data.Area_idArea);
          var area_Id = data.Area_idArea;
          $.ajax({
              url:"../util/loadYearsOfPlanArea.php",
              method:"POST",
              data:{area_Id:area_Id},
              dataType:"text",
              success:function(data){
                  $('#yearsOfPlan').html(data);
              },complete:function(){
                initTable();
              }
          });
         }
     });

     $('#editFarmer #idRiverBasin').change(function(){
        var idRiverBasin = $(this).val();
         $.ajax({
             url:"../util/AreaDependent.php",
             method:"POST",
             data:{idRiverBasin:idRiverBasin},
             dataType:"text",
             success:function(data){
                 $('#editFarmer  #area').html(data);
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

    var Area_idArea = data.Area_idArea;
    $.ajax({
       url:"../util/loadGroupVillage.php",
       method:"GET",
       data:{"idRiverBasin":idRiverBasin,"idArea":Area_idArea},
       dataType:"text",
       success:function(data){
           $(mode+'#idGroupVillage').html(data);
       },complete:function(){
          $(mode+'#idGroupVillage option[value="'+data.idGroupVillage+'"]').attr("selected",true);
       }
   });


$('#editFarmer [name="idArea"]').change(function(){
   var Area_idArea = $(mode+'[name="idArea"] option:selected').val();
        $('#editFarmer #idGroupVillage').html("");
        $.ajax({
           url:"../util/loadGroupVillage.php",
           method:"GET",
           data:{"idRiverBasin":idRiverBasin,"idArea":Area_idArea},
           dataType:"text",
           success:function(data){
               $(mode+'#idGroupVillage').html(data);
           }
       });
    });





  $(mode+'input[name="argid"]').val(data.idcard);
  $(mode+'[name="religion"] option[value="'+data.religionName+'"]').attr("selected",true);



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



 var d =  new Date(data.birthday.date);
 var year = d.getFullYear();
 var month = d.getMonth();
 var day = d.getDate();
 var c = new Date(year, month, day);
   $(mode+'.argbirthTmp').datepicker({
     format: "dd MM yyyy",
     language:  'th',
     changeMonth: false,
     changeYear: false,
     thaiyear: true,
     stepMonths: 0
 }).datepicker("setDate", c);




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


  $('#updatePersonBtn').on('click',function(){
    var argpre =$('#editFarmer [name="argpre"] option:selected').val();
    var fname =$('#editFarmer input[name="argname"]').val();
    var lname =$('#editFarmer input[name="argsurname"]').val();
    var area =$('#editFarmer [name="idArea"] option:selected').val();
    var argid = $('#editFarmer input[name="argid"]').val();

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
    var img =$('#editFarmer .basic-img').attr('src');
    var coop =$('#editFarmer #coop').is(':checked')?'Y':'N';
    var agriList =argi_group_sel.selected();
    var idGroupVillage =$('#editFarmer #idGroupVillage option:selected').val();
    var fileupload =$('#editFarmer #file').prop('files')[0];
    var statusPerson =$('#editFarmer #statusPerson option:selected').val();
/*
    var fileupload =  resizeImage({
        file: $('#editFarmer #file').prop('files')[0],
        maxSize: 600
    }).then(function (resizedImage) {
        console.log("upload resized image")
    }).catch(function (err) {
        console.error(err);
    });*/
    if(argbirth!=""){
        argbirth =  dateDBFM(argbirth);
    }

    var formData= new FormData();
    formData.append('fileToUpload',fileupload);
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
    formData.append('action','update');
    formData.append('plots',plots);
    formData.append('argdist',argdist);
    formData.append('idPerson',idPerson);
    formData.append('argmoo_no',argmoo_no);
    formData.append('path',path);
    formData.append('statusPerson',statusPerson);

    if(img!="" && img !="../images/noPic.jpg"){
        formData.append('image',img);
      }
    formData.append('coop',coop);
    formData.append('agriList',agriList);
    formData.append('idGroupVillage',idGroupVillage);
    formData.append('earnPay',JSON.stringify(earnPay));

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
        alert("แก้ไขข้อมูลเกษตรกร :"+fname+" "+lname+"  แล้ว");

      }
      });
});

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
function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
$('#yearsOfPlan').change(function(){
    initTable();
});

$('#summaryMonth_id').change(function(){
    initTable();
});

function initTable() {
  $("#dashTable tbody").html("");
  var years_Id = $('#yearsOfPlan option:selected').val();
  var area_Id = $('#area_Id').val();
  var summaryMonth_id = $('#summaryMonth_id').val();
  console.log(summaryMonth_id);
  $.ajax({
      url:"../util/summaryProductOfPerson.php",
      method:"POST",
      data:{person_id: person_id,area_Id:area_Id, years_Id:years_Id, summaryMonth_id:summaryMonth_id},
      dataType:"text",
      success:function(data){
          $("#dashTable tbody").html(data);
      }
  });
}

 $('#addYearEarnPay').on('show.bs.modal', function (e) {
    $("#addYearEarnPay input").val('');
    $('#addYearEarnPay #addEarnPayBtn').on('click',function(){
        addYearEarnPayToTmp();
    });
 });
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
    displayEarnPay("#editFarmer ");
    $('#addYearEarnPay').modal('toggle');
    $('#earnpay #deleteEarnPaybtn').on('click',function(e){
        var id =$(this).data('id');
        var idYearEarnPay =$(this).data('idyearearnpay-id');
        deleteEarnPay(id,idYearEarnPay);
    });
 }


 function displayEarnPay(mode){
    $(mode+' #earnpay tbody').html("");
    var htmlYearEarnPay ="";
    for(var i=0;i<earnPay.length;i++){
      htmlYearEarnPay +="<tr>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+(i+1)+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].yearGetPay+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].earnPerYear+"</td>";
          htmlYearEarnPay +="<td style='text-align: center;'>"+earnPay[i].payPerYear+"</td>";
          htmlYearEarnPay +="<td class='row' style='text-align: center;'><i class='fa fa-times col-sm-6' style='cursor: pointer;color: red;text-align: left;padding: 5px;' id='deleteEarnPaybtn' data-id="+earnPay[i].id+" data-idYearEarnPay-id="+earnPay[i].idYearEarnPay+"></i></td>";

      htmlYearEarnPay +="/<tr>";
    }
    $(mode+' #earnpay tbody').html(htmlYearEarnPay);

 }

 function deleteEarnPay(id,idYearEarnPay){

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
           displayEarnPay("#editFarmer ");
        }
    });

 }


})(jQuery);

