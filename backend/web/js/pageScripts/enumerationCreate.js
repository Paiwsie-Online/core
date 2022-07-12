// PARENT SEARCH
$('#parent').keyup(function () {
    if ($('#parent').off('keypress')) {
        var value = $('#parent').val();
        if (value !== '' && value !== ' ') {
            $.post('/enumeration/search-parents', { value: value },
                function (data) {
                    $('#searchParentList').html('');
                    var array = JSON.parse(data);
                    $.each(array, function (i, l) {
                        $('#searchParentList').append('<li class="list-group-item list-group-item-action pt-1 pb-1 parent_type" value="' + i + '">' + l + '</li>');
                    });
                    $('.parent_type').click(function () {
                        var value, parent;
                        value = $(this).val();
                        parent = $(this).html();
                        $('#parent').val(parent);
                        $('#parentId').val(value);
                        $('#searchParentList').html('');
                    });
                }
            );
        } else {
            $('#searchParentList').html('');
            $('#parentId').val('');
        }
    }
});