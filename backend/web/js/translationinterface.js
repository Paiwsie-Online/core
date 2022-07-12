$('.trans-input').keyup(function(){
    var jsonString = "";
    $('.trans-input').each(function(){
        if ($(this).val() !== '') {
            jsonString += '"'+$(this).attr('data-language')+'":"'+$(this).val()+'",';
        }
    });
    $('#externalapptranslation-values').val('{'+jsonString.slice(0,-1)+'}');
});