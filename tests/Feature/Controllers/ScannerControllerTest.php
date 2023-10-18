<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Scanner;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScannerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_scanners()
    {
        $scanners = Scanner::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('scanners.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.scanners.index')
            ->assertViewHas('scanners');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_scanner()
    {
        $response = $this->get(route('scanners.create'));

        $response->assertOk()->assertViewIs('app.scanners.create');
    }

    /**
     * @test
     */
    public function it_stores_the_scanner()
    {
        $data = Scanner::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('scanners.store'), $data);

        $this->assertDatabaseHas('scanners', $data);

        $scanner = Scanner::latest('id')->first();

        $response->assertRedirect(route('scanners.edit', $scanner));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_scanner()
    {
        $scanner = Scanner::factory()->create();

        $response = $this->get(route('scanners.show', $scanner));

        $response
            ->assertOk()
            ->assertViewIs('app.scanners.show')
            ->assertViewHas('scanner');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_scanner()
    {
        $scanner = Scanner::factory()->create();

        $response = $this->get(route('scanners.edit', $scanner));

        $response
            ->assertOk()
            ->assertViewIs('app.scanners.edit')
            ->assertViewHas('scanner');
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

        $response = $this->put(route('scanners.update', $scanner), $data);

        $data['id'] = $scanner->id;

        $this->assertDatabaseHas('scanners', $data);

        $response->assertRedirect(route('scanners.edit', $scanner));
    }

    /**
     * @test
     */
    public function it_deletes_the_scanner()
    {
        $scanner = Scanner::factory()->create();

        $response = $this->delete(route('scanners.destroy', $scanner));

        $response->assertRedirect(route('scanners.index'));

        $this->assertModelMissing($scanner);
    }
}
