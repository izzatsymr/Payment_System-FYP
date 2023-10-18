<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScannerResource;
use App\Http\Resources\ScannerCollection;

class UserScannersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $scanners = $user
            ->scanners()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScannerCollection($scanners);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Scanner::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'mode' => ['required', 'in:pay,setup'],
        ]);

        $scanner = $user->scanners()->create($validated);

        return new ScannerResource($scanner);
    }
}
