<?php

namespace App\Transformers;

use App\Models\Income;
use Carbon\Carbon;

/**
 * Class IncomeTransformer
 * @package App\Transformers
 */
class IncomeTransformer
{
    /**
     * @param mixed $incomes
     * @return mixed
     */
    public static function transformCollection($incomes)
    {
        return $incomes->transform(function ($income) {
            return self::transform($income);
        });
    }

    /**
     * @param Income|null $category
     * @return array
     */
    public static function transform($income)
    {
        return [
            'id'            => $income->id,
            'name'          => $income->name,
            'month'         => $income->month,
            'amount'        => $income->amount,
            'created_on'    => Carbon::parse($income->created_at)->format('d, M Y g:i A'),
            'updated_on'    => Carbon::parse($income->updated_at)->format('d, M Y g:i A'),
        ];
    }
}
