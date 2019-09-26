define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
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
                    widget: $(this).data('widget-key')
                },
                'json'
            )
                .done(function( response ) {
                    _this.find('.widget-content').html(response.content);
                    _this.find('.widget-content').removeClass('hide');
                    _this.find('.widget-waiting').addClass('hide');
                });
        });
    };

    WidgetContentCollector.initialize();
    return WidgetContentCollector;
});
