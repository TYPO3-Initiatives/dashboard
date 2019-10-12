define(['jquery', 'chartjs'], function ($, Chart) {
    'use strict';

    let ChartInitializer = {
        selector: '.dashboard-item--chart'
    };

    ChartInitializer.initialize = function () {
        $(ChartInitializer.selector).on('widgetContentRendered', function (e, config) {
            let _this = $(this);
            if (typeof config.graphConfig !== 'undefined') {
                let context;
                let _canvas = _this.find('canvas');

                if (_canvas.length > 0) {
                    context = _canvas[0].getContext('2d');
                }

                if (typeof undefined !== context) {
                    let chart = new Chart(context, config.graphConfig)
                }
            }
        });
    };

    ChartInitializer.initialize();
    return ChartInitializer;
});
