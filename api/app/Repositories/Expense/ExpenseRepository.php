<?php

namespace App\Repositories\Expense;

use App\Models\Expense;

/**
 * ExpenseRepository
 * @package App\Repositories\Expense
 */
class ExpenseRepository
{
    /**
     * Get all resources in storage.
     *
     * @param  Array  $attributes
     */
    public function all()
    {
        return Expense::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $attributes
     */
    public function store($attributes)
    {
        return Expense::create($attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     */
    public function update($attributes, Expense $income)
    {
        return $income->update($attributes);
    }

    /**
     * Check if there exists resource in storage.
     *
     * @param  Array  $attributes
     */
    public function checkExpenseExists($attributes)
    {
        return Expense::where('month', $attributes['month'])
            ->where('name', $attributes['name'])
            ->exists();
    }
}
