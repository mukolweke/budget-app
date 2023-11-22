<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $month = $request->get('month') ?? Str::lower(date('M'));

        $totalIncome = Income::where('month', $month)->sum('amount');

        $totalExpense = Expense::where('month', $month)->sum('amount');

        $totalSaving = Saving::where('month', $month)->sum('amount');

        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'total_saving' => $totalSaving,
        ], 200);
    }
}
