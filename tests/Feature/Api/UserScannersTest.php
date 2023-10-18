<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Scanner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserScannersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_scanners()
    {
        $user = User::factory()->create();
        $scanners = Scanner::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.scanners.index', $user));

        $response->assertOk()->assertSee($scanners[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_scanners()
    {
        $user = User::factory()->create();
        $data = Scanner::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.scanners.store', $user),
            $data
        );

        $this->assertDatabaseHas('scanners', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $scanner = Scanner::latest('id')->first();

        $this->assertEquals($user->id, $scanner->user_id);
    }
}
