<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();

        return ApiResponse::success($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'The name is required.',
        ]);

        $name = $request->input('name');

        $subject = new Subject();
        $subject->name = $name;
        $subject->save();

        return ApiResponse::success($subject);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::find($id);

        return $subject ? ApiResponse::success($subject) : ApiResponse::notFound('Subject not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $subject = Subject::find($id);

        if (!$subject) return ApiResponse::notFound("Subject not found.");

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'The name is required.',
        ]);

        $name = $request->input('name');

        $subject->name = $name;
        $subject->save();

        return ApiResponse::success($subject);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::find($id);
    
        if (!$subject) {
            return ApiResponse::notFound('Subject not found.');
        }
    
        $subject->delete();
    
        return ApiResponse::success($subject);
    }
}
