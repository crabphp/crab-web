<?php

declare(strict_types=1);

return [
    'address' => env('SERVER_ADDRESS', 'tcp://127.0.0.1:8080'),

    // Worker processes. More than one needs PHP's pcntl and posix extensions.
    'workers' => env('SERVER_WORKERS', 1),

    // `php cua dev` restarts when a file here changes; resources holds the templates.
    'watch' => ['app', 'app.php', 'config', 'routes', '.env', 'resources'],

    // Every other setting has a default. `php cua config:publish server` writes them all, to change one.
];
