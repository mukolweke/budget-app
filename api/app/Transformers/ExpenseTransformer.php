<?php

namespace App\Transformers;

use App\Models\Expense;
use Carbon\Carbon;

/**
 * Class ExpenseTransformer
 * @package App\Transformers
 */
class ExpenseTransformer
{
    /**
     * @param mixed $expenses
     * @return mixed
     */
    public static function transformCollection($expenses)
    {
        return $expenses->transform(function ($expense) {
            return self::transform($expense);
        });
    }

    /**
     * @param Expense|null $expense
     * @return array
     */
    public static function transform($expense)
    {
        return [
            'id'            => $expense->id,
            'name'          => $expense->name,
            'month'         => $expense->month,
            'amount'        => $expense->amount,
            'created on'    => Carbon::parse($expense->created_at)->format('d-m-Y'),
            'updated on'    => Carbon::parse($expense->updated_at)->format('d-m-Y'),
        ];
    }
}
