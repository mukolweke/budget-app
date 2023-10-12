<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Models\Income;
use App\Repositories\Income\IncomeRepository;
use App\Transformers\IncomeTransformer;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * IncomeController constructor.
     *
     * @param IncomeRepository $incomeRepo
     */
    public function __construct(
        protected IncomeRepository $incomeRepo,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $resources = $this->incomeRepo->all();

        return response()->json([
            'message' => 'Incomes records',
            'data' => IncomeTransformer::transformCollection($resources),
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IncomeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(IncomeRequest $request)
    {
        $attributes = $request->only(['month', 'amount', 'name']);

        if ($this->incomeRepo->checkIncomeExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The income already exists']]], 404);
        }

        $resource = $this->incomeRepo->store($attributes);

        return response()->json([
            'message' => 'Income created successfully',
            'data' => IncomeTransformer::transform($resource),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Income $income)
    {
        return response()->json([
            'message' => 'Income found successfully',
            'data' => IncomeTransformer::transform($income),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\Models\Income  $income
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Income $income)
    {
        $attributes = $request->only(['id', 'month', 'amount', 'name']);

        if ($this->incomeRepo->checkIncomeExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The income already exists']]], 404);
        }

        $updated = $this->incomeRepo->update($attributes, $income);

        if (!$updated) {
            return response()->json(['errors' => ['name' => ['Unable to update income record']]], 404);
        }

        return response()->json([
            'message' => 'Income created successfully',
            'data' => IncomeTransformer::transform($income->fresh()),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Income  $income
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return response()->json([
            'message' => 'Income deleted successfully',
        ], 200);
    }
}
