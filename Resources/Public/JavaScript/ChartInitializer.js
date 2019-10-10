define(['jquery', 'chartjs'], function ($, Chart) {
    'use strict';

    var ChartInitializer = {};

    ChartInitializer.init = function (type, hash) {
        var context;
        var _canvas = $('div[data-widget-hash=' + hash + '] canvas');

        if (_canvas.length > 0) {
            context = _canvas[0].getContext('2d');
        }

        if (typeof undefined !== context) {
            chart = new Chart(context, {
                type: type
            })
        }
    };

    return ChartInitializer;
});
