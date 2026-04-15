<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Log\LogManager;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Skip Telescope setup in production if not enabled
        // Note: ignoreMigrations() method not available in this version
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->authorization();

        parent::boot();

        // Ensure Laravel logs are forwarded to Telescope's Log watcher so
        // they appear in the Telescope UI even if some channels bypass
        // Telescope's default listeners in this environment.
        if (class_exists(Telescope::class) && config('telescope.watchers.'.\Laravel\Telescope\Watchers\LogWatcher::class, true)) {
            Log::listen(function (...$args) {
                try {
                    // Support multiple possible signatures across Laravel versions.
                    $level = $message = null;
                    $context = [];

                    if (count($args) === 1 && is_array($args[0])) {
                        $record = $args[0];
                        $level = $record['level'] ?? ($record['level_name'] ?? null);
                        $message = $record['message'] ?? null;
                        $context = $record['context'] ?? [];
                    } else {
                        $level = $args[0] ?? null;
                        $message = $args[1] ?? null;
                        $context = $args[2] ?? [];
                    }

                    if ($message !== null) {
                        Telescope::recordLog($level, (string) $message, (array) $context);
                    }
                } catch (\Throwable $e) {
                    // Don't break the app if Telescope recording fails.
                }
            });
        }
    }

    /**
     * Register the Telescope authorization gate.
     * Only users with role 'Administrador' can view Telescope.
     */
    protected function authorization(): void
    {
        Gate::define('viewTelescope', function ($user = null) {
            if (! $user) {
                return false;
            }

            // Use Spatie roles. Accept common variations of the 'Administrador' role.
            if (! method_exists($user, 'hasAnyRole')) {
                return false;
            }

            return $user->hasAnyRole(['Administrador', 'administrador', 'admin']);
        });
    }
}
