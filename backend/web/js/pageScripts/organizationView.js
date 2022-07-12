function saveSetting() {
    var frontendInstance, organizationId;
    frontendInstance = $('#frontendInstance').val();
    organizationId = $('#organizationId').val();
    $.post('/organization-setting/save-setting', {
        setting : 'frontendInstance',
        value : frontendInstance,
        organizationId : organizationId
    });
}

function saveURLSetting() {
    var frontendUrl, organizationId;
    frontendUrl = $('#frontendUrl').val();
    organizationId = $('#organizationId').val();
    $.post('/organization-setting/save-setting', {
        setting : 'frontendUrl',
        value : frontendUrl,
        organizationId : organizationId
    });
}