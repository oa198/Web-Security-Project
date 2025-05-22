<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('web.enrollments.index');
    }

    public function create()
    {
        return view('web.enrollments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        // Check if student already has a pending or approved enrollment for this course
        $existingEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $request->course_id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingEnrollment) {
            return response()->json(['message' => 'You already have a pending or approved enrollment for this course.'], 400);
        }

        // Create new enrollment request
        $enrollment = Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Enrollment request submitted successfully. Please wait for approval.'], 200);
    }

    public function show($id)
    {
        return view('web.enrollments.show', compact('id'));
    }

    public function edit($id)
    {
        return view('web.enrollments.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Update enrollment logic
        return redirect()->route('web.enrollments.index')->with('success', 'Enrollment updated successfully');
    }

    public function destroy($id)
    {
        // Delete enrollment logic
        return redirect()->route('web.enrollments.index')->with('success', 'Enrollment deleted successfully');
    }

    public function approve(Enrollment $enrollment)
    {
        if (!Auth::user()->hasRole('admission_officer')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $enrollment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Enrollment request approved successfully.');
    }

    public function reject(Request $request, Enrollment $enrollment)
    {
        if (!Auth::user()->hasRole('admission_officer')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $enrollment->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Enrollment request rejected successfully.');
    }
} 