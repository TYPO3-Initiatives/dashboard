define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var WidgetSelector = {
        triggerSelector: '.js-dashboard-addWidget'
    };

    WidgetSelector.initialize = function() {
        $(document).on('click', WidgetSelector.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this);

            Modal.advanced({
                type: Modal.types.default,
                title: $element.data('modal-title'),
                content: $($('#widgetSelector').html()),
                severity: Severity.notice,
                size: 'medium',
                callback: function(currentModal) {
                    currentModal.find('a.widgetSelector-widget').on('click', function(e) {
                        currentModal.trigger('modal-dismiss');
                    });
                },
                additionalCssClasses: [
                    'dashboard-modal'
                ]
            });
        });
    };

    WidgetSelector.initialize();
    return WidgetSelector;
});
