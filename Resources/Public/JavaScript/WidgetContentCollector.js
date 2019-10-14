define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity', 'chartinitializer'], function ($, Modal, Severity, ChartInitializer) {
    'use strict';

    var WidgetContentCollector = {
        selector: '.dashboard-item'
    };

    WidgetContentCollector.initialize = function() {
        $(WidgetContentCollector.selector).each(function() {
            let _this = $(this);
            $.get(
                TYPO3.settings.ajaxUrls['ext-dashboard-get-widget-content'],
                {
                    widget: _this.data('widget-key')
                },
                'json'
            )
                .done(function( response ) {
                    _this.find('.widget-content').html(response.content);
                    _this.find('.widget-content').removeClass('hide');
                    _this.find('.widget-waiting').addClass('hide');

                    if (Object.keys(response.eventdata).length > 0) {
                        _this.trigger('widgetContentRendered', response.eventdata);
                    } else {
                        _this.trigger('widgetContentRendered');
                    }
                });
        });
    };

    WidgetContentCollector.initialize();
    return WidgetContentCollector;
});
