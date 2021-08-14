(function ($) {
    var spinner = $("#loader");
    var mymap = new L.map('mapid').setView([13.7245601,100.4930247], 5);
    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 25,
    }).addTo(mymap);
    $('#idRiverBasinSearch').select2();
    $('#idAreaSearch').select2();
    $('#idpersonSearch').select2();
    $('#idRiverBasinSearch').change(function(){
        var idRiverBasin = $(this).val();
        if($('#staffPermis').val() != 'admin'){
            var idArea = $('#AreaAll').val();
        }else{
             var idArea = '';
        }
        console.log(idArea);
        if(idRiverBasin != '0'){
            $.ajax({
                url:"../util/loadAreaDropdown.php",
                method:"POST",
                data:{idRiverBasin:idRiverBasin, idArea:idArea},
                dataType:"text",
                success:function(data){
                    $('#idAreaSearch').html(data);
                },complete: function(data){
                    var idArea = jQuery("#idAreaSearch option:selected").val();
                    loadPerson(idArea);
                }
            });
        }else{
            $('#idAreaSearch').html("<option value='0'>กรุณาเลือก</option>");
        }
    });
    $('#idAreaSearch').change(function(){
        var idArea = $(this).val();
        if(idArea != '0'){
            $.ajax({
                url:"../util/loadPersonFromArea.php",
                method:"POST",
                data:{idArea:idArea},
                dataType:"text",
                success:function(data){
                    console.log(data);
                    $("#idpersonSearch").html(data);
                }
            });
        }else{
            $("#idpersonSearch").html("<option value='0'>กรุณาเลือก</option>");
        }
    });

    function loadPerson(idArea){
        $.ajax({
            url:"../util/loadPersonFromArea.php",
            method:"POST",
            data:{idArea:idArea},
            dataType:"text",
            success:function(data2){
                console.log(data2);
                $("#idpersonSearch").html(data2);
            }
        });
    }
    $( "#clearBtn" ).click(function() {
        $('#idRiverBasinSearch').select2('val','0');
        $('#idAreaSearch option:selected').val('0').trigger('change');
        $('#idpersonSearch option:selected').val('0').trigger('change');
        mymap.setView([13.7245601,100.4930247], 5);
        $(".leaflet-marker-icon").remove();
        $(".leaflet-popup").remove();
    });

    $( "#searchBtn" ).click(function() {
        

        var idRiverBasinSearch = $('#idRiverBasinSearch option:selected').val();
        var idAreaSearch = $('#idAreaSearch option:selected').val();
        var idpersonSearch = $('#idpersonSearch option:selected').val();
        var staffPermis = $('#staffPermis').val();
        var areaAll = $('#AreaAll').val();
        if(idRiverBasinSearch == '0' || idAreaSearch == '0'){
            alert('กรุณาเลือกลุ่มน้ำ และ พื้นที่ให้ครบ');
            return false;
        }
        spinner.show();
        var formData= new FormData();
        formData.append('idRiverBasin',idRiverBasinSearch);
        formData.append('idArea',idAreaSearch);
        formData.append('person_id',idpersonSearch);
        formData.append('staffPermis',staffPermis);
        formData.append('areaAll',areaAll);
        mymap.invalidateSize();
        var icon = new L.Icon({
            iconUrl: '../images/marker/marker.png',
            iconSize: [30, 30],
        });
        var report = [];

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data:formData,
            dataType:'text',
            url:"../util/LandDetailMapping.php",
            success:function(data){
                console.log(data);
                report =JSON.parse(data);
                console.log (report);
            },complete:function(){
                if(report[0] == null){
                    spinner.hide();
                    alert('ไม่มีข้อมูลรายแปลง');
                    return false;
                }
                $(".leaflet-marker-icon").remove();
                $(".leaflet-popup").remove();
                if(idAreaSearch == '0'){
                    mymap.setView([13.7245601,100.4930247], 5);
                }else{
                    mymap.setView([report[0].latloung,report[0].loung], 8);
                }
                osmLayer = new L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 25,
                })
                mymap.addLayer(osmLayer);
                // mymap.clearLayers();
                for(var i=0;i<report.length;i++){
                    L.marker([report[i].latloung,report[i].loung],{
                        icon: icon,
                    }).addTo(mymap).bindPopup(report[i].displayName);
                    ;
                }
                spinner.hide();
            }
        });
    });
    // function getICon(){
    //     var icon = new L.Icon({
    //         iconUrl: '../images/marker/marker.png',
    //         iconSize: [12, 12],
    //         iconAnchor: [12, 41],
    //         popupAnchor: [1, -34],
    //     });
    // }


 //initialize the map on the "map" div with a given center and zoom
    // var mymap = L.map('mapid').setView([18.770903, 98.975128], 15);
    // L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
    //     maxZoom: 25,
    // }).addTo(mymap);
    // var marker = L.marker([18.770903, 98.975128]).addTo(mymap).bindPopup('ทดสอบการใช้งาน1 map <br> Easily customizable.');
    //             L.marker([18.7709118,98.9728901]).addTo(mymap).bindPopup('ทดสอบการใช้งาน2 map <br> Easily customizable.');

})(jQuery);