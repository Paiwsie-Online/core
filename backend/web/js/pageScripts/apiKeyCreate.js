$('.expiryDateCheckbox').prop('checked', false);
$('#expiry_date').hide(0);

//SHOW EXPIRY DATE
function showExpiryDate() {
    if ($('.expiryDateCheckbox').is(':checked')) {
        $('#expiry_date').show(250);
    } else {
        $('#expiry_date').hide(250);
        $('#apikey-expiry_date').val('');
    }
}