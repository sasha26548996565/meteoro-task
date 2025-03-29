<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Knife;
use Illuminate\Http\Response;
use App\Support\DTOs\NewKnifeDTO;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Knife\StoreRequest;
use App\Support\Contracts\Knife\StoreKnifeContract;

class KnifeController extends Controller
{
    public function getList(): JsonResponse
    {
        $knives = Knife::with('user')->orderByDesc('id')->get();

        return response()->json([
            'knives' => $knives,
            'status' => true
        ], Response::HTTP_OK);
    }

    public function store(StoreRequest $request, StoreKnifeContract $action): JsonResponse
    {
        $params = $request->validated();
        $params['user_id'] = Auth::id();

        $knife = $action(NewKnifeDTO::make(...$params));

        return response()->json([
            'knife' => $knife,
            'status' => true
        ]);
    }
}
