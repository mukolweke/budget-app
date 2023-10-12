<?php

namespace App\Transformers;

use App\Models\Saving;
use Carbon\Carbon;

/**
 * Class SavingTransformer
 * @package App\Transformers
 */
class SavingTransformer
{
    /**
     * @param mixed $incomes
     * @return mixed
     */
    public static function transformCollection($savings)
    {
        return $savings->transform(function ($saving) {
            return self::transform($saving);
        });
    }

    /**
     * @param Saving|null $category
     * @return array
     */
    public static function transform($saving)
    {
        return [
            'id'            => $saving->id,
            'name'          => $saving->name,
            'month'         => $saving->month,
            'amount'        => $saving->amount,
            'created_on'    => Carbon::parse($saving->created_at)->format('d, M Y g:i A'),
            'updated_on'    => Carbon::parse($saving->updated_at)->format('d, M Y g:i A'),
        ];
    }
}
