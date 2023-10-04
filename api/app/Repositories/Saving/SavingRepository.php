<?php

namespace App\Repositories\Saving;

use App\Models\Saving;

/**
 * SavingRepository
 * @package App\Repositories\Income
 */
class SavingRepository
{
    /**
     * Get all resources in storage.
     *
     * @param  Array  $attributes
     */
    public function all()
    {
        return Saving::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Array  $attributes
     */
    public function store($attributes)
    {
        return Saving::create($attributes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Array  $attributes
     *
     * @param  Saving  $saving
     */
    public function update($attributes, Saving $saving)
    {
        return $saving->update($attributes);
    }

    /**
     * Check if there exists resource in storage.
     *
     * @param  Array  $attributes
     */
    public function checkSavingExists($attributes)
    {
        return Saving::where('month', $attributes['month'])
            ->where('name', $attributes['name'])
            ->exists();
    }
}
