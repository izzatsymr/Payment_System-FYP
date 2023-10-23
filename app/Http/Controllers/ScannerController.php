<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\Scanner;
use Illuminate\Http\Request;
use App\Http\Requests\ScannerStoreRequest;
use App\Http\Requests\ScannerUpdateRequest;

class ScannerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Scanner::class);

        $search = $request->get('search', '');

        $scanners = Scanner::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.scanners.index', compact('scanners', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Scanner::class);

        $users = User::pluck('name', 'id');

        return view('app.scanners.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\ScannerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScannerStoreRequest $request)
    {
        $this->authorize('create', Scanner::class);

        $validated = $request->validated();

        $scanner = Scanner::create($validated);

        return redirect()
            ->route('scanners.edit', $scanner)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Scanner $scanner)
    {
        $this->authorize('view', $scanner);

        return view('app.scanners.show', compact('scanner'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Scanner $scanner)
    {
        $this->authorize('update', $scanner);

        $users = User::pluck('name', 'id');

        return view('app.scanners.edit', compact('scanner', 'users'));
    }

    /**
     * @param \App\Http\Requests\ScannerUpdateRequest $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function update(ScannerUpdateRequest $request, Scanner $scanner)
    {
        $this->authorize('update', $scanner);

        $validated = $request->validated();

        $scanner->update($validated);

        return redirect()
            ->route('scanners.edit', $scanner)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Scanner $scanner)
    {
        $this->authorize('delete', $scanner);

        $scanner->delete();

        return redirect()
            ->route('scanners.index')
            ->withSuccess(__('crud.common.removed'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function addRecord(Request $request)
    {
        $scanners = Scanner::pluck('name', 'id');
        $cards = Card::pluck('rfid', 'id');

        return view('app.scanners.addRecord', compact('scanners', 'cards'));
    }

    /**
     * Store a new card scanner record and update the card balance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeCardScanner(Request $request)
    {
        $validated = $request->validate([
            'scanner_id' => 'required|exists:scanners,id',
            'card_id' => 'required|exists:cards,id',
        ]);

        $scanner = Scanner::find($validated['scanner_id']);
        $card = Card::find($validated['card_id']);

        // Check if the card and scanner exist
        if (!$scanner || !$card) {
            return redirect()->route('scanners.index')->withError('Card or scanner not found.');
        }

        // Calculate the new balance
        $newBalance = $card->balance - $scanner->amount;

        // Determine if the transaction was successful
        $isSuccess = $newBalance >= 0 ? 'yes' : 'no';

        // If the transaction was successful, update the card's balance
        if ($isSuccess === 'yes') {
            $card->update(['balance' => $newBalance]);
        }

        // Attach the card to the scanner with the result of the transaction
        $scanner->cards()->attach($validated['card_id'], [
            'is_success' => $isSuccess
        ]);

        return redirect()->route('scanners.index')->withSuccess(__('crud.common.created'));
    }

}