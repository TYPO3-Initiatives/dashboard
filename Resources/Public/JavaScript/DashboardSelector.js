define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var DashboardSelector = {
        triggerSelector: '.js-dashboard-addDashboard'
    };

    DashboardSelector.initialize = function() {
        $(document).on('click', DashboardSelector.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this);

            Modal.advanced({
                type: Modal.types.default,
                title: $element.data('modal-title'),
                content: $($('#dashboardSelector').html()),
                severity: Severity.notice,
                size: 'medium',
                callback: function(currentModal) {
                    currentModal.find('a.dashboardSelector-dashboard-block').on('click', function(e) {
                        currentModal.trigger('modal-dismiss');
                    });
                },
                additionalCssClasses: [
                    'dashboard-modal'
                ]
            });
        });
    };

    DashboardSelector.initialize();
    return DashboardSelector;
});
