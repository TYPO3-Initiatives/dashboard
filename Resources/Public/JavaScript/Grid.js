define(['jquery', 'muuri'], function ($, Muuri) {
    'use strict';

    var Grid = {};

    Grid.initialize = function() {
        var options = {
            dragEnabled: true,
            dragSortHeuristics: {
                sortInterval: 50,
                minDragDistance: 10,
                minBounceBackAngle: 1
            },
            layoutDuration: 400,
            layoutEasing: 'ease',
            dragPlaceholder: {
                enabled: true,
                duration: 400,
                createElement: function (item) {
                    return item.getElement().cloneNode(true);
                }
            },
            dragSortPredicate: {
                action:'swap',
                threshold: 30
            },
            dragReleaseDuration: 400,
            dragReleaseEasing: 'ease',
            layout: {
                fillGaps: true,
            }
        };

        var dashboard = new Muuri('.dashboard-grid', options);

        dashboard.on('dragReleaseEnd', function() {
            Grid.saveItems(dashboard);
        })
    };

    Grid.saveItems = function(dashboard) {
        console.log('saveItems');
        var widgets = dashboard.getItems().map(function (item) {
            return [
                item.getElement().getAttribute('data-widget-key'),
                item.getElement().getAttribute('data-widget-config')
            ];
        });

        $.post(
            TYPO3.settings.ajaxUrls['ext-dashboard-save-widget-positions'],
            {
                widgets: widgets
            },
            'json'
        )
            .done(function( response ) {
                console.log(response);
            });

        // return JSON.stringify(itemIds);
    };

    Grid.initialize();
    return Grid;
});
