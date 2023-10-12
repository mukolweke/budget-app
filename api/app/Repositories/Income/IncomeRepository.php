<?php

namespace App\Repositories\Income;

use App\Models\Income;

/**
 * IncomeRepository
 * @package App\Repositories\Income
 */
class IncomeRepository
{
    /**
     * Get all resources in storage.
     *
     * @param  Array  $attributes
     */
    public function all()
    {
        return Income::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $attributes
     */
    public function store($attributes)
    {
        return Income::create($attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     */
    public function update($attributes, Income $income)
    {
        unset($attributes['id']);
        return $income->update($attributes);
    }

    /**
     * Check if there exists resource in storage.
     *
     * @param  Array  $attributes
     */
    public function checkIncomeExists($attributes)
    {
        $query = Income::where('month', $attributes['month'])
            ->where('name', $attributes['name']);

        if (isset($attributes['id'])) {
            $query = $query->where('id', '!=', $attributes['id']);
        }

        return $query->exists();
    }
}
