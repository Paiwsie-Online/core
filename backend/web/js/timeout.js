// AUTOMATIC LOGOUT
$('#site-modal-warning').attr('data-backdrop', 'static').attr('data-keyboard', 'false');

var logoutTimer = $('meta[name=logoutTimer]').attr('content');
var intervalTime = 1000;  //1 second

const getCookies = (name) => {
    return document.cookie.split('; ').reduce((r, v) => {
        const parts = v.split('=');
        return parts[0] === name ? decodeURIComponent(parts[1]) : r;
    }, '');
};

function disableF5Pressed(e) {
    if ((e.which || e.keyCode) == 116) e.preventDefault();
};

const logoutCountdown = setInterval(function() {
    var cookie = getCookies('userSession');
    var logoutButton = document.getElementById('logoutButton');
    var dateExpire = new Date();
    $.ajax({
        type: 'POST',
        url: '/user-login/check-user-session-cookie',
    });
    if (cookie) {
        var timeOut = $('#timeOutValue').val();
        var modalShow = $('#modalShowValue').val();
        $('input, select, textarea, a, button').on('change keyup keypress click', function () {
            $('meta[name=logoutTimer]').attr('content', timeOut);
            logoutTimer = $('meta[name=logoutTimer]').attr('content');
        });
        //Show modal when rest 'x' time
        if (logoutTimer === (timeOut - modalShow)) {
            $('#site-modal').modal('hide');
            setTimeout(function() {
                $('#site-modal-warning').modal('show');
            }, 1000);
        }
        //LogoutTimer is 0 auto logout
        if (logoutTimer === 0) {
            logoutButton.click();
            // Delete Cookie
            dateExpire.setSeconds(dateExpire.getSeconds() - 10);
            document.cookie = 'userSession=; expires=' + dateExpire;
            clearInterval(logoutCountdown);
        }
    }
    logoutTimer--;
}, intervalTime);




