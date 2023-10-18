<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;

class UserStudentsController extends Controller
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

        $students = $user
            ->students()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Student::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,other'],
            'address' => ['required', 'max:255', 'string'],
        ]);

        $student = $user->students()->create($validated);

        return new StudentResource($student);
    }
}
