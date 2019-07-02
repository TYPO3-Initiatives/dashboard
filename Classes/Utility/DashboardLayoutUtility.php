<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Utility;

class DashboardLayoutUtility
{
    protected $layouts = [
        'default' => [
            'label' => 'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xml:layout.default',
            'rows' => [
                [
                    'cols' => [
                        [
                            'availableWidgets' => '*',
                            'colspan' => 6
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 6
                        ]
                    ]
                ],
                [
                    'cols' => [
                        [
                            'availableWidgets' => '*',
                            'colspan' => 3
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 3
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 3
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 3
                        ]
                    ]
                ],
                [
                    'cols' => [
                        [
                            'availableWidgets' => '*',
                            'colspan' => 4
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 4
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 4
                        ]
                    ]
                ],
                [
                    'cols' => [
                        [
                            'availableWidgets' => '*',
                            'colspan' => 4
                        ],
                        [
                            'availableWidgets' => '*',
                            'colspan' => 8
                        ]
                    ]
                ]
            ]
        ],
        'yoast' => [
            'label' => 'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xml:yoast'
        ],
    ];

    public function getLayouts(): array
    {
        return $this->layouts;
    }

    public function getConfiguration($layout): array
    {
        return $this->layouts[$layout];
    }
}
