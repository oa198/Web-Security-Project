<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicTerm;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.academic-terms.index');
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
     * Display the specified academic term.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.academic-terms.show', ['termId' => $id]);
    }
    
    /**
     * Show the form for editing the specified academic term.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.academic-terms.edit', ['termId' => $id]);
    }
}
