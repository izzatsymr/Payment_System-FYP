<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Resources\CardResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardCollection;
use App\Http\Requests\CardStoreRequest;
use App\Http\Requests\CardUpdateRequest;

class CardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Card::class);

        $search = $request->get('search', '');

        $cards = Card::search($search)
            ->latest()
            ->paginate();

        return new CardCollection($cards);
    }

    /**
     * @param \App\Http\Requests\CardStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardStoreRequest $request)
    {
        $this->authorize('create', Card::class);

        $validated = $request->validated();

        $card = Card::create($validated);

        return new CardResource($card);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Card $card)
    {
        $this->authorize('view', $card);

        return new CardResource($card);
    }

    /**
     * @param \App\Http\Requests\CardUpdateRequest $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function update(CardUpdateRequest $request, Card $card)
    {
        $this->authorize('update', $card);

        $validated = $request->validated();

        $card->update($validated);

        return new CardResource($card);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Card $card)
    {
        $this->authorize('delete', $card);

        $card->delete();

        return response()->noContent();
    }
}
