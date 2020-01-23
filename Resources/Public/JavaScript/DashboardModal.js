define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var DashboardModal = {
        triggerSelector: '.js-dashboard-modal'
    };

    DashboardModal.initialize = function() {
        $(document).on('click', DashboardModal.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this),
                identifier = $element.data("modal-identifier");

            Modal.advanced({
                type: Modal.types.default,
                title: $element.data('modal-title'),
                content: $($('#dashboardModal-' + identifier).html()),
                severity: Severity.notice,
                size: 'medium',
                callback: function(currentModal) {
                    currentModal.find('a.dashboardModal-' + identifier).on('click', function(e) {
                        currentModal.trigger('modal-dismiss');
                    });
                },
                additionalCssClasses: [
                    'dashboard-modal'
                ]
            });
        });
    };

    DashboardModal.initialize();
    return DashboardModal;
});
