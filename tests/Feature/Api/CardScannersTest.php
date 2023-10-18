<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Card;
use App\Models\Scanner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardScannersTest extends TestCase
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
    public function it_gets_card_scanners()
    {
        $card = Card::factory()->create();
        $scanner = Scanner::factory()->create();

        $card->scanners()->attach($scanner);

        $response = $this->getJson(route('api.cards.scanners.index', $card));

        $response->assertOk()->assertSee($scanner->name);
    }

    /**
     * @test
     */
    public function it_can_attach_scanners_to_card()
    {
        $card = Card::factory()->create();
        $scanner = Scanner::factory()->create();

        $response = $this->postJson(
            route('api.cards.scanners.store', [$card, $scanner])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $card
                ->scanners()
                ->where('scanners.id', $scanner->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_scanners_from_card()
    {
        $card = Card::factory()->create();
        $scanner = Scanner::factory()->create();

        $response = $this->deleteJson(
            route('api.cards.scanners.store', [$card, $scanner])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $card
                ->scanners()
                ->where('scanners.id', $scanner->id)
                ->exists()
        );
    }
}
