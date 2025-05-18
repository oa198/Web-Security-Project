<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\FinancialService;
use App\Models\FinancialRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class FinancialRecordController extends Controller
{
    protected $financialService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(FinancialService $financialService)
    {   
        $this->financialService = $financialService;
        $this->middleware('auth');
        $this->middleware('permission:view-financial-record')->only(['index', 'show', 'getStudentRecords', 'getStudentBalance']);
        $this->middleware('permission:manage-financial-record')->only(['store', 'update', 'destroy', 'generateInvoice', 'processPayment']);
    }

    /**
     * Display a paginated listing of financial records.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'student_id',
            'type',
            'status',
            'payment_method',
            'date_range',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $records = $this->financialService->getAllFinancialRecords($filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $records,
            'message' => 'Financial records retrieved successfully'
        ]);
    }

    /**
     * Store a new financial record (tuition, fee, etc.).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|in:tuition,fee,payment,refund,scholarship,other',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'status' => 'required|string|in:pending,paid,partial,overdue,cancelled',
            'due_date' => 'nullable|date',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
        ]);
        
        try {
            $record = $this->financialService->createFinancialRecord(
                $request->input('student_id'),
                $request->input('type'),
                $request->input('amount'),
                $request->input('description'),
                $request->input('status'),
                $request->input('due_date'),
                $request->input('semester'),
                $request->input('academic_year')
            );
            
            return response()->json([
                'success' => true,
                'data' => $record,
                'message' => 'Financial record created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified financial record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $record = $this->financialService->getFinancialRecordById($id);
        
        return response()->json([
            'success' => true,
            'data' => $record,
            'message' => 'Financial record retrieved successfully'
        ]);
    }

    /**
     * Update the specified financial record.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'type' => 'nullable|string|in:tuition,fee,payment,refund,scholarship,other',
            'amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,paid,partial,overdue,cancelled',
            'due_date' => 'nullable|date',
        ]);
        
        try {
            $record = $this->financialService->updateFinancialRecord($id, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $record,
                'message' => 'Financial record updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified financial record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->financialService->deleteFinancialRecord($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Financial record deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get all financial records for a specific student.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentRecords(int $studentId, Request $request): JsonResponse
    {
        $filters = $request->only([
            'type',
            'status',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $records = $this->financialService->getStudentFinancialRecords($studentId, $filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $records,
            'message' => 'Student financial records retrieved successfully'
        ]);
    }

    /**
     * Get the current balance for a student.
     *
     * @param int $studentId
     * @return JsonResponse
     */
    public function getStudentBalance(int $studentId): JsonResponse
    {
        $balance = $this->financialService->getStudentBalance($studentId);
        
        return response()->json([
            'success' => true,
            'data' => [
                'student_id' => $studentId,
                'balance' => $balance,
            ],
            'message' => 'Student balance retrieved successfully'
        ]);
    }

    /**
     * Generate an invoice for a student.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function generateInvoice(int $studentId, Request $request): JsonResponse
    {
        $request->validate([
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
        ]);
        
        try {
            $invoice = $this->financialService->generateInvoice(
                $studentId, 
                $request->input('semester'),
                $request->input('academic_year')
            );
            
            return response()->json([
                'success' => true,
                'data' => $invoice,
                'message' => 'Student invoice generated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Process a payment for a student.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processPayment(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:credit_card,bank_transfer,cash,check,other',
            'reference_number' => 'required|string|max:50',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            $record = $this->financialService->processPayment(
                $request->input('student_id'),
                $request->input('amount'),
                $request->input('payment_method'),
                $request->input('reference_number'),
                $request->input('semester'),
                $request->input('academic_year'),
                $request->input('description', 'Payment received'),
                auth()->id()
            );
            
            return response()->json([
                'success' => true,
                'data' => $record,
                'message' => 'Payment processed successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
