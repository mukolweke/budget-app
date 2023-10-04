<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Repositories\Expense\ExpenseRepository;
use App\Transformers\ExpenseTransformer;

class ExpenseController extends Controller
{
    /**
     * ExpenseController constructor.
     *
     * @param ExpenseRepository $expenseRepo
     */
    public function __construct(
        protected ExpenseRepository $expenseRepo,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $resources = $this->expenseRepo->all();

        return response()->json([
            'message' => 'Incomes records',
            'data' => ExpenseTransformer::transformCollection($resources),
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ExpenseRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ExpenseRequest $request)
    {
        $attributes = $request->only(['month', 'amount', 'name']);

        if ($this->expenseRepo->checkExpenseExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The income already exists']]], 404);
        }

        $resource = $this->expenseRepo->store($attributes);

        return response()->json([
            'message' => 'Income created successfully',
            'data' => ExpenseTransformer::transform($resource),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Expense $expense)
    {
        return response()->json([
            'message' => 'Expense found successfully',
            'data' => ExpenseTransformer::transform($expense),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ExpenseRequest  $request
     * @param  \App\Models\Income  $income
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $attributes = $request->only(['month', 'amount', 'name']);

        if ($this->expenseRepo->checkExpenseExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The Eexpense already exists']]], 404);
        }

        $resource = $this->expenseRepo->update($attributes, $expense);

        return response()->json([
            'message' => 'Expense created successfully',
            'data' => ExpenseTransformer::transform($resource),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully',
        ], 200);
    }
}
