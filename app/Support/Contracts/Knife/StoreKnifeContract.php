<?php

declare(strict_types=1);

namespace App\Support\Contracts\Knife;

use App\Models\Knife;
use App\Support\DTOs\NewKnifeDTO;

interface StoreKnifeContract
{
    public function __invoke(NewKnifeDTO $params): Knife;
}
