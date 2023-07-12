<?php

return [

    'name' => 'locales::general.module_name',
    'icon' => 'https://imgur.png',
    'author' => 'WemX',
    'version' => '1.0.0',
    'wemx_version' => '1.0.0',

    'elements' => [

        'main_menu' => 
        [
            // not needed
        ],

        'user_dropdown' => 
        [
            // not needed
        ],

        'admin_menu' => 
        [
            [
                'name' => 'locales::general.module_name',
                'icon' => '<i class="fas fa-solid fa-globe"></i>',
                'href' => '/admin/locales',
                'style' => '',
            ],
            // ... add more menu items
        ],

    ],

];
