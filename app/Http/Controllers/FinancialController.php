<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{


    public function SummaryByExpenseCategory(Request $request)
    {
        $summary = Transaction::select('category_id', DB::raw('SUM(amount) as amount'))
            ->whereHas('wallet', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->whereHas('category', function ($q) {
                $q->where('type', 'EXPENSE');
            })
            ->when($request->filled('month'), function ($q) use ($request) {
                $q->whereMonth('date', $request->month);
            })
            ->when($request->filled('year'), function ($q) use ($request) {
                $q->whereYear('date', $request->year);
            })
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Get summary by expense category successful',
            'data'    => [
                'summary' => $summary
            ]
        ]);
    }



    public function SummaryByIncomeCategory(Request $request)
    {
        $summary = Transaction::select('category_id', DB::raw('SUM(amount) as amount'))
            ->whereHas('wallet', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->whereHas('category', function ($q) {
                $q->where('type', 'INCOME');
            })
            ->when($request->filled('month'), function ($q) use ($request) {
                $q->whereMonth('date', $request->month);
            })
            ->when($request->filled('year'), function ($q) use ($request) {
                $q->whereYear('date', $request->year);
            })
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Get summary by income category successful',
            'data'    => [
                'summary' => $summary
            ]
        ]);
    }
}
