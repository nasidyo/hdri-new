
jQuery(document).ready(function($) {

    $('input[type="number"]').each(function(){
        $(this).attr('min','0');
        $(this).attr('onkeyup',"if(this.value<0){this.value= this.value * -1}");

        $(this).change(function() {
            $(this).val(parseFloat($(this).val()).toFixed(2));
        });

    });



});
