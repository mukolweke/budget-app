<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SavingRequest;
use App\Models\Saving;
use App\Repositories\Saving\SavingRepository;
use App\Transformers\SavingTransformer;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    /**
     * SavingController constructor.
     *
     * @param SavingRepository $savingRepo
     */
    public function __construct(
        protected SavingRepository $savingRepo,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $resources = $this->savingRepo->all();

        return response()->json([
            'message' => 'Savings records',
            'data' => SavingTransformer::transformCollection($resources),
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SavingRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SavingRequest $request)
    {
        $attributes = $request->only(['month', 'amount', 'name']);

        if ($this->savingRepo->checkSavingExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The saving already exists']]], 404);
        }

        $resource = $this->savingRepo->store($attributes);

        return response()->json([
            'message' => 'Saving created successfully',
            'data' => SavingTransformer::transform($resource),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Saving $saving)
    {
        return response()->json([
            'message' => 'Saving found successfully',
            'data' => SavingTransformer::transform($saving),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SavingRequest  $request
     * @param  \App\Models\Saving  $saving
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SavingRequest $request, Saving $saving)
    {
        $attributes = $request->only(['id', 'month', 'amount', 'name']);

        if ($this->savingRepo->checkSavingExists($attributes)) {
            return response()->json(['errors' => ['name' => ['The saving already exists']]], 404);
        }

        $updated = $this->savingRepo->update($attributes, $saving);

        if (!$updated) {
            return response()->json(['errors' => ['name' => ['Unable to update saving record']]], 404);
        }

        return response()->json([
            'message' => 'Saving created successfully',
            'data' => SavingTransformer::transform($saving->fresh()),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Saving $saving
     */
    public function destroy(Saving $saving)
    {
        $saving->delete();

        return response()->json([
            'message' => 'Saving deleted successfully',
        ], 200);
    }
}
