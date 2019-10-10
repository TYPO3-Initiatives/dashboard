define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var WidgetSelector = {
        triggerSelector: '.js-dashboard-addWidget'
    };

    WidgetSelector.initialize = function() {
        $(document).on('click', WidgetSelector.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this);
            var buttons = [
                {
                    text: $element.data('button-close-text') || 'Close!',
                    active: true,
                    btnClass: 'btn-default',
                    trigger: function() {
                        Modal.currentModal.trigger('modal-dismiss');
                    }
                },
                {
                    text: $element.data('button-ok-text') || 'OK!',
                    btnClass: 'btn-primary',
                    trigger: function(evt) {
                        Modal.currentModal.trigger('modal-dismiss');
                        self.location.href = $element.attr('href')
                            .replace('%40widget', Modal.currentModal.find('select[name="widget"]').val())
                    }
                }
            ];
            Modal.advanced({
                type: Modal.types.default,
                title: $element.data('modal-title'),
                content: $($('#widgetSelector').html()),
                severity: Severity.notice,
                buttons: buttons,
                size: 'default'
            });
        });
    };

    WidgetSelector.initialize();
    return WidgetSelector;
});
