<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Blade::directive('up', function ($expression): string {
            return "<?php echo Str::upper($expression); ?>";
        });

        // Implicitly grant "Super Admin" role all permissions
        Gate::before(function ($user, $ability): bool {
            return $user->hasRole('Super Admin') ? true : null;
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url): MailMessage {
            return (new MailMessage)->view(
                'mail.verify-user', compact('url')
            );
        });
    }
}
