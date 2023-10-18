<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Student;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.cards.index', compact('cards', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Card::class);

        $students = Student::pluck('name', 'id');

        return view('app.cards.create', compact('students'));
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

        return redirect()
            ->route('cards.edit', $card)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Card $card)
    {
        $this->authorize('view', $card);

        return view('app.cards.show', compact('card'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Card $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Card $card)
    {
        $this->authorize('update', $card);

        $students = Student::pluck('name', 'id');

        return view('app.cards.edit', compact('card', 'students'));
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

        return redirect()
            ->route('cards.edit', $card)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('cards.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
