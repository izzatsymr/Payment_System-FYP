<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Scanner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScannerTest extends TestCase
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
    public function it_gets_scanners_list()
    {
        $scanners = Scanner::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.scanners.index'));

        $response->assertOk()->assertSee($scanners[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_scanner()
    {
        $data = Scanner::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.scanners.store'), $data);

        $this->assertDatabaseHas('scanners', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_scanner()
    {
        $scanner = Scanner::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomNumber(1),
            'mode' => 'pay',
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.scanners.update', $scanner),
            $data
        );

        $data['id'] = $scanner->id;

        $this->assertDatabaseHas('scanners', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_scanner()
    {
        $scanner = Scanner::factory()->create();

        $response = $this->deleteJson(route('api.scanners.destroy', $scanner));

        $this->assertModelMissing($scanner);

        $response->assertNoContent();
    }
}
