<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicTermController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|registrar']);
    }

    /**
     * Display a listing of academic terms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicTerms = AcademicTerm::orderBy('start_date', 'desc')->paginate(10);
        
        return view('admin.academic-terms.index', compact('academicTerms'));
    }

    /**
     * Show the form for creating a new academic term.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.academic-terms.create');
    }

    /**
     * Store a newly created academic term in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        AcademicTerm::create($request->all());

        return redirect()->route('admin.academic-terms.index')
            ->with('success', 'Academic term created successfully');
    }

    /**
     * Display the specified academic term.
     *
     * @param  \App\Models\AcademicTerm  $academicTerm
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicTerm $academicTerm)
    {
        $academicTerm->load('calendarEvents');
        
        return view('admin.academic-terms.show', compact('academicTerm'));
    }

    /**
     * Show the form for editing the specified academic term.
     *
     * @param  \App\Models\AcademicTerm  $academicTerm
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicTerm $academicTerm)
    {
        return view('admin.academic-terms.edit', compact('academicTerm'));
    }

    /**
     * Update the specified academic term in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicTerm  $academicTerm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicTerm $academicTerm)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_terms,code,' . $academicTerm->id,
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle the case where we're setting a new term as active
        if ($request->has('is_active') && $request->boolean('is_active') && !$academicTerm->is_active) {
            // Deactivate all other terms if this one is being activated
            AcademicTerm::where('id', '!=', $academicTerm->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $academicTerm->update($request->all());

        return redirect()->route('admin.academic-terms.index')
            ->with('success', 'Academic term updated successfully');
    }

    /**
     * Remove the specified academic term from storage.
     *
     * @param  \App\Models\AcademicTerm  $academicTerm
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicTerm $academicTerm)
    {
        // Check if term has associated data
        if ($academicTerm->calendarEvents()->count() > 0 || 
            $academicTerm->courses()->count() > 0 || 
            $academicTerm->exams()->count() > 0) {
            
            return redirect()->route('admin.academic-terms.index')
                ->with('error', 'Cannot delete academic term with associated data');
        }
        
        $academicTerm->delete();
        
        return redirect()->route('admin.academic-terms.index')
            ->with('success', 'Academic term deleted successfully');
    }
}
