define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var WidgetDataCollector = {
        selector: '.t3js-dashboard-widget-data-collector'
    };

    WidgetDataCollector.initialize = function() {
        $(WidgetDataCollector.selector).each(function() {
            let _this = $(this);
            $.get(
                TYPO3.settings.ajaxUrls['ext-dashboard-get-widget-data'],
                { widget: $(this).data('widget') },
                'json'
             )
            .done(function( response ) {
                $.each(response.data, function(key, value) {
                    let element = _this.find('*[data-widget-field="' + key + '"]');
                    if (element) {
                        element.html(value);
                        element.removeClass('hide');
                    }
                });

                _this.find('.card-content').removeClass('hide');
                _this.find('.card-loading').addClass('hide');
            });
        });
    };

    WidgetDataCollector.initialize();
    return WidgetDataCollector;
});
