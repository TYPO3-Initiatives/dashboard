define(['jquery', 'TYPO3/CMS/Backend/Modal'], function ($, Modal) {
    'use strict';

    var WidgetCloser = {
        triggerSelector: '.t3js-dashboard-close-widget'
    };

    WidgetCloser.initialize = function() {
        $(document).on('click', WidgetCloser.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this);

            var modal = Modal.confirm($element.data('confirm-title'), $element.data('confirm-text'));
            modal.on('confirm.button.cancel', function(e) {
                Modal.currentModal.trigger('modal-dismiss');
            });
            modal.on('confirm.button.ok', function(e) {
                Modal.currentModal.trigger('modal-dismiss');
                self.location.href = $element.data('url')
            });
        });
    };

    WidgetCloser.initialize();
    return WidgetCloser;
});
