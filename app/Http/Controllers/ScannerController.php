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
        // Fetch the necessary data for the dropdowns
        $scanners = Scanner::pluck('id');
        $cards = Card::pluck('id');

        return view('app.scanners.addRecord', compact('scanners', 'cards'));
    }

    /**
     * @param \App\Http\Requests\ScannerStoreRequest $request
     * @return \Illuminate\Http\Response
     */

    public function storeCardScanner(Request $request)
    {
        $validated = $request->validate([
            'scanner_id' => 'required|exists:scanners,id',
            'card_id' => 'required|exists:cards,id',
            'is_success' => 'required|in:yes,no',
        ]);

        $scanner = Scanner::find($validated['scanner_id']);
        $scanner->cards()->attach($validated['card_id'], [
            'is_success' => $validated['is_success']
        ]);

        return redirect()->route('scanners.index')->withSuccess(__('crud.common.created'));
    }

}