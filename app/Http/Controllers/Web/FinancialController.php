<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialRecord;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Scholarship;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    /**
     * Display a listing of the financial records.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        try {
            if ($user->hasRole('student')) {
                if (!$user->student) {
                    return redirect()->route('dashboard')
                        ->with('error', 'Student record not found. Please contact support.');
                }
                
                $studentId = $user->student->id;
                $financialRecords = FinancialRecord::where('student_id', $studentId)
                    ->latest()
                    ->paginate(10);
                    
                // Calculate totals
                $totalBalance = $financialRecords->sum('amount');
                $totalCharges = $financialRecords->where('amount', '>', 0)->sum('amount');
                $totalCredits = $financialRecords->where('amount', '<', 0)->sum('amount');
                
            } else {
                $financialRecords = FinancialRecord::with('student.user')
                    ->latest()
                    ->paginate(10);
                    
                // For non-student users, show summary of all records
                $totalBalance = FinancialRecord::sum('amount');
                $totalCharges = FinancialRecord::where('amount', '>', 0)->sum('amount');
                $totalCredits = FinancialRecord::where('amount', '<', 0)->sum('amount');
            }
            
            // Get recent payments (last 5)
            $recentPayments = Payment::with('financialRecord')
                ->latest()
                ->limit(5)
                ->get();
                
            // Get pending invoices if student
            $pendingInvoices = $user->hasRole('student') && $user->student
                ? Invoice::where('student_id', $user->student->id)
                    ->where('status', 'pending')
                    ->latest()
                    ->limit(5)
                    ->get()
                : collect();
            
            return view('financial.index', [
                'currentBalance' => $totalBalance,
                'totalCharges' => $totalCharges,
                'totalCredits' => $totalCredits,
                'financialRecords' => $financialRecords,
                'recentPayments' => $recentPayments,
                'pendingInvoices' => $pendingInvoices,
                'isStudent' => $user->hasRole('student'),
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in FinancialController@index: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'An error occurred while loading the financial page. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new financial record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Only available to staff
        $this->authorize('create', FinancialRecord::class);
        
        return view('financial.create');
    }

    /**
     * Store a newly created financial record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Only available to staff
        $this->authorize('create', FinancialRecord::class);
        
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:tuition,fee,scholarship,payment',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
        ]);
        
        FinancialRecord::create($validated);
        
        return redirect()->route('financial.index')
            ->with('success', 'Financial record created successfully.');
    }

    /**
     * Display the specified financial record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $financialRecord = FinancialRecord::with('student.user')->findOrFail($id);
        
        // Check if user can view this record
        $this->authorize('view', $financialRecord);
        
        return view('financial.show', compact('financialRecord'));
    }

    /**
     * Show the form for editing the specified financial record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $financialRecord = FinancialRecord::findOrFail($id);
        
        // Check if user can edit this record
        $this->authorize('update', $financialRecord);
        
        return view('financial.edit', compact('financialRecord'));
    }

    /**
     * Update the specified financial record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $financialRecord = FinancialRecord::findOrFail($id);
        
        // Check if user can update this record
        $this->authorize('update', $financialRecord);
        
        $validated = $request->validate([
            'type' => 'required|in:tuition,fee,scholarship,payment',
            'amount' => 'required|numeric',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,paid,overdue,canceled',
        ]);
        
        $financialRecord->update($validated);
        
        return redirect()->route('financial.show', $financialRecord->id)
            ->with('success', 'Financial record updated successfully.');
    }

    /**
     * Remove the specified financial record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $financialRecord = FinancialRecord::findOrFail($id);
        
        // Check if user can delete this record
        $this->authorize('delete', $financialRecord);
        
        $financialRecord->delete();
        
        return redirect()->route('financial.index')
            ->with('success', 'Financial record deleted successfully.');
    }
    
    /**
     * Display all payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function payments()
    {
        $user = Auth::user();
        
        if ($user->hasRole('student')) {
            $payments = Payment::whereHas('financialRecord', function($query) use ($user) {
                $query->where('student_id', $user->student->id);
            })
            ->with('financialRecord')
            ->latest()
            ->paginate(10);
        } else {
            $payments = Payment::with(['financialRecord.student.user'])
                ->latest()
                ->paginate(10);
        }
        
        return view('financial.payments', compact('payments'));
    }
    
    /**
     * Display all invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoices()
    {
        $user = Auth::user();
        
        if ($user->hasRole('student')) {
            $invoices = Invoice::where('student_id', $user->student->id)
                ->latest()
                ->paginate(10);
        } else {
            $invoices = Invoice::with('student.user')
                ->latest()
                ->paginate(10);
        }
        
        return view('financial.invoices', compact('invoices'));
    }
    
    /**
     * Display the financial admin dashboard.
     * Only accessible to financial officers.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard()
    {
        // Get summary statistics for financial dashboard
        $totalReceived = Payment::sum('amount');
        $totalPending = Invoice::where('status', 'pending')->sum('amount');
        $totalStudentsWithBalance = Student::where('financial_hold', true)->count();
        
        // Monthly payment statistics for charts
        $monthlyPayments = Payment::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Recent activities
        $recentPayments = Payment::with('financialRecord.student.user')
            ->latest()
            ->limit(10)
            ->get();
            
        $recentInvoices = Invoice::with('student.user')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('financial.admin.dashboard', compact(
            'totalReceived',
            'totalPending',
            'totalStudentsWithBalance',
            'monthlyPayments',
            'recentPayments',
            'recentInvoices'
        ));
    }
    
    /**
     * Display the payment processing interface for financial officers.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminPayments()
    {
        // Get all pending payments that need processing
        $pendingPayments = Payment::with('financialRecord.student.user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
            
        // Get all pending invoices
        $pendingInvoices = Invoice::with('student.user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
        
        return view('financial.admin.payments', compact('pendingPayments', 'pendingInvoices'));
    }
    
    /**
     * Display the scholarship management interface for financial officers.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminScholarships()
    {
        // Get all scholarship applications
        $scholarshipApplications = Scholarship::with('student.user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
            
        // Get all active scholarships
        $activeScholarships = Scholarship::with('student.user')
            ->where('status', 'approved')
            ->where('end_date', '>=', now())
            ->latest()
            ->paginate(15);
        
        return view('financial.admin.scholarships', compact('scholarshipApplications', 'activeScholarships'));
    }
    
    /**
     * Display the financial reports for financial officers.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminReports()
    {
        // Generate summary reports for financial data
        $yearlyRevenue = Payment::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
            
        $revenueByType = FinancialRecord::select(
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->where('amount', '>', 0)
            ->groupBy('type')
            ->get();
            
        $expensesByType = FinancialRecord::select(
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->where('amount', '<', 0)
            ->groupBy('type')
            ->get();
            
        $studentsWithHighestBalance = Student::with('user')
            ->where('financial_hold', true)
            ->orderByDesc('balance')
            ->limit(10)
            ->get();
        
        return view('financial.admin.reports', compact(
            'yearlyRevenue',
            'revenueByType',
            'expensesByType',
            'studentsWithHighestBalance'
        ));
    }
}
