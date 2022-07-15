$('#organizationuserrelationinvitation-sent_via option[value="email"]').prop('selected', true);

//$('.field-quickpayment-input-Email').hide(0);
$('.field-invite-input-Mobile').hide(0);

$('#organizationuserrelationinvitation-sent_via').change(function () {
    var value = $('#organizationuserrelationinvitation-sent_via').val();
    if (value === 'email') {
        $('#invite-input-Mobile').prop('disabled', true);
        $('#invite-input-Email').prop('disabled', false);
        $('.field-invite-input-Mobile').hide(50);
        $('.field-invite-input-Email').show(250);
    } else if (value === 'sms') {
        $('#invite-input-Email').prop('disabled', true);
        $('#invite-input-Mobile').prop('disabled', false);
        $('.field-invite-input-Email').hide(50);
        $('.field-invite-input-Mobile').show(250);
    }
});
