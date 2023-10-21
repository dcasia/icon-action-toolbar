<?php

declare(strict_types = 1);

namespace DigitalCreative\IconActionToolbar;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class IconActionToolbarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Action::macro('icon', function (string $value, ?string $label = null) {

            return $this->withMeta([
                'iconActionToolbar' => [
                    'icon' => $value,
                    'label' => $label,
                ],
            ]);

        });

        Nova::serving(function (ServingNova $event): void {

            Nova::provideToScript([
                'icon_action_toolbar' => config('nova.vendors.icon_action_toolbar'),
            ]);

            Nova::script('icon-action-toolbar', __DIR__ . '/../dist/js/tool.js');
            Nova::style('icon-action-toolbar', __DIR__ . '/../dist/css/tool.css');

        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/nova.php', 'nova.vendors.icon_action_toolbar',
        );
    }
}
