insertSettingButton();

function insertSettingButton() {
    var url = $('#url').val();
    $('.columns').append('<a class="btn buttonTransparent site-modal-link textColor" href="/' + url + '/index-settings/" data-modalTitle="' + lajax.t('Show / Hide Columns') + '"><i class="fa fa-cog"></i></a>');
}