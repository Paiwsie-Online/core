/**Triggers**/
if ("startguide" in getVariables) {
    var startguide = getVariables["startguide"];
    if (typeof window[startguide] === 'function') {
        window[startguide]();
    }
}

/******************************************************/
/************************GUIDES************************/
/******************************************************/

/*----------------New user setup guide----------------*/
function getstartednewuser() {
    introJs().setOptions({
        steps: [
            {
                title: lajax.t('Welcome'),
                intro: lajax.t('In this guide we will guide you through step by step on how to get started using the platform')
            },
            {
                element: document.querySelector('.sidenav-addOrganization'),
                intro: lajax.t('You will find the button to create a new organization right here when you do not have any connection to a organization')
            },
            {
                element: document.querySelector('.user-menu'),
                intro: lajax.t('When you have an active organization, either as an employee or the owner of the organization, you can set up more organizations in your user menu')
            },
            {
                title: lajax.t('Lets set up your first organization!'),
                intro: lajax.t('We are done with this page for now, and when clicking done we will take you to the organization setup page')
            }
        ]
    }).start().oncomplete(function() {
        window.location.href = '/organization/register-organization?startguide=getstartednewusercreateorganization';
    });
}

function getstartednewusercreateorganization() {
    introJs().setOptions({
        steps: [
            {
                title: lajax.t('Setting up your organization'),
                intro: lajax.t('The first process in setting up your organization is to complete the form on this page')
            },
            {
                element: document.querySelector('#organization-name'),
                intro: lajax.t('Fill in your organization name. this is the legal name of the business, you can later set a display name in the organization profile if the legal name differes from the name your customers know')
            },
            {
                element: document.querySelector('#organization-tax_number'),
                intro: lajax.t('Fill in your organizations tax number. The tax number is needed in order to set up your business and will be visible on payment requests and other places where it is a legal requirement')
            },
            {
                title: lajax.t('Lets set up your organization!'),
                element: document.querySelector('.register-organization-button'),
                intro: lajax.t('All done, just click the button!')
            }
        ]
    }).start();
}

// Check if exist guide function, if not show an alert message
function show_guide(fromView) {
    var functionName = fromView + 'guide';
    if (typeof window[functionName] === 'function') {
        window[functionName]();
    } else {
        noGuideHints('guide');
    }

}

// Check if exist hints function, if not show an alert message
function show_hints(fromView) {
    var functionName = fromView + 'hints';
    if (typeof window[functionName] === 'function') {
        window[functionName]();
    } else {
        noGuideHints('hints');
    }
}

// Alert message in case of no function declared for guide/hints
function noGuideHints(from) {
    var msgTitle = '';
    var msgIntro = '';
    if (from === 'guide') {
        msgTitle = lajax.t('No guide');
        msgIntro = lajax.t('This guide does not exist');
    } else if (from === 'hints') {
        msgTitle = lajax.t('No hints');
        msgIntro = lajax.t('These hints does not exists');
    } else {
        msgTitle = lajax.t('Error');
        msgIntro = lajax.t('Something went wrong');
    }
    introJs().setOptions({
        disableInteraction: true,
        steps: [
            {
                title: msgTitle,
                intro: msgIntro
            }
        ]
    }).start();
}
