$('.pagination').hide(0);
checkOtherOption();

function toggleBody(module) {
    var visible;
    $('#' + module).toggle(250);
    setTimeout(function () {
        if ($('#' + module).is(':visible')) {
            $('.' + module).html('<i class="fas fa-chevron-down fs-5"></i>');
            visible = 1;
        } else {
            $('.' + module).html('<i class="fas fa-chevron-left fs-5"></i>');
            visible = 0;
        }
        saveUserSettingsInfo(module, visible);
    },260);
}

function saveUserSettingsInfo(module, visible) {
    $.post('/site/dashboard-block-visible', {
        block : module,
        visible : visible
    });
}

$('#time').change(function () {
    if ($('#time').val() === 'other') {
        $('#otherDatesDiv').show(250);
    } else {
        $('#otherDatesDiv').hide(250);
        $('#w1').val('');
        $('#w2').val('');
    }
});

function checkOtherOption() {
    if ($('#time').val() === 'other') {
        $('#otherDatesDiv').show(0);
    } else {
        $('#otherDatesDiv').hide(0);
    }
}