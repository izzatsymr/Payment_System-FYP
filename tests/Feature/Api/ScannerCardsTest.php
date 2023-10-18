<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Card;
use App\Models\Scanner;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScannerCardsTest extends TestCase
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
    public function it_gets_scanner_cards()
    {
        $scanner = Scanner::factory()->create();
        $card = Card::factory()->create();

        $scanner->cards()->attach($card);

        $response = $this->getJson(route('api.scanners.cards.index', $scanner));

        $response->assertOk()->assertSee($card->rfid);
    }

    /**
     * @test
     */
    public function it_can_attach_cards_to_scanner()
    {
        $scanner = Scanner::factory()->create();
        $card = Card::factory()->create();

        $response = $this->postJson(
            route('api.scanners.cards.store', [$scanner, $card])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $scanner
                ->cards()
                ->where('cards.id', $card->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_cards_from_scanner()
    {
        $scanner = Scanner::factory()->create();
        $card = Card::factory()->create();

        $response = $this->deleteJson(
            route('api.scanners.cards.store', [$scanner, $card])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $scanner
                ->cards()
                ->where('cards.id', $card->id)
                ->exists()
        );
    }
}
