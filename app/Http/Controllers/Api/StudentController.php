<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    /**
     * @param \App\Http\Requests\StudentStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        $this->authorize('create', Student::class);

        $validated = $request->validated();

        $student = Student::create($validated);

        return new StudentResource($student);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Student $student)
    {
        $this->authorize('view', $student);

        return new StudentResource($student);
    }

    /**
     * @param \App\Http\Requests\StudentUpdateRequest $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        $this->authorize('update', $student);

        $validated = $request->validated();

        $student->update($validated);

        return new StudentResource($student);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Student $student)
    {
        $this->authorize('delete', $student);

        $student->delete();

        return response()->noContent();
    }
}
