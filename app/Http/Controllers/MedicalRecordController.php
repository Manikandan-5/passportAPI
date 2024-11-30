<?php 
namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
   
    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'disabilities' => 'required|string',
            'medical_history' => 'required|string',
            'test_results' => 'required|string',
        ]);
    
        // Create  medical record
        $medicalRecord = new MedicalRecord();
        $medicalRecord->disabilities = $request->disabilities;
        $medicalRecord->medical_history = $request->medical_history;
        $medicalRecord->test_results = $request->test_results;
        $medicalRecord->save();
    
        // Return a JSON response with the stored data
        return response()->json([
            'success' => true,
            'message' => 'Medical record created successfully.',
            'data' => $medicalRecord,
        ], 201);
    }
    
  
}