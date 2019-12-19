define(['jquery', 'TYPO3/CMS/Backend/Modal', 'TYPO3/CMS/Backend/Severity'], function ($, Modal, Severity) {
    'use strict';

    var DashboardConfigurator = {
        triggerSelector: '.js-dashboard-configureDashboard'
    };

    DashboardConfigurator.initialize = function() {
        $(document).on('click', DashboardConfigurator.triggerSelector, function(e) {
            e.preventDefault();
            var $element = $(this);

            console.log('test');

            Modal.advanced({
                type: Modal.types.default,
                title: $element.data('modal-title'),
                content: $($('#dashboardConfigurator').html()),
                severity: Severity.notice,
                size: 'medium',
                callback: function(currentModal) {
                    currentModal.find('a.dashboardConfigurator-dashboard-block').on('click', function(e) {
                        currentModal.trigger('modal-dismiss');
                    });
                },
                additionalCssClasses: [
                    'dashboard-modal'
                ]
            });
        });
    };

    DashboardConfigurator.initialize();
    return DashboardConfigurator;
});
