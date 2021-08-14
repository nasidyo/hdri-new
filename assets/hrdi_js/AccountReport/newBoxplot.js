(function ($) {

var year = $("#year").val();
var dataDisplay = [];
loadboxplot(year);

function loadboxplot(year){
  var spinner = $('#loader');
  // spinner.show();
  var dataDisplay = [];
  $.ajax({
      url:"../util/dashboard/loadBoxplotNew.php?year="+year,
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
        // spinner.hide();
          var layout = {
              title: 'พื่นที่'
            };

            Plotly.newPlot('Plotly', dataDisplay, layout);

      }
  });
}

$('#search_reportIncome').on('click', function () {
    year = $('#year option:selected').val();
    loadboxplot(year);
});









})(jQuery);

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
