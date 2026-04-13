<?php

use Laravel\Telescope\Watchers\CacheWatcher;
use Laravel\Telescope\Watchers\CommandWatcher;
use Laravel\Telescope\Watchers\DumpWatcher;
use Laravel\Telescope\Watchers\EventWatcher;
use Laravel\Telescope\Watchers\ExceptionWatcher;
use Laravel\Telescope\Watchers\JobWatcher;
use Laravel\Telescope\Watchers\MailWatcher;
use Laravel\Telescope\Watchers\ModelWatcher;
use Laravel\Telescope\Watchers\QueryWatcher;
use Laravel\Telescope\Watchers\ScheduleWatcher;
use Laravel\Telescope\Watchers\RequestWatcher;
use Laravel\Telescope\Watchers\RedisWatcher;
use Laravel\Telescope\Watchers\DumpWatcher as WatcherDump;
use Laravel\Telescope\Watchers\LogWatcher;

return [
    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | Enable Telescope. By default we follow `APP_DEBUG` but allow explicit
    | override via `TELESCOPE_ENABLED` environment variable.
    |
    */
    'enabled' => env('TELESCOPE_ENABLED', env('APP_DEBUG', false)),

    /*
    |--------------------------------------------------------------------------
    | Path
    |--------------------------------------------------------------------------
    |
    | Telescope UI path. Typically "/telescope".
    |
    */
    'path' => env('TELESCOPE_PATH', 'telescope'),

    /*
    |--------------------------------------------------------------------------
    | Driver / Storage
    |--------------------------------------------------------------------------
    |
    | Using database storage for Telescope so entries are persisted in our
    | application's database. Ensure migrations are published and migrated.
    |
    */
    'driver' => env('TELESCOPE_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Watchers
    |--------------------------------------------------------------------------
    |
    | Configure which watchers are active. In production keep heavy
    | watchers disabled unless explicitly enabled via env vars.
    |
    */
    'watchers' => [
        RequestWatcher::class => env('TELESCOPE_WATCH_REQUESTS', true),
        JobWatcher::class => env('TELESCOPE_WATCH_JOBS', true),
        ExceptionWatcher::class => env('TELESCOPE_WATCH_EXCEPTIONS', true),
        LogWatcher::class => env('TELESCOPE_WATCH_LOGS', true),
        QueryWatcher::class => env('TELESCOPE_WATCH_QUERIES', false),
        CommandWatcher::class => env('TELESCOPE_WATCH_COMMANDS', false),
        ScheduleWatcher::class => env('TELESCOPE_WATCH_SCHEDULES', false),
        MailWatcher::class => env('TELESCOPE_WATCH_MAIL', false),
        ModelWatcher::class => env('TELESCOPE_WATCH_MODELS', false),
        EventWatcher::class => env('TELESCOPE_WATCH_EVENTS', false),
        CacheWatcher::class => env('TELESCOPE_WATCH_CACHE', false),
        RedisWatcher::class => env('TELESCOPE_WATCH_REDIS', false),
        DumpWatcher::class => env('TELESCOPE_WATCH_DUMPS', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sensitive Data Redaction
    |--------------------------------------------------------------------------
    |
    | A list of request / response parameters that should be hidden from
    | Telescope records to avoid leaking secrets.
    |
    */
    'sensitive' => [
        'password',
        'password_confirmation',
        'current_password',
        'token',
    ],
];
