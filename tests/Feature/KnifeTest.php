<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Knife;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KnifeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_knives_list(): void
    {
        $user = User::factory()->create();
        Knife::create([
            'material' => 'Сталь',
            'blade_length' => '15 см',
            'handle' => 'Дерево',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/knife');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'knives' => [
                    '*' => [
                        'id',
                        'material',
                        'blade_length',
                        'handle',
                        'user_id',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'status'
            ])
            ->assertJson(['status' => true]);
    }

    public function test_user_can_store_a_knife(): void
    {
        $user = User::factory()->create();

        $knifeData = [
            'material' => 'Сталь',
            'blade_length' => '15 см',
            'handle' => 'Дерево',
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/knife/store', $knifeData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => true,
                'knife' => [
                    'material' => 'Сталь',
                    'blade_length' => '15 см',
                    'handle' => 'Дерево',
                    'user_id' => $user->id,
                ]
            ]);

        $this->assertDatabaseHas('knives', [
            'material' => 'Сталь',
            'blade_length' => '15 см',
            'handle' => 'Дерево',
            'user_id' => $user->id,
        ]);
    }

    public function test_guest_cannot_store_knife(): void
    {
        $knifeData = [
            'material' => 'Титан',
            'blade_length' => '20 см',
            'handle' => 'Карбон',
        ];

        $response = $this->postJson('/api/knife/store', $knifeData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
