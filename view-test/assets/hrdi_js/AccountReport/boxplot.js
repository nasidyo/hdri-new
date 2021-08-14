(function ($) {

    $("#year_bugget").on('change',function(){
        var year = $(this).val();
        var dataDisplay = [];
        $.ajax({
            url:"../util/dashboard/loadBoxplot.php?year="+year,
            method:"GET",
            dataType:"text",
            success:function(data){
                var result= JSON.parse(data);
                var keys = [];
                for(var k in result ) keys.push(result[k].target_name);
                var unique = keys.filter(onlyUnique);
                for(var i =0;i<unique.length;i++){
                var dataItem =   result.filter(function(e){  return e.target_name === unique[i] });
                var TotalValueArr=[];
                var   agriName=[];
                var numberFomat=[];
                 for(var j in dataItem){
                     var text="<i>มูลค่า :</i>"+toMoney(dataItem[j].TotalValue==null?0:dataItem[j].TotalValue)+"<br><b>ชนิด</b>:"+dataItem[j].nameArgi+"<br>";
                    TotalValueArr.push(dataItem[j].TotalValue);
                    agriName.push(text);


                 }

                 var  trace4 = {
                    y: TotalValueArr,
                    type: 'box',
                    name: unique[i],
                    text: agriName,
                    numx:numberFomat,
                    hovertemplate: '%{text}',
                    jitter: 0.5,
                    pointpos: 0,
                    marker: {
                      color: 'rgb(107,174,214)',
                      size:5
                    },
                    boxpoints: 'all'
                  };


                  dataDisplay.push(trace4);
                }

            },complete:function(){
                var layout = {
                    title: 'พื่นที่'
                  };

                  Plotly.newPlot('Plotly', dataDisplay, layout);

            }
        });
    });



    $("#year_bugget").trigger('change');








})(jQuery);

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
