<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassM;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = ClassM::all();

        return ApiResponse::success($classes);
    }

    public function students($id)
    {
        $class = ClassM::find($id);

        return ApiResponse::success($class->students);
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

        $class = new ClassM();
        $class->name = $name;
        $class->save();

        return ApiResponse::success($class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $class = ClassM::with('students')->find($id);

        return $class ? ApiResponse::success($class) : ApiResponse::notFound('Class not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $class = ClassM::find($id);

        if (!$class) return ApiResponse::notFound("Class not found.");

        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'The name is required.'
        ]);

        $name = $request->input('name');

        $class->name = $name;
        $class->save();

        return ApiResponse::success($class);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = ClassM::find($id);
    
        if (!$class) {
            return ApiResponse::notFound('Class not found.');
        }
    
        $class->delete();
    
        return ApiResponse::success($class);
    }
}
