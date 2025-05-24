<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
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
     * Display a listing of programs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.programs.index');
    }
    
    /**
     * Show the form for creating a new program.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.programs.create');
    }
    
    /**
     * Display the specified program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.programs.show', ['programId' => $id]);
    }
    
    /**
     * Show the form for editing the specified program.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.programs.edit', ['programId' => $id]);
    }
    
    /**
     * Show the form for managing program requirements.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageRequirements($id)
    {
        return view('admin.programs.manage-requirements', ['programId' => $id]);
    }
    
    /**
     * Show the form for managing program prerequisites.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function managePrerequisites($id)
    {
        return view('admin.programs.manage-prerequisites', ['programId' => $id]);
    }
}
