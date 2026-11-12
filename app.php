<?php

declare(strict_types=1);

use App\Setup;
use Crab\App;
use Crab\Arc\ArcPlugin;
use Crab\Session\SessionPlugin;
use Crab\Session\StartSession;
use Crab\Tide\TidePlugin;

// Describes the application. `php cua` runs it and the tests load it.
// The .env file, config folder and core plugins are loaded by default. Arc renders the pages in
// resources/views, sessions keep a visit's flash messages, and Tide reads and saves the models in app/.
return App::configure(__DIR__)
    ->withPlugins([ArcPlugin::class, SessionPlugin::class, TidePlugin::class])
    // Each request may use its session; one that does not reads and writes nothing.
    ->withMiddleware(StartSession::class)
    ->withSetup(Setup::class)
    ->withRouting(routes: 'routes/web.php', commands: 'routes/console.php', health: '/up')
    ->create();
