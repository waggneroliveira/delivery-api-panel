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

    /*
    |--------------------------------------------------------------------------
    | PETSHOP
    |--------------------------------------------------------------------------
    */

    'petshop' => [
        'onepage' => [
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
    
                    'about',
                    'benefits',
                    'mission',
                    'representatives',
                    'videos',
                    'service_locations',
    
                    'brands',
                    'product_categories',
                    'products',
    
                    'blog_categories',
                    'blog',
    
                    'contact',
                    'contact_leads',
                    'download_leads',
                ],
            ],    
        ],

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
                ],

                'about' => [
                    'about',
                    'benefits',
                    'mission',
                    'representatives',
                    'videos',
                    'service_locations',
                ],

                'products' => [
                    'brands',
                    'product_categories',
                    'products',
                ],

                'blog' => [
                    'blog_categories',
                    'blog',
                ],

                'contact' => [
                    'contact',
                    'contact_leads',
                    'download_leads',
                ],

            ],
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
            'slides' => 3,
            'topics' => 6,
            'testimonials' => 6,
            'faq' => 10,
            'services' => 6,
            'blog_categories' => 1,
            'blog' => 1,
        ],

    ],

    'cartorio' => [
        'tp-01' => [
            'onepage' => [
    
                'home' => [
                    'slides',
                    'topics',
                    'services',
                    'gallery',
    
                    'about',
    
                    'contact',
                    'contact_leads',
                ],
    
            ],
        ],

        // Adiciona array multipage
        /*Aqui*/

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
            'slides' => 1,
            'topics' => 3,
            'services' => 6,
            'gallery' => 3,
        ],

    ],

    'transporte' => [

        'onepage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'faq_session',
                    'faq',
                    'testimonials',
                    'services',
                    'service_locations',
                    'about',
                    'contact',
                ],
            ],

        ],

        // Adiciona array multipage
        /*Aqui*/

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
            'slides' => 3,
            'testimonials' => 6,
            'faq' => 10,
            'services' => 6,
        ],

    ],

    'whi-web' => [

        'onepage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'topics',
                    'benefits',    
                    'gallery',
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

                'templates' => [
                    'templates',
                ],

            ],
            'tp-02' => [
                'home' => [
                    'slides',
                    'topics',
                    'advantage',
                    'letsgo',
                    'lineOfTime',
                    'impactSection',
                    'testimonials',
                    'partner',
                    'about',
                    'representatives',
                    'contact',
                    'contact_leads',
                    'announcement',
                ],

                'products' => [
                    'product_categories',
                    'products',
                ]
            ],
            'tp-03' => [
                'home' => [
                    'announcement',
                ],
                'about_static' => [
                    'about_static',
                ],
                'privacy_police' => [
                    'privacy_police',
                ],
                'use_term' => [
                    'use_term',
                ],
            ],
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
            'slides' => 4,
            'lineOfTime' => 6,
            'impactSection' => 3,
            'topics' => 4,
            'services' => 6,
            'gallery' => 3,
        ],

    ],

    'provedor' => [
        'onepage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'topics',
                    'letsgo',
                    'testimonials',
                    'partner',
                    'planNetworkCategory',
                    'planNetwork',
                    'about',
                    'products',
    
                    'contact',
                    'contact_leads',
                ],
            ],

        ],

        // Adiciona array multipage
        /*Aqui*/

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
            'slides' => 3,
            'about' => 1,
            'planNetworkCategory' => 20,
            'planNetwork' => 20,
            'topics' => 3,
            'testimonials' => 6,
            'faq' => 10,
            'services' => 6,
        ],

    ],

    'ecommerce' => [
        'onepage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'topics',
                    'letsgo',
                    'testimonials',
                    'partner',
                    'planNetworkCategory',
                    'planNetwork',
                    'about',
                    'products',

                    'contact',
                    'contact_leads',
                ],
            ],
        ],

        'multipage' => [
            'tp-01' => [
                'home' => [
                    'slides',
                    'faq_session',
                    'faq',
                    'testimonials',
                ],

                'about' => [
                    'about',
                    'benefits',
                    'videos',
                ],

                'products' => [
                    'brands',
                    'product_categories',
                    'products',
                ],

                'contact' => [
                    'contact',
                    'contact_leads',
                    'download_leads',
                ],
            ],
            'tp-02' => [
                'home' => [
                    'slides',
                    'faq_session',
                    'faq',
                    'testimonials',
                    'about', 
                    'benefits',//parametro
                    'videos',
                    'contact',
                ],

                'products' => [
                    'brands',
                    'product_categories',
                    'products',
                ],
            ],

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
            'slides' => 3,
            'about' => 1,
            'planNetworkCategory' => 20,
            'planNetwork' => 20,
            'topics' => 3,
            'testimonials' => 6,
            'faq' => 10,
            'services' => 6,
            'videos' => 1,
        ],

    ],

    'blog' => [
        'multipage' => [
            'tp-01' => [
                'home' => [
                    'videos',    
                ],

                'blog' => [
                    'blog_categories',
                    'blog_sub_categories',
                    'blog',
                    'videos',
                ],

                'contact' => [
                    'contact',
                    'contact_leads',
                    'download_leads',
                ],

            ],
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
            'slides' => 3,
            'topics' => 6,
            'testimonials' => 6,
            'faq' => 10,
            'services' => 6,
            'blog_categories' => 10,
            'blog' => 35,
            'videos' => 15,
        ],

    ],
];