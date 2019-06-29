/**
 * Init Slider widget
 */
App.prototype.widgetSlider = function()
{
    var that = app.widgets.slider;

    Object.keys(that).forEach(function(key) {
        $(key).owlCarousel(that[key]);
    });
};