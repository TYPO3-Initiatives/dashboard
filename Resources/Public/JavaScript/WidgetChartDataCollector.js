define(['jquery'], function ($) {
    'use strict';

    var WidgetChartDataCollector = {
        selector: '.t3js-dashboard-widget-chartdata-collector'
    };

    WidgetChartDataCollector.initialize = function() {
        $(WidgetChartDataCollector.selector).each(function() {
            let _this = $(this);
            $.get(
                TYPO3.settings.ajaxUrls['ext-dashboard-get-widget-data'],
                { widget: $(this).data('widget') },
                'json'
             )
            .done(function( response ) {
                _this.find('.chartCanvas').attr('height', response.data.chartHeight);
                var ctx = _this.find('.chartCanvas')[0].getContext('2d');
                var myChart = new Chart(ctx, {
                    type: response.data.chartType,
                    data: response.data.chartData
                });

                _this.addClass('widget-chart-' + response.data.chartType);
                $.each(response.data, function(key, value) {
                    if (!(key in ['chartType', 'chartData', 'chartHeight', 'chartWidth'])) {
                        let element = _this.find('*[data-widget-field="' + key + '"]');
                        if (element) {
                            element.html(value);
                            element.removeClass('hide');
                        }

                    }
                });

                _this.find('.card-content').removeClass('hide');
                _this.find('.card-loading').addClass('hide');
            });
        });
    };

    WidgetChartDataCollector.initialize();
    return WidgetChartDataCollector;
});
