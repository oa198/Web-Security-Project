<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AcademicTermController extends Controller
{
    /**
     * Display a listing of academic terms.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $terms = AcademicTerm::orderBy('start_date', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $terms
        ]);
    }

    /**
     * Store a newly created academic term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_terms',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_start_date' => 'required|date|before:start_date',
            'registration_end_date' => 'required|date|after:registration_start_date|before_or_equal:start_date',
            'add_drop_deadline' => 'required|date|after_or_equal:start_date|before:end_date',
            'withdrawal_deadline' => 'required|date|after:add_drop_deadline|before:end_date',
            'academic_year' => 'required|string|max:9',
            'term_type' => 'required|in:fall,spring,summer,winter',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $term = AcademicTerm::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Academic term created successfully',
            'data' => $term
        ], 201);
    }

    /**
     * Display the specified academic term.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $term = AcademicTerm::with('calendarEvents')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $term
        ]);
    }

    /**
     * Update the specified academic term.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $term = AcademicTerm::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'code' => 'string|max:50|unique:academic_terms,code,' . $id,
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'registration_start_date' => 'date|before:start_date',
            'registration_end_date' => 'date|after:registration_start_date|before_or_equal:start_date',
            'add_drop_deadline' => 'date|after_or_equal:start_date|before:end_date',
            'withdrawal_deadline' => 'date|after:add_drop_deadline|before:end_date',
            'academic_year' => 'string|max:9',
            'term_type' => 'in:fall,spring,summer,winter',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $term->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Academic term updated successfully',
            'data' => $term
        ]);
    }

    /**
     * Remove the specified academic term.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $term = AcademicTerm::findOrFail($id);
        
        // Check if term has associated data
        if ($term->calendarEvents()->count() > 0 || $term->courses()->count() > 0 || $term->exams()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete academic term with associated data'
            ], 409);
        }
        
        $term->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Academic term deleted successfully'
        ]);
    }

    /**
     * Get the current active academic term.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentTerm(): JsonResponse
    {
        $currentTerm = AcademicTerm::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
        
        if (!$currentTerm) {
            return response()->json([
                'success' => false,
                'message' => 'No active academic term found for the current date'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $currentTerm
        ]);
    }

    /**
     * Get the academic terms for registration.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegistrationTerms(): JsonResponse
    {
        $terms = AcademicTerm::where('is_active', true)
            ->where(function($query) {
                $now = now();
                $query->whereDate('registration_start_date', '<=', $now)
                      ->whereDate('registration_end_date', '>=', $now);
            })
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $terms
        ]);
    }
}
