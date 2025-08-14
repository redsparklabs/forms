<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Component Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root namespace for Livewire component classes in
    | your application. This value will change where component auto-discovery
    | finds components. Change this value if you have a different namespace.
    |
    */

    'class_namespace' => 'App\\Http\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path for Livewire component views. This should be
    | relative to your root views directory. Change this value if you want
    | to store your Livewire component views in a different location.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | The default layout view that will be used when rendering a component via
    | Route::get('/some-endpoint', SomeComponent::class);. In this case the 
    | the view returned by SomeComponent will be wrapped in layouts.app
    |
    */

    'layout' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Livewire Assets URL
    |--------------------------------------------------------------------------
    |
    | This value sets the path to Livewire JavaScript assets, for cases where
    | your app's domain root is not the correct path. By default, Livewire
    | will load its JavaScript assets from the site's root relative path.
    |
    */

    'asset_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire App URL
    |--------------------------------------------------------------------------
    |
    | This value should be used if livewire assets are served from CDN.
    | Livewire will communicate with an app through this url.
    |
    */

    'app_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Livewire Endpoint Middleware Group
    |--------------------------------------------------------------------------
    |
    | This value sets the middleware group that will be applied to the main
    | Livewire message endpoint. The "web" middleware is the default, but
    | you can change this to any middleware group you need.
    |
    */

    'middleware_group' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Livewire Temporary File Uploads
    |--------------------------------------------------------------------------
    |
    | Livewire handles file uploads by storing uploads in a temporary directory
    | before the file is stored permanently. All file uploads are directed to
    | a global endpoint for temporary storage. You may configure this below:
    |
    */

    'temporary_file_upload' => [
        'disk' => null,        // Example: 'local', 's3' 
        'rules' => null,       // Example: ['file', 'mimes:png,jpg,jpeg', 'max:1024']
        'directory' => null,   // Example: 'tmp'
        'middleware' => null,  // Example: 'throttle:5,1' // Max 5 uploads per minute per user.
        'preview_mimes' => [   // Supported file types for temporary pre-signed file URLs.
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'wav', 'mp4', 'x-ms-wmv', 'x-msvideo', 'x-flac',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Manifest File Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path to the Livewire manifest file.
    | The default should work for most cases (which is
    | `<app('bootstrap/cache')>/livewire-components.php`), but for specific
    | cases like when hosting on Laravel Vapor, it could be set to a different value.
    |
    | Example: for Laravel Vapor, it would be "/tmp/storage/bootstrap/cache/livewire-components.php"
    |
    */

    'manifest_path' => null,
];
