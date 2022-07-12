checkImage();

$('#contact_email').tagsinput({ tagClass: 'badge badge-warning' });

//IMAGE
$('.logoPreviewUpload').hide(0);
organization_logo.onchange = evt => {
    const [file] = organization_logo.files;
    if (file) {
        $('.logoPreviewDataBase').hide(0);
        $('.logoPreviewUpload').show(250);
        $('#deleteImageUploadedBtn').show(250);
        logo_preview_upload.src = URL.createObjectURL(file);
        checkImage();
    }
}

$('#deleteImageUploadedBtn').click(function() {
    $('.logoPreviewUpload').hide(250);
    $('#organization_logo').val('');
    $('#deleteImageUploadedBtn').hide(50);
    $('.logoPreviewDataBase').show(250);
    var imageDatabase = $('#logo_preview_database').prop('src');
    if (typeof imageDatabase === 'undefined') {
        $('#deleteLogo').hide(0);
        $('.imageSelected').html(lajax.t('No selected image'));
    } else {
        $('#deleteLogo').show(250);
        $('.imageSelected').html(lajax.t('Already has a organization logo'));
    }
});

//CLICK OTHER BUTTON
$('#buttonFile').click(function () {
    $('.form-control-file').click();
});





//CHECK IMAGE
function checkImage() {
    var imagePreview, imageDatabase;
    imagePreview = $('#logo_preview_upload').prop('src');
    imageDatabase = $('#logo_preview_database').prop('src');
    if (imagePreview && imagePreview !== 'false') {
        $('.imageSelected').html(lajax.t('A selected image'));
        $('#deleteLogo').hide(0);
    } else {
        if (imageDatabase) {
            $('.imageSelected').html(lajax.t('Already has a organization logo'));
            $('#deleteLogo').show(250);
        } else {
            $('.imageSelected').html(lajax.t('No selected image'));
            $('#deleteLogo').hide(0);
        }
    }
}