define(['jquery', 'chartjs'], function ($, Chart) {
    'use strict';

    let ChartInitializer = {};

    ChartInitializer.init = function (config, hash) {
        let context;
        let _canvas = $('div[data-widget-hash=' + hash + '] canvas');

        if (_canvas.length > 0) {
            context = _canvas[0].getContext('2d');
        }

        if (typeof undefined !== context) {
            let chart = new Chart(context, config)
        }
    };

    return ChartInitializer;
});
