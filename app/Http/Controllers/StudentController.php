<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassM;
use App\Models\Student;
use App\Models\User;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();

        return ApiResponse::success($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'guardian' => 'required'
        ], [
            'user_id.required' => 'The user is required.',
            'birth_date.required' => 'The birth date is required.',
            'phone.required' => 'The address is required.',
            'address.required' => 'The address is required.',
            'guardian.required' => 'The guardian is required.',
        ]);

        $user_id = $request->input('user_id');
        $class_id = $request->input('class_id');
        $phone = $request->input('phone');
        $birth_date = $request->input('birth_date');
        $address = $request->input('address');
        $guardian = $request->input('guardian');

        if (Student::where('user_id', $user_id)->first()) return ApiResponse::error('Student already exists.');

        if (!User::where('id', $user_id)->first()) return ApiResponse::notFound("User not found.");

        if ($class_id && !ClassM::where('id', $class_id)->first()) return ApiResponse::notFound("Class not found.");

        $student = new Student();
        $student->user_id = $user_id;
        $student->class_id = $class_id;
        $student->phone = $phone;
        $student->birth_date = $birth_date;
        $student->address = $address;
        $student->guardian = $guardian;
        $student->save();

        return ApiResponse::success($student);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        return $student ? ApiResponse::success($student) : ApiResponse::notFound('Student not found.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $student = Student::where('id', $id)->first();

        if (!$student) return ApiResponse::notFound("Student not found.");
        
        $request->validate([
            'birth_date' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'guardian' => 'required'
        ], [
            'birth_date.required' => 'The birth date is required.',
            'phone.required' => 'The address is required.',
            'address.required' => 'The address is required.',
            'guardian.required' => 'The guardian is required.',
        ]);

        $class_id = $request->input('class_id');
        $phone = $request->input('phone');
        $birth_date = $request->input('birth_date');
        $address = $request->input('address');
        $guardian = $request->input('guardian');

        if ($class_id && !ClassM::where('id', $class_id)->first()) {
            return ApiResponse::error("Class doesn't exists.");
        }

        $student->class_id = $class_id;
        $student->phone = $phone;
        $student->birth_date = $birth_date;
        $student->address = $address;
        $student->guardian = $guardian;
        $student->save();

        return ApiResponse::success($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
    
        if (!$student) {
            return ApiResponse::notFound('Student not found.');
        }
    
        $student->delete();
    
        return ApiResponse::success($student);
    }
    
}
