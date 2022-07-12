// EDIT ORGANIZATION STYLE NAME
$('.editOrganizationStyle').click(function () {
    var html, value;
    html = $(this).parent('td').prev().html();
    value = $(this).val();
    $(this).parent('td').prev().html('<input id="name' + value + '" class="form-control" value="' + html + '">');
    $(this).hide(0);
    $(this).next('a').hide(0);
    $('#name' + value).focus();
    $('#name' + value).focusout(function() {
        var name = $('#name' + value).val();
        if (name !== '' && name !== ' ') {
            $.post('/enumeration/update-value',
                {
                    enumId: value,
                    name: name
                }, function () {
                    location.reload();
                }
            );
        }
    });
    $('#name' + value).keypress(function(event) {
        var name = $('#name' + value).val();
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode === 13) {
            if (name !== '' && name !== ' ') {
                $.post('/enumeration/update-value',
                    {
                        enumId: value,
                        name: name
                    }, function () {
                        location.reload();
                    }
                );
            }
        }
    });
});