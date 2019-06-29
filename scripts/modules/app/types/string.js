String.prototype.replaceArray = function (find, replace) {
    var replaceString = this;
    for (var i = 0; i < find.length; i++) {
        // global replacement
        var pos = replaceString.indexOf(find[i]);
        while (pos > -1) {
            replaceString = replaceString.replace(find[i], replace[i]);
            pos = replaceString.indexOf(find[i]);
        }
    }
    return replaceString;
};