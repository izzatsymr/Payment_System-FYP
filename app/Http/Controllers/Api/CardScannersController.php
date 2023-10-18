<?php
namespace App\Http\Controllers\Api;

use App\Models\Card;
use App\Models\Scanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScannerCollection;

class CardScannersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Card $card)
    {
        $this->authorize('view', $card);

        $search = $request->get('search', '');

        $scanners = $card
            ->scanners()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScannerCollection($scanners);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Card $card, Scanner $scanner)
    {
        $this->authorize('update', $card);

        $card->scanners()->syncWithoutDetaching([$scanner->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Card $card, Scanner $scanner)
    {
        $this->authorize('update', $card);

        $card->scanners()->detach($scanner);

        return response()->noContent();
    }
}
