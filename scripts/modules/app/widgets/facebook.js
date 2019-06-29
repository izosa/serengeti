/**
 * Facebook API Init
 * @param {type} appid
 * @returns {undefined}
 */
App.prototype.widgetFacebookInit = function ()
{
    window.fbAsyncInit = function () {
        FB.init({
            appId: app.widgets.facebookInit.api,
            xfbml: true,
            version: 'v2.3'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "http://connect.facebook.net/"+app.config.language+"/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
};