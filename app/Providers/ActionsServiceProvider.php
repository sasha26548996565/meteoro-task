<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Knife\StoreKnifeAction;
use Illuminate\Support\ServiceProvider;
use App\Actions\Auth\RegisterNewUserAction;
use App\Support\Contracts\Knife\StoreKnifeContract;
use App\Support\Contracts\Auth\RegisterNewUserContract;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
        StoreKnifeContract::class => StoreKnifeAction::class,
    ];
}
