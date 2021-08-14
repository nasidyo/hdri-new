(function ($) {

    $("#year_bugget").on('change',function(){
        var year = $(this).val();
        var dataDisplay = [];
        $.ajax({
            url:"../util/dashboard/loadPlantBubble.php?year="+year,
            method:"GET",
            dataType:"text",
            success:function(data){
                var result= JSON.parse(data);
                var keys = [];
                for(var k in result ) keys.push(result[k].nameMarket);
                var unique = keys.filter(onlyUnique);

                for(var i =0;i<unique.length;i++){
                    var dataItem =   result.filter(function(e){  return e.nameMarket === unique[i] });
                    var agriName =[];
                    var TotalValueArr =[];
                    var size=[];
                    var textarr=[];
                    for(var j in dataItem){
                        var text="";
                        agriName.push(dataItem[j].nameArgi);
                        TotalValueArr.push(dataItem[j].TotalValue);
                        size.push(100);
                        text="ช่องทาง:"+unique[i]+"<br>ชนิด:"+dataItem[j].nameArgi+"<br>มูลค่า :"+toMoney(parseFloat(dataItem[j].TotalValue))+' บาท';
                        textarr.push(text);
                    }



                 var size = size;
                 var trace4 = {
                   x: agriName,
                   y: TotalValueArr,
                   text: textarr,
                   mode: 'markers',
                   name: unique[i],
                   marker: {
                     size: size,
                     sizemode: 'area'
                   }
                 };

                  dataDisplay.push(trace4);
                }

            },complete:function(){
                var layout = {
                    title: 'ชนิต'
                  };
                  Plotly.newPlot('Bubble', dataDisplay, layout);

            }
        });
    });



    $("#year_bugget").trigger('change');








})(jQuery);

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
