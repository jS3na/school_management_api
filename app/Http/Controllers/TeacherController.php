<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::all();

        return ApiResponse::success($teachers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'salary' => 'required|numeric',
        ], [
            'user_id.required' => 'The user is required.',
            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary is numeric.'
        ]);

        $user_id = $request->input('user_id');
        $salary = $request->input('salary');

        if (Teacher::where('user_id', $user_id)->first()) return ApiResponse::error('Teacher already exists.');

        if (!User::where('id', $user_id)->first()) return ApiResponse::notFound("User not found.");

        $teacher = new Teacher();
        $teacher->user_id = $user_id;
        $teacher->salary = $salary;
        $teacher->save();

        return ApiResponse::success($teacher);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = Teacher::find($id);

        return $teacher ? ApiResponse::success($teacher) : ApiResponse::notFound('Teacher not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $teacher = Teacher::find($id);

        if (!$teacher) return ApiResponse::notFound("Teacher not found.");

        $request->validate([
            'salary' => 'required|numeric',
        ], [
            'salary.required' => 'The salary is required.',
            'salary.numeric' => 'The salary is numeric.'
        ]);

        $salary = $request->input('salary');

        $teacher->salary = $salary;
        $teacher->save();

        return ApiResponse::success($teacher);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::find($id);
    
        if (!$teacher) {
            return ApiResponse::notFound('Teacher not found.');
        }
    
        $teacher->delete();
    
        return ApiResponse::success($teacher);
    }
}
