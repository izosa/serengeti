//=include types/init.js

function App(options) {
    this.widgets = options.widgets;
    this.config = options.config;
}

App.prototype.init = function (){

    if (!window.location.origin) {
        window.location.origin = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
    }

    var _this = this;
    Object.keys(this.widgets).forEach(function (key) {
        var name = 'widget'+key.charAt(0).toUpperCase()+key.substr(1);
        if (typeof _this[name] !== "undefined") {
            _this[name](_this.widgets[key]);
        }
    });
};

App.setCookie = function(name,value,days)
{
    var d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = name+"="+value+"; "+expires;
};

App.getCookie = function (name)
{
    var name = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
};

App.getUrlVars = function () {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
};
