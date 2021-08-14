

function validatePersonUser(formData,index){
    var error =0;
    jQuery(index+' [name="idRiverBasin"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' [name="idArea"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' input[name="argname"]').closest('.form-group').removeClass('has-error');
   /* jQuery(index+' [name="argprovince"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' [name="argdist"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' [name="argsub"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' [name="occupFirst"]').closest('.form-group').removeClass('has-error');
    jQuery(index+' [name="occupSecond"]').closest('.form-group').removeClass('has-error');
    jQuery(index+'[name="earnPerYear"]').closest('.form-group').removeClass('has-error');
    jQuery(index+'[name="payPerYear"]').closest('.form-group').removeClass('has-error');*/


    if(formData.get('idRiverBasin')==0){
        jQuery(index+' [name="idRiverBasin"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('area')=="undefined"){
        jQuery(index+' [name="idArea"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('fname')=="" || formData.get('lname')==""){
        jQuery(index+' input[name="argname"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
   /* if(formData.get('argprovince')==0){
        jQuery(index+' [name="argprovince"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('argdist')=="undefined"){
        jQuery(index+' [name="argdist"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('argsub')=="undefined"){
        error+=1;
        jQuery(index+' [name="argsub"]').closest('.form-group').addClass('has-error');
    }
    if(formData.get('occupFirst')==0){
        jQuery(index+' [name="occupFirst"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('occupSecond')==0){
        jQuery(index+' [name="occupSecond"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('earnPerYear')==""){

        jQuery(index+' input[name="earnPerYear"]').closest('.form-group').addClass('has-error');
        error+=1;
    }
    if(formData.get('payPerYear')==""){
        jQuery(index+' input[name="payPerYear"]').closest('.form-group').addClass('has-error');

        error+=1;
    }*/

    return   error;



}



