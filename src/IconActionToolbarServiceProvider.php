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
        Action::macro('icon', function (callable|string $value) {
            return $this->withMeta([ 'icon' => value($value) ]);
        });

        Nova::serving(function (ServingNova $event): void {

            Nova::script('icon-action-toolbar', __DIR__ . '/../dist/js/tool.js');
            Nova::style('icon-action-toolbar', __DIR__ . '/../dist/css/tool.css');

        });
    }
}
