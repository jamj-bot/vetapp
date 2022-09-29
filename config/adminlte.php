<?php

return [

    'type'         => 'darkmode-widget',
    'topnav_right' => true, // Or "topnav => true" to place on the left.
    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => '',
    'title_prefix' => 'VetAPP 3 |',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,


    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Vet</b>APP 3',
    'logo_img' => 'vendor/adminlte/dist/img/veterinary.png',
    'logo_img_class' => 'brand-image img-rounded elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'VetAPP 3',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => false,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => 'nav-legacy nav-child-indent nav-collapse-hide-child',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 500,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => true,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        [
            'type'         => 'darkmode-widget',
            'topnav_right' => true, // Or "topnav => true" to place on the left.
            'color_enabled' => 'secondary',
            // 'icon_enabled': The Font Awesome icon to use when dark mode is enabled ('fas fa-moon' by default).
            // 'icon_disabled': The Font Awesome icon to use when dark mode is disabled ('far fa-moon' by default).
            // 'color_enabled': The AdminLTE color to use for the icon when dark mode is enabled (for example 'primary').
            // 'color_disabled': The AdminLTE color to use for the icon when dark mode is disabled (for example 'info').
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        [
            'text'        => 'Home',
            'route'       => 'admin.index',
            'icon'        => 'fas fa-fw fa-house-user',
            'label'       => 3,
            'label_color' => 'success',
            // 'submenu'     => [
            //     [
            //         'text' => 'level_one',
            //         'url'  => '#',
            //     ],
            //     [
            //         'text'    => 'level_one',
            //         'url'     => '#',
            //         'submenu' => [
            //             [
            //                 'text' => 'level_two',
            //                 'url'  => '#',
            //             ],
            //             [
            //                 'text'    => 'level_two',
            //                 'url'     => '#',
            //                 'submenu' => [
            //                     [
            //                         'text' => 'level_three',
            //                         'url'  => '#',
            //                     ],
            //                     [
            //                         'text' => 'level_three',
            //                         'url'  => '#',
            //                     ],
            //                 ],
            //             ],
            //         ],
            //     ],
            //     [
            //         'text' => 'level_one',
            //         'url'  => '#',
            //     ],
            // ],
        ],
        // ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'user/profile',
            'icon' => 'fas fa-fw fa-user',
        ],
        // ['header' => 'MANAGE USERS'],
        [
            'text'  => 'Users',
            'route' => 'admin.users',
            'active'      => ['admin/users*'],
            'icon'  => 'fas fa-fw fa-address-book',
            'can'   => 'users_index',
        ],
        [
            'text'  => 'Pets',
            'route' => 'admin.pets.index',
            'active'      => ['admin/pets*'],
            'icon'  => 'fas fa-fw fa-dog',
            'can'   => 'pets_index',
        ],
        // [
        //     'text'        => 'Users',
        //     'url'         => '#',
        //     'icon'        => 'fas fa-fw fa-users',
        //     'submenu'     => [
        //         [
        //             'text'  => 'Index',
        //             'route' => 'admin.users',
        //             'active'      => ['admin/users*', 'admin/pets*'],
        //             'icon'  => 'fas fa-fw fa-address-book',
        //             'can'   => 'users_index',
        //         ],
        //     ],
        // ],
        // ['header' => 'VETAPP CONFIG'],
        [
            'text'  => 'Species',
            'icon'  => 'fas fa-fw fa-paw',
            'can'   => 'species_index',
            'route' => 'admin.species',
        ],
        [
            'text'  => 'Vaccines',
            'icon'  => 'fas fa-fw fa-syringe',
            'can'   => 'vaccines_index',
            'route' => 'admin.vaccines',
        ],
        [
            'text'  => 'Parasiticides',
            'icon'  => 'fas fa-fw fa-bug',
            'can'   => 'parasiticides_index',
            'route' => 'admin.parasiticides',
        ],
        [
            'text'  => 'Recycle Bin',
            'route' => 'admin.recycle-bin',
            'icon'  => 'fas fa-fw fa-trash',
            'can'   => 'trash_index',
        ],
        // ['header' => 'ACCESS CONTROL'],
        [
            'text'    => 'Permissions',
            'icon'    => 'fas fa-fw fa-lock',
            'submenu' => [
                [
                    'text'  => 'Roles',
                    'icon'  => 'fas fa-fw fa-user-tag',
                    'can'   => 'roles_index',
                    'route' => 'admin.roles',
                ],
                [
                    'text'  => 'Permissions',
                    'icon'  => 'fas fa-fw fa-key',
                    'can'   => 'permissions_index',
                    'route' => 'admin.permissions',
                ],
                [
                    'text'  => 'Assign Permissions',
                    'icon'  => 'fas fa-fw fa-door-open',
                    'can'   => 'assign_permissions_index',
                    'route' => 'admin.assign-permissions',
                ],
                // [
                //     'text'    => 'level_one',
                //     'url'     => '#',
                //     'submenu' => [
                //         [
                //             'text' => 'level_two',
                //             'url'  => '#',
                //         ],
                //         [
                //             'text'    => 'level_two',
                //             'url'     => '#',
                //             'submenu' => [
                //                 [
                //                     'text' => 'level_three',
                //                     'url'  => '#',
                //                 ],
                //                 [
                //                     'text' => 'level_three',
                //                     'url'  => '#',
                //                 ],
                //             ],
                //         ],
                //     ],
                // ],
                // [
                //     'text' => 'level_one',
                //     'url'  => '#',
                // ],
            ],
        ],
        [
            'text'       => 'Credits',
            // 'icon'       => 'fas fa-fw fa-icons',
            'icon_color' => 'danger',
            'route'      => 'admin.credits',
        ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
