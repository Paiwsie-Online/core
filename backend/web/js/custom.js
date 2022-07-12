(function () {
    window.layoutHelpers.setAutoUpdate(true);
})();

// Collapse menu
(function () {
    if ($('#layout-sidenav').hasClass('sidenav-horizontal') || window.layoutHelpers.isSmallScreen()) {
        return;
    }

    try {
        window.layoutHelpers.setCollapsed(
            localStorage.getItem('layoutCollapsed') === 'true',
            false
        );
    } catch (e) {
    }
})();

$(function () {
    // Initialize sidenav
    $('#layout-sidenav').each(function () {
        new SideNav(this, {
            orientation: $(this).hasClass('sidenav-horizontal') ? 'horizontal' : 'vertical'
        });
    });

    // Initialize sidenav togglers
    $('body').on('click', '.layout-sidenav-toggle', function (e) {
        e.preventDefault();
        window.layoutHelpers.toggleCollapsed();
        if (!window.layoutHelpers.isSmallScreen()) {
            try {
                localStorage.setItem('layoutCollapsed', String(window.layoutHelpers.isCollapsed()));
            } catch (e) {
            }
        }
    });

    if ($('html').attr('dir') === 'rtl') {
        $('#layout-navbar .dropdown-menu').toggleClass('dropdown-menu-right');
    }
});

// QR scan received from TAGid
function qrScanReceived() {
    $.post("/api/tagidscan", {}, function () {
    });
}

$(".alert-primary").delay(3000).fadeOut("slow");
$(".alert-secondary").delay(3000).fadeOut("slow");
$(".alert-success").delay(3000).fadeOut("slow");
$(".alert-danger").delay(8000).fadeOut("slow");
$(".alert-warning").delay(8000).fadeOut("slow");
$(".alert-info").delay(5000).fadeOut("slow");
$(".alert-light").delay(3000).fadeOut("slow");
$(".alert-dark").delay(3000).fadeOut("slow");

//Switch two contents
function blockSwitch(blockShow, blockHide) {
    $(blockHide).hide(100);
    $(blockShow).show(250);
}

$('#testModeSwitch').change(function () {
    var checked = false;
    if ($(this).is(':checked')) {
        checked = true;
    }
    $.post('/user/set-testmode', {'value': checked}, function (data) {
        //location.reload();
    });
});

var getVariables = [];
location.search.replace('?', '').split('&').forEach(function (val) {
    split = val.split("=", 2);
    getVariables[split[0]] = split[1];
});

$(function () {
    $('.site-modal-link').click(function (e) {
        e.preventDefault();
        $('#site-modal')
            .modal('show')
            .find('#site-modal-body')
            .html('Loading...')
            .closest('#site-modal')
            .find('#site-modal-label')
            .html('loading title...');
        $('#site-modal')
            .modal('show')
            .find('#site-modal-body')
            .load($(this).attr('href'))
            .closest('#site-modal')
            .find('#site-modal-label')
            .html($(this).attr('data-modalTitle'));
    });
});


$(function () {
    $('.site-modal-warning-link').click(function (e) {
        e.preventDefault();
        $('#site-modal-warning')
            .modal('show')
            .find('#site-modal-warning-body')
            .html('Loading...')
            .closest('#site-modal-warning')
            .find('#site-modal-label')
            .html('loading title...');
        $('#site-modal-warning')
            .modal('show')
            .find('#site-modal-warning-body')
            .load($(this).attr('href'))
            .closest('#site-modal-warning')
            .find('#site-modal-label')
            .html($(this).attr('data-modalTitle'));
    });
});
