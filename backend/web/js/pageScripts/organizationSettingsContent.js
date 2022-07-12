$('#global').prop('style', 'color: #ffc107 !important');

//List and Divs Hide / Show
$('#global').click(function () {
    $('#global').prop('style', 'color: #ffc107 !important');
    $('#inviteUser').prop('style', false);
    $('#inviteUserDiv').hide(250);
    $('#globalDiv').show(250);
});

$('#inviteUser').click(function () {
    $('#global').prop('style', false);
    $('#inviteUser').prop('style', 'color: #ffc107 !important');
    $('#globalDiv').hide(250);
    $('#inviteUserDiv').show(250);
});
