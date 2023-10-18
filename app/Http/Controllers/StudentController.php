<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view('app.students.index', compact('students', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Student::class);

        $users = User::pluck('name', 'id');

        return view('app.students.create', compact('users'));
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

        return redirect()
            ->route('students.edit', $student)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Student $student)
    {
        $this->authorize('view', $student);

        return view('app.students.show', compact('student'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Student $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        $users = User::pluck('name', 'id');

        return view('app.students.edit', compact('student', 'users'));
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

        return redirect()
            ->route('students.edit', $student)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('students.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
