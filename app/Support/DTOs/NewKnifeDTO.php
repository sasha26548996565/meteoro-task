<?php

declare(strict_types=1);

namespace App\Support\DTOs;

use App\Support\Traits\Makeable;

final class NewKnifeDTO
{
    use Makeable;

    public function __construct(
        public readonly string $material,
        public readonly string $blade_length,
        public readonly string $handle,
        public readonly int $user_id,
    ) {}
}
