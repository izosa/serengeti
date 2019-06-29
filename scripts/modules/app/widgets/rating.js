var widgetRatingStars = $('#widgetRatingStars');
var widgetRatingMessage = $('#widgetRatingMessage');

/**
 * Display rating
 * @param {int} timeout
 */
App.prototype.widgetRatingDisplay = function (timeout)
{
    setTimeout(function () {
        $('.widgetRatingStar').each(function (i, value) {
            app.widgets.rating.stars > i ?  value.classList.add("widgetRatingStarFull") : value.classList.remove("widgetRatingStarFull");
        });
        widgetRatingMessage.html('<span temprop="widgetRatingValue">' + app.widgets.rating.stars + '</span> of ' + app.widgets.rating.count + ' ' + app.widgets.rating.label);

    }, timeout);
};

/**
 * Rating action
 */
App.prototype.widgetRating = function ()
{
    if (typeof this.widgets.rating.id !== 'undefined'){
        widgetRatingStars.rating(function (vote, event){
            if (!app.widgets.rating.isVoted) {
                $.getJSON("/"+app.widgets.rating.model+"/vote", {rate: vote, id: app.widgets.rating.id}, function (data) {
                    app.widgets.rating.isVoted = true;
                    widgetRatingMessage.html(data.message);
                    app.widgets.rating.rate = data.rate;
                    app.widgets.rating.stars = data.stars;
                    app.widgets.rating.votes = data.votes;
                    widgetRatingMessage.html(app.widgets.rating.thankyou);
                    app.widgetRatingDisplay(2000);
                });

            } else {
                widgetRatingMessage.html(app.widgets.rating.youvoted);
                app.widgetRatingDisplay(2000);
            }
        });
        app.widgetRatingDisplay(0);
    }
};