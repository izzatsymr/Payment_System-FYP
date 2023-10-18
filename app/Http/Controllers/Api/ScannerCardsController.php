<?php
namespace App\Http\Controllers\Api;

use App\Models\Card;
use App\Models\Scanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardCollection;

class ScannerCardsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Scanner $scanner)
    {
        $this->authorize('view', $scanner);

        $search = $request->get('search', '');

        $cards = $scanner
            ->cards()
            ->search($search)
            ->latest()
            ->paginate();

        return new CardCollection($cards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Scanner $scanner, Card $card)
    {
        $this->authorize('update', $scanner);

        $scanner->cards()->syncWithoutDetaching([$card->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Scanner $scanner, Card $card)
    {
        $this->authorize('update', $scanner);

        $scanner->cards()->detach($card);

        return response()->noContent();
    }
}
