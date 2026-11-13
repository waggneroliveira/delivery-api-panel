<?php

/*
|--------------------------------------------------------------------------
| Template Modules
|--------------------------------------------------------------------------
|
| Estrutura:
|
| template
| ├── onepage
| │   └── home
| │
| ├── multipage
| │   ├── home
| │   ├── about
| │   ├── products
| │   ├── blog
| │   └── contact
| │
| ├── smtp
| ├── security_and_access_control
| └── limits
|
*/

return [
    'delivery' => [

        'onepage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'topics',
                    'benefits',    
                    'gallery',
                    'brands',
                    'product_categories',
                    'products',
                    'videos',
                    'videos',
                    'advantage',
                    'faq_session',
                    'faq',
                    'testimonials',
                    'contact',
                    'contact_leads',
                ],
            ],
        ],

        // Adiciona array multipage
        'multipage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'topics',
                    'statute',
                    'letsgo',
                    'faq_session',
                    'faq',
                    'testimonials',
                    'services',
                    'contact',
                    'gallery',
                    'about',
                    'benefits',
                    'mission',
                    'representatives',
                    'videos',
                    'service_locations',
                    'contact_leads',
                    'download_leads',
                    'announcement',
                ],
                'products' =>[
                    'brands',
                    'product_categories',
                    'products',
                ],

                'templates' => [
                    'templates',
                ],

            ]
        ],

        'smtp' => [
            'config_smtp',
        ],

        'security_and_access_control' => [
            'audit',
            'permissions',
            'users',
        ],

        'config_theme' => [
            'config_theme',
        ],

        'limits' => [
            'about' => 1,
            'advantage' => 30,
            'slides' => 1,
            'lineOfTime' => 6,
            'impactSection' => 3,
            'topics' => 4,
            'services' => 6,
            'gallery' => 3,
        ],

    ],
];