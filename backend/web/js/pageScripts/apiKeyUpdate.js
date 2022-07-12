$('#allow_ip_input').tagsinput({ tagClass: 'badge badge-success' });

// IP verification
$('#allow_ip').find('input').on('keypress',function(e) {
    // 13 is ASCII code when key Enter is pressed, 44 is for ','
    if (e.which == 13 || e.which == 44) {
        this.value = this.value.match(/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/);
    }
});

$('#allow_ip').find('input').on('focusout',function() {
    var value, valueAndRemoveSpan;
    value = '';
    $('#allow_ip').find('span.tag').each(function () {
        value = $(this).find(':last').parent().text();
    });
    if (value.match(/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/)) {
        valueAndRemoveSpan = value + '<span data-role="remove"></span>';
        $('#allow_ip').find('span').last().parent().html(valueAndRemoveSpan);
    } else {
        $('#allow_ip').find('span').last().parent().remove();
    }
});

showExpiryDate();
showAllowIPs();

//SHOW EXPIRY DATE
function showExpiryDate() {
    if ($('.expiryDateCheckbox').is(':checked')) {
        $('#expiry_date').show(250);
    } else {
        $('#expiry_date').hide(250);
        $('#apikey-expiry_date').val('');
    }
}

//SHOW ALLOW IPS
function showAllowIPs() {
    if ($('.allowIPsCheckbox').is(':checked')) {
        $('#allow_ip').show(250);
    } else {
        $('#allow_ip').hide(250);
        $('#allow_ip_input').val('');
    }
}


//COMPILE ALLOW IPS AND NAME
$('#allow_ip_input').keyup(function(){
    compileAllowIP();
});

$('#allow_ip_input').change(function(){
    compileAllowIP();
});

$('#apiName').keyup(function(){
    compileAllowIP();
});

$('#apiName').change(function(){
    compileAllowIP();
});

function compileAllowIP() {
    var IpGet, Ip, name;
    IpGet = $('#apikey-key_config').val();
    name = $('#apiName').val();
    if(IpGet !== '') {
        Ip = JSON.parse(IpGet);
    } else {
        Ip = {};
    }
    Ip['allow_ip'] = [];
    if (name !== '' && name !== ' ') {
        Ip['name'] = name;
        $('#apikey-key_config').html(JSON.stringify(Ip));
    }
    if ($('#allow_ip_input').val() !== '') {
        Ip['allow_ip'] = $('#allow_ip_input').val().split(',');
        $('#apikey-key_config').html(JSON.stringify(Ip));
    }
}