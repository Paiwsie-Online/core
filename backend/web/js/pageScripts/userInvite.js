/*jshint esversion: 6 */
$('.field-invite-input-Mobile').hide(0);
$('#organizationuserrelationinvitation-sent_to').change(function () {
    var value = $('#organizationuserrelationinvitation-sent_to').val();
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

/*
selectType = 'email';
$('#organizationuserrelation-user_level').change(()=>{

    var type = $('#organizationuserrelation-user_level').val();
    switch(type){
        case 'sms':
            $('.field-organizationuserrelationinvitation-input-Email').hide();
            $('.field-phone_invite').show();
            selectType = 'sms';
            break;
        case 'email':
            $('.field-phone_invite').hide();
            $('.field-organizationuserrelationinvitation-input-Email').show();
            selectType = 'email';
            break;
    }
});*/
