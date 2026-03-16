<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ScholarshipCall;
use Illuminate\Http\Request;
use App\Models\University;

class CountController extends Controller
{
    public function studentsCount()
    {
        $count = Student::count();

        return response()->json([
            'students_count' => $count
        ]);
    }

    public function scholarshipCallCount()
    {
        $count = ScholarshipCall::where('status', 'open')->count();

        return response()->json([
            'open_scholarship_calls_count' => $count
        ]);
    }

    public function universityCount()
    {
        $count = University::count();
        
        return response()->json([
            'universities_count' => $count
        ]);
    }
}