<?php

return [

    /**
     * These files are needed, you can publish then and change the injection mode to asset
     * or leave as they are, so the package will inject the CDN.
     *
     * If you are using themes that aren't the default, change themes to true.
     *
     * Don't forget to add the @include('popper') in your views.
     */
    'files' => [
        'mode' => 'cdn',
        'themes' => false,
        'asset_paths' => ['vendor/laravel-popper/popper.min.js','vendor/laravel-popper/index.all.min.js'],
        'themes_path' => ['vendor/laravel-popper/themes.js'],
    ],

    /*
     * Values to use for all the tooltips, change if you want
     * You can also use the class config helpers to customize them
     */
    'defaultConfig' => [

        /*
         * Tooltip Arrow pointing the parent element
         *
         * Active true to have an arrow at the tooltip, false to not
         *
         * Type can be 'sharp' or 'round'
         */
        'arrow' => [
            'active' => false,
            'type' => 'sharp',
        ],

        /*
         * Tooltip placement based on the element
         *
         * Position can be: 'top', 'right', 'left' or 'bottom'
         *
         * Alignment will align based on the axis it is positioned.
         * Values: 'start', 'center', 'end'
         *
         */
        'placement' => [
            'position' => 'top',
            'alignment' => 'center',
        ],

        /*
         * Tooltip theme
         * Values: 'dark', 'light', 'google', 'light-border'
         */
        'theme' => 'dark',

        /*
         * What will trigger the Tooltip
         *
         */
        'trigger' => [
            'mouseenter' => true,
            'focus' => true,
            'click' => false,
        ],

        /*
         * Tooltip size
         *
         * Values: 'small', 'regular', 'large'
         */
        'size' => 'regular',

        /*
         * The distance the tooltip will have from the parent element
         *
         * Must be an integer
         */
        'distance' => 10,

        /*
         * Tooltip animation when showing/hiding and the animation duration
         *
         * Modes available are 'shift-away', 'shift-toward', 'scale', 'fade'
         *
         * Show and Hide duration must be integers
         */
        'animation' => [
            'mode' => 'shift-away',
            'show_duration' => 275,
            'hide_duration' => 250,
        ],

        /*
         * Time to wait before the Tooltip Show and Hide
         *
         * Must be integer
         */
        'delay' => [
            'show' => 0,
            'hide' => 20,
        ],
    ],
];
