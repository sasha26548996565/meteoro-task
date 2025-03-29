<?php

declare(strict_types=1);

namespace App\Actions\Knife;

use App\Models\Knife;
use Illuminate\Http\Response;
use App\Support\DTOs\NewKnifeDTO;
use Illuminate\Support\Facades\DB;
use App\Support\Contracts\Knife\StoreKnifeContract;

final class StoreKnifeAction implements StoreKnifeContract
{
    public function __invoke(NewKnifeDTO $params): Knife
    {
        DB::beginTransaction();

        try {
            $knife = Knife::create([
                'material' => $params->material,
                'blade_length' => $params->blade_length,
                'handle' => $params->handle,
                'user_id' => $params->user_id
            ]);

            DB::commit();

            return $knife;
        } catch (\Throwable $exception) {
            DB::rollBack();
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
