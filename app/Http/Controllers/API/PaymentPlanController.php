<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\FinancialService;
use App\Models\PaymentPlan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class PaymentPlanController extends Controller
{
    protected $financialService;

    /**
     * Constructor with dependency injection
     */
    public function __construct(FinancialService $financialService)
    {   
        $this->financialService = $financialService;
        $this->middleware('auth');
        $this->middleware('permission:view-payment-plan')->only(['index', 'show', 'getStudentPaymentPlans']);
        $this->middleware('permission:manage-payment-plan')->only(['store', 'update', 'destroy', 'generateInstallments']);
    }

    /**
     * Display a paginated listing of payment plans.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'student_id',
            'status',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $paymentPlans = $this->financialService->getAllPaymentPlans($filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $paymentPlans,
            'message' => 'Payment plans retrieved successfully'
        ]);
    }

    /**
     * Store a newly created payment plan.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
            'total_amount' => 'required|numeric|min:1',
            'down_payment' => 'nullable|numeric|min:0',
            'number_of_installments' => 'required|integer|min:1|max:12',
            'payment_frequency' => 'required|string|in:monthly,bi-monthly,weekly',
            'first_payment_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            $paymentPlan = $this->financialService->createPaymentPlan(
                $request->input('student_id'),
                $request->input('semester'),
                $request->input('academic_year'),
                $request->input('total_amount'),
                $request->input('down_payment', 0),
                $request->input('number_of_installments'),
                $request->input('payment_frequency'),
                $request->input('first_payment_date'),
                $request->input('description', 'Tuition payment plan')
            );
            
            return response()->json([
                'success' => true,
                'data' => $paymentPlan,
                'message' => 'Payment plan created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified payment plan with installments.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $paymentPlan = $this->financialService->getPaymentPlanById($id);
        
        return response()->json([
            'success' => true,
            'data' => $paymentPlan,
            'message' => 'Payment plan retrieved successfully'
        ]);
    }

    /**
     * Update the specified payment plan.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'down_payment' => 'nullable|numeric|min:0',
            'number_of_installments' => 'nullable|integer|min:1|max:12',
            'payment_frequency' => 'nullable|string|in:monthly,bi-monthly,weekly',
            'status' => 'nullable|string|in:active,completed,cancelled,defaulted',
            'first_payment_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
        ]);
        
        try {
            $paymentPlan = $this->financialService->updatePaymentPlan($id, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $paymentPlan,
                'message' => 'Payment plan updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified payment plan.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->financialService->deletePaymentPlan($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Payment plan deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get all payment plans for a specific student.
     *
     * @param int $studentId
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentPaymentPlans(int $studentId, Request $request): JsonResponse
    {
        $filters = $request->only([
            'status',
            'semester',
            'academic_year',
        ]);
        
        $perPage = $request->input('per_page', 15);
        
        $paymentPlans = $this->financialService->getStudentPaymentPlans($studentId, $filters, $perPage);
        
        return response()->json([
            'success' => true,
            'data' => $paymentPlans,
            'message' => 'Student payment plans retrieved successfully'
        ]);
    }

    /**
     * Generate installments for an existing payment plan.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function generateInstallments(int $id): JsonResponse
    {
        try {
            $installments = $this->financialService->generatePaymentPlanInstallments($id);
            
            return response()->json([
                'success' => true,
                'data' => $installments,
                'message' => 'Payment plan installments generated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Process a payment plan installment.
     *
     * @param int $paymentPlanId
     * @param Request $request
     * @return JsonResponse
     */
    public function processInstallmentPayment(int $paymentPlanId, Request $request): JsonResponse
    {
        $request->validate([
            'installment_number' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|in:credit_card,bank_transfer,cash,check,other',
            'reference_number' => 'required|string|max:50',
        ]);
        
        try {
            $result = $this->financialService->processInstallmentPayment(
                $paymentPlanId,
                $request->input('installment_number'),
                $request->input('amount'),
                $request->input('payment_method'),
                $request->input('reference_number'),
                auth()->id()
            );
            
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Installment payment processed successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
