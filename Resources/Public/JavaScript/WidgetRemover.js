define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var WidgetRemover = {
        triggerSelector: '.widget-remove'
    };

    WidgetRemover.initialize = function() {
        $(document).on('click', WidgetRemover.triggerSelector, function(e) {
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
                        self.location.href = $element.attr('href');
                    }
                }
            ];
            Modal.confirm('Warning', 'content', Severity.warning, buttons);
        });
    };

    WidgetRemover.initialize();
    return WidgetRemover;
});
