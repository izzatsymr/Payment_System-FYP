<?php

namespace App\Http\Controllers\Api;

use App\Models\Scanner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScannerResource;
use App\Http\Resources\ScannerCollection;
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
            ->paginate();

        return new ScannerCollection($scanners);
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

        return new ScannerResource($scanner);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scanner $scanner
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Scanner $scanner)
    {
        $this->authorize('view', $scanner);

        return new ScannerResource($scanner);
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

        return new ScannerResource($scanner);
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

        return response()->noContent();
    }
}
