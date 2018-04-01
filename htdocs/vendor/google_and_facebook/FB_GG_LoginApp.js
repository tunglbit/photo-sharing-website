// Google Login
function onloadFunction() {
    gapi.client.setApiKey('AIzaSyD-xzIJq-EEyM4ByV9NX7SxJed4TBepe8A');
    gapi.client.load('plus' , 'v1', function () {});
}

// Facebook Login

window.fbAsyncInit = function() {
    FB.init({
        appId            : '153930248574602',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v2.11',
        status           : true
    });

    FB.getLoginStatus(function (response) {
        if(response.status == 'connected') {
            // connedted
        } else if(response.status == 'not_authorized') {
            // not auth
        } else {
            // not logged in to Facebook
        }
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));