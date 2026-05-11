<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PyServiceController extends Controller
{
    public function apply(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8001/apply', [
            'student_index' => $request->student_index,
            'average_grade' => $request->average_grade,
            'scholarship_name' => $request->scholarship_name,
        ]);

        return $response->json();
    }
}
